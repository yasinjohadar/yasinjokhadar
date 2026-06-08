<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'migrate:sync-existing')]
class SyncExistingMigrationsCommand extends Command
{
    protected $signature = 'migrate:sync-existing
                            {--database= : The database connection to use}
                            {--force : Force the operation to run when in production}
                            {--dry-run : Show what would happen without making changes}';

    protected $description = 'مزامنة الـ migrations مع الجداول الموجودة مسبقاً على السيرفر';

    public function handle(Migrator $migrator): int
    {
        if (! $this->option('force') && $this->laravel->environment('production')) {
            if (! $this->confirm('أنت في بيئة الإنتاج. هل تريد المتابعة؟')) {
                return Command::FAILURE;
            }
        }

        $connection = $this->option('database');
        if ($connection) {
            $migrator->setConnection($connection);
        }

        $repository = $migrator->getRepository();

        if (! $repository->repositoryExists()) {
            $this->call('migrate:install', array_filter([
                '--database' => $connection,
            ]));
        }

        $files = $migrator->getMigrationFiles([$this->laravel->databasePath('migrations')]);
        $ran = $repository->getRan();
        $pending = array_values(array_diff(array_keys($files), $ran));

        if ($pending === []) {
            $this->info('لا توجد migrations معلّقة — قاعدة البيانات محدّثة.');

            return Command::SUCCESS;
        }

        $this->info('عدد الـ migrations المعلّقة: '.count($pending));
        $dryRun = (bool) $this->option('dry-run');

        foreach ($pending as $migration) {
            $relativePath = 'database/migrations/'.$migration.'.php';

            if ($this->migrationAlreadyApplied($migration)) {
                $this->line("<fg=yellow>تخطّي (موجود مسبقاً):</> {$migration}");

                if (! $dryRun) {
                    $repository->log($migration, $repository->getNextBatchNumber());
                }

                continue;
            }

            $this->line("<fg=cyan>تشغيل:</> {$migration}");

            if ($dryRun) {
                continue;
            }

            try {
                Artisan::call('migrate', array_filter([
                    '--path' => $relativePath,
                    '--force' => true,
                    '--database' => $connection,
                ]));

                $output = trim(Artisan::output());
                if ($output !== '') {
                    $this->line($output);
                }
            } catch (QueryException $e) {
                if ($this->isAlreadyExistsError($e)) {
                    $this->warn("تم تسجيلها كمنفّذة (الجدول/العمود موجود): {$migration}");
                    $repository->log($migration, $repository->getNextBatchNumber());

                    continue;
                }

                $this->error("فشل: {$migration}");
                $this->error($e->getMessage());

                return Command::FAILURE;
            }
        }

        $this->newLine();
        $this->info($dryRun ? 'معاينة فقط — لم يُجرَ أي تغيير.' : 'تمت المزامنة بنجاح.');

        return Command::SUCCESS;
    }

    protected function migrationAlreadyApplied(string $migration): bool
    {
        if (preg_match('/_create_(.+)_table$/', $migration, $matches)) {
            return Schema::hasTable($matches[1]);
        }

        if (preg_match('/_add_.+_to_(.+)_table$/', $migration, $matches)) {
            $table = $matches[1];

            if ($table === 'testimonials' && Str::contains($migration, 'approval_fields')) {
                return Schema::hasColumn('testimonials', 'status')
                    && Schema::hasColumn('testimonials', 'student_email')
                    && Schema::hasColumn('testimonials', 'is_public_submission');
            }

            if ($table === 'courses' && Str::contains($migration, 'text_lists')) {
                return Schema::hasColumn('courses', 'what_you_learn')
                    || Schema::hasColumn('courses', 'requirements');
            }
        }

        return false;
    }

    protected function isAlreadyExistsError(QueryException $e): bool
    {
        $sqlState = $e->errorInfo[0] ?? '';
        $driverCode = (int) ($e->errorInfo[1] ?? 0);

        return in_array($sqlState, ['42S01', '42S21'], true)
            || in_array($driverCode, [1050, 1060, 1061], true);
    }
}
