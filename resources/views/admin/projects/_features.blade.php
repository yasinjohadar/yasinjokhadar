@php
    $features = old('features', isset($project) ? $project->features->map(fn($f) => ['title' => $f->title, 'description' => $f->description, 'icon' => $f->icon])->toArray() : []);
    if (empty($features)) $features = [['title' => '', 'description' => '', 'icon' => '']];
@endphp
<div class="card custom-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">ميزات المشروع</div>
        <button type="button" class="btn btn-sm btn-primary" id="addFeatureRow">
            <i class="bi bi-plus-lg"></i> إضافة ميزة
        </button>
    </div>
    <div class="card-body">
        <div id="featureRows">
            @foreach($features as $i => $f)
            <div class="feature-row border rounded p-3 mb-3 position-relative">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-feature-row" aria-label="حذف"><i class="bi bi-trash"></i></button>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label small">عنوان الميزة</label>
                        <input type="text" name="features[{{ $i }}][title]" class="form-control form-control-sm" value="{{ $f['title'] ?? '' }}" placeholder="مثال: واجهة مستخدم حديثة">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">أيقونة (Font Awesome)</label>
                        <input type="text" name="features[{{ $i }}][icon]" class="form-control form-control-sm" value="{{ $f['icon'] ?? '' }}" placeholder="fas fa-check">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small">الوصف</label>
                        <input type="text" name="features[{{ $i }}][description]" class="form-control form-control-sm" value="{{ $f['description'] ?? '' }}" placeholder="وصف مختصر">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var idx = {{ count($features) }};
    document.getElementById('addFeatureRow')?.addEventListener('click', function() {
        var tpl = '<div class="feature-row border rounded p-3 mb-3 position-relative">' +
            '<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-feature-row"><i class="bi bi-trash"></i></button>' +
            '<div class="row g-2">' +
            '<div class="col-md-4"><label class="form-label small">عنوان الميزة</label><input type="text" name="features[' + idx + '][title]" class="form-control form-control-sm" placeholder="عنوان الميزة"></div>' +
            '<div class="col-md-3"><label class="form-label small">أيقونة</label><input type="text" name="features[' + idx + '][icon]" class="form-control form-control-sm" placeholder="fas fa-check"></div>' +
            '<div class="col-md-5"><label class="form-label small">الوصف</label><input type="text" name="features[' + idx + '][description]" class="form-control form-control-sm" placeholder="وصف مختصر"></div>' +
            '</div></div>';
        document.getElementById('featureRows').insertAdjacentHTML('beforeend', tpl);
        idx++;
    });
    document.getElementById('featureRows')?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature-row')) e.target.closest('.feature-row')?.remove();
    });
});
</script>
