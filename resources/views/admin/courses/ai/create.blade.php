@extends('admin.layouts.master')

@section('page-title')
إنشاء كورس بالذكاء الاصطناعي
@stop

@section('styles')
<style>
.loading-spinner { display: none; }
.loading-spinner.active { display: inline-block; }
#generatedContent { display: none; }
.lesson-block { border-right: 3px solid #0d6efd; padding: 0.75rem; margin-bottom: 0.5rem; background: #f8f9fa; border-radius: 4px; }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">إنشاء كورس بالذكاء الاصطناعي</h4>
                <p class="mb-0 text-muted">توليد كورس كامل (تفاصيل، أقسام، ودروس) ثم حفظه</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-2"></i> رجوع للقائمة
                </a>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- AI Generation Card -->
        <div class="card custom-card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="card-title">
                    <i class="fas fa-robot me-2"></i>
                    إعدادات التوليد بالذكاء الاصطناعي
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">موضوع / عنوان الكورس <span class="text-danger">*</span></label>
                    <input type="text" id="topic" class="form-control" placeholder="مثال: Laravel للمبتدئين">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">موديل AI</label>
                        <select id="ai_model_id" class="form-select">
                            <option value="">استخدام الموديل الافتراضي</option>
                            @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تصنيف الكورس</label>
                        <select id="course_category_id_generate" class="form-select">
                            <option value="">اختياري عند التوليد</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">اللغة</label>
                        <select id="language" class="form-select">
                            <option value="ar" selected>العربية</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">المستوى</label>
                        <input type="text" id="level" class="form-control" value="مبتدئ" placeholder="مبتدئ / متوسط / متقدم">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">عدد الأقسام</label>
                        <select id="sections_count" class="form-select">
                            @for($i = 2; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">عمق المحتوى</label>
                    <select id="content_depth" class="form-select">
                        <option value="short">قصير</option>
                        <option value="medium" selected>متوسط</option>
                        <option value="full">كامل</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-lg w-100" id="generateBtn">
                    <i class="fas fa-magic me-2"></i>
                    <span class="btn-text">توليد المحتوى</span>
                    <span class="spinner-border spinner-border-sm loading-spinner ms-2" role="status"></span>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.courses.ai.store') }}" method="POST" id="aiCourseForm">
            @csrf
            <input type="hidden" name="generated_course" id="generated_course">
            <div class="mb-3">
                <label class="form-label">تصنيف الكورس (للحفظ) <span class="text-danger">*</span></label>
                <select name="course_category_id" id="course_category_id" class="form-select" required>
                    <option value="">اختر التصنيف</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="generatedContent">
                <div class="alert alert-info">
                    تم توليد المحتوى. راجع البيانات أدناه وعدّل إن لزم، ثم اختر التصنيف واضغط "حفظ الكورس".
                </div>

                <div class="card custom-card mb-4">
                    <div class="card-header">
                        <div class="card-title">بيانات الكورس</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" id="course_title" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الرابط (Slug)</label>
                                <input type="text" id="course_slug" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف القصير</label>
                            <textarea id="course_short_description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف الكامل</label>
                            <textarea id="course_description" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">المستوى</label>
                                <input type="text" id="course_level" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">اللغة</label>
                                <input type="text" id="course_language" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">المدة (ساعات)</label>
                                <input type="number" id="course_duration_hours" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">نقاط تميز (سطر لكل نقطة)</label>
                            <textarea id="course_highlights" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ماذا سيتعلم (سطر لكل عنصر)</label>
                            <textarea id="course_learn_items" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المتطلبات (سطر لكل متطلب)</label>
                            <textarea id="course_requirements" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" id="course_meta_title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea id="course_meta_description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card custom-card mb-4">
                    <div class="card-header">
                        <div class="card-title">الأقسام والدروس</div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="sectionsAccordion"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-save me-2"></i> حفظ الكورس
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let generatedData = null;

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.getElementById('generateBtn').addEventListener('click', function() {
        const topic = document.getElementById('topic').value.trim();
        if (!topic) {
            Swal.fire({ icon: 'error', title: 'خطأ', text: 'أدخل موضوع/عنوان الكورس' });
            return;
        }
        const btn = this;
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.loading-spinner');
        btn.disabled = true;
        btnText.textContent = 'جاري التوليد...';
        spinner.classList.add('active');

        fetch('{{ route("admin.courses.ai.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                topic: topic,
                ai_model_id: document.getElementById('ai_model_id').value || null,
                course_category_id: document.getElementById('course_category_id_generate').value || null,
                language: document.getElementById('language').value,
                level: document.getElementById('level').value,
                sections_count: parseInt(document.getElementById('sections_count').value, 10),
                content_depth: document.getElementById('content_depth').value,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                generatedData = data.data;
                fillCourseForm(generatedData);
                renderSections(generatedData.sections);
                document.getElementById('generatedContent').style.display = 'block';
                const catId = document.getElementById('course_category_id_generate').value;
                if (catId) document.getElementById('course_category_id').value = catId;
                Swal.fire({ icon: 'success', title: 'تم التوليد بنجاح', text: 'راجع المحتوى وعدّل ثم احفظ.', timer: 3000 });
            } else {
                Swal.fire({ icon: 'error', title: 'خطأ', text: data.message || 'فشل التوليد' });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'خطأ', text: 'حدث خطأ في الاتصال' });
        })
        .finally(() => {
            btn.disabled = false;
            btnText.textContent = 'توليد المحتوى';
            spinner.classList.remove('active');
        });
    });

    function fillCourseForm(data) {
        const c = data.course || {};
        document.getElementById('course_title').value = c.title || '';
        document.getElementById('course_slug').value = c.slug || '';
        document.getElementById('course_short_description').value = c.short_description || '';
        document.getElementById('course_description').value = c.description || '';
        document.getElementById('course_level').value = c.level || '';
        document.getElementById('course_language').value = c.language || '';
        document.getElementById('course_duration_hours').value = c.duration_hours || 1;
        document.getElementById('course_highlights').value = Array.isArray(c.highlights) ? c.highlights.join('\n') : (c.highlights || '');
        document.getElementById('course_learn_items').value = Array.isArray(c.learn_items) ? c.learn_items.join('\n') : (c.learn_items || '');
        document.getElementById('course_requirements').value = Array.isArray(c.requirements) ? c.requirements.join('\n') : (c.requirements || '');
        document.getElementById('course_meta_title').value = c.meta_title || '';
        document.getElementById('course_meta_description').value = c.meta_description || '';
    }

    function renderSections(sections) {
        const accordion = document.getElementById('sectionsAccordion');
        accordion.innerHTML = '';
        (sections || []).forEach(function(sec, si) {
            const secId = 'sec' + si;
            const div = document.createElement('div');
            div.className = 'accordion-item';
            div.innerHTML =
                '<h2 class="accordion-header">' +
                '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' + secId + '">' +
                'قسم ' + (si + 1) + ': ' + (sec.title || '') + '</button></h2>' +
                '<div id="' + secId + '" class="accordion-collapse collapse" data-bs-parent="#sectionsAccordion">' +
                '<div class="accordion-body section-block" data-section-index="' + si + '">' +
                '<div class="mb-3"><label class="form-label">عنوان القسم</label><input type="text" class="form-control section_title" value="' + (sec.title || '').replace(/"/g, '&quot;') + '"></div>' +
                '<div class="mb-3"><label class="form-label">وصف القسم</label><textarea class="form-control section_description" rows="2">' + (sec.description || '') + '</textarea></div>' +
                '<div class="mb-3"><label class="form-label">ترتيب القسم</label><input type="number" class="form-control section_order" value="' + (sec.order ?? si) + '"></div>' +
                '<div class="lessons-container"></div></div></div>';
            accordion.appendChild(div);
            const lessonsContainer = div.querySelector('.lessons-container');
            (sec.lessons || []).forEach(function(les, li) {
                const lessonDiv = document.createElement('div');
                lessonDiv.className = 'lesson-block';
                lessonDiv.innerHTML =
                    '<div class="row"><div class="col-md-6 mb-2"><label class="form-label small">عنوان الدرس</label><input type="text" class="form-control form-control-sm lesson_title" value="' + (les.title || '').replace(/"/g, '&quot;') + '"></div>' +
                    '<div class="col-md-6 mb-2"><label class="form-label small">Slug</label><input type="text" class="form-control form-control-sm lesson_slug" value="' + (les.slug || '').replace(/"/g, '&quot;') + '"></div></div>' +
                    '<div class="mb-2"><label class="form-label small">ملخص</label><textarea class="form-control form-control-sm lesson_summary" rows="1">' + (les.summary || '') + '</textarea></div>' +
                    '<div class="mb-2"><label class="form-label small">محتوى الدرس</label><textarea class="form-control lesson_content" rows="4">' + escapeHtml((les.content || '')) + '</textarea></div>' +
                    '<div class="row"><div class="col-4 mb-2"><label class="form-label small">المدة (دقيقة)</label><input type="number" class="form-control form-control-sm lesson_duration_minutes" value="' + (les.duration_minutes ?? 15) + '" min="1"></div>' +
                    '<div class="col-4 mb-2"><label class="form-label small">الترتيب</label><input type="number" class="form-control form-control-sm lesson_order" value="' + (les.order ?? li) + '"></div>' +
                    '<div class="col-4 mb-2 pt-4"><div class="form-check"><input type="checkbox" class="form-check-input lesson_is_preview" ' + (les.is_preview ? 'checked' : '') + '><label class="form-check-label small">معاينة مجانية</label></div></div></div>';
                lessonsContainer.appendChild(lessonDiv);
            });
        });
    }

    document.getElementById('aiCourseForm').addEventListener('submit', function(e) {
        if (!generatedData) {
            e.preventDefault();
            Swal.fire({ icon: 'error', title: 'خطأ', text: 'يجب توليد المحتوى أولاً' });
            return;
        }
        const payload = buildPayloadFromForm();
        document.getElementById('generated_course').value = JSON.stringify(payload);
    });

    function buildPayloadFromForm() {
        const course = {
            title: document.getElementById('course_title').value,
            slug: document.getElementById('course_slug').value,
            short_description: document.getElementById('course_short_description').value,
            description: document.getElementById('course_description').value,
            level: document.getElementById('course_level').value,
            language: document.getElementById('course_language').value,
            duration_hours: parseInt(document.getElementById('course_duration_hours').value, 10) || 1,
            highlights: document.getElementById('course_highlights').value.split('\n').map(s => s.trim()).filter(Boolean),
            learn_items: document.getElementById('course_learn_items').value.split('\n').map(s => s.trim()).filter(Boolean),
            requirements: document.getElementById('course_requirements').value.split('\n').map(s => s.trim()).filter(Boolean),
            meta_title: document.getElementById('course_meta_title').value,
            meta_description: document.getElementById('course_meta_description').value,
            is_active: true,
            students_count: 0
        };
        const sections = [];
        document.querySelectorAll('.section-block').forEach(function(block) {
            const title = block.querySelector('.section_title').value;
            const description = block.querySelector('.section_description').value;
            const order = parseInt(block.querySelector('.section_order').value, 10) || 0;
            const lessons = [];
            block.querySelectorAll('.lesson-block').forEach(function(lb) {
                lessons.push({
                    title: lb.querySelector('.lesson_title').value,
                    slug: lb.querySelector('.lesson_slug').value,
                    summary: lb.querySelector('.lesson_summary').value,
                    content: lb.querySelector('.lesson_content').value,
                    duration_minutes: parseInt(lb.querySelector('.lesson_duration_minutes').value, 10) || 15,
                    order: parseInt(lb.querySelector('.lesson_order').value, 10) || 0,
                    is_preview: lb.querySelector('.lesson_is_preview').checked
                });
            });
            sections.push({ title, description, order, lessons });
        });
        return { course, sections };
    }
});
</script>
@endpush
