@php
    $videos = old('videos', isset($project) ? $project->videos->map(fn($v) => ['url' => $v->url, 'title' => $v->title])->toArray() : []);
    if (empty($videos)) $videos = [['url' => '', 'title' => '']];
@endphp
<div class="card custom-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-title mb-0">فيديوهات المشروع</div>
        <button type="button" class="btn btn-sm btn-primary" id="addVideoRow">
            <i class="bi bi-plus-lg"></i> إضافة فيديو
        </button>
    </div>
    <div class="card-body">
        <p class="text-muted small">أدخل رابط YouTube أو Vimeo (مثال: https://www.youtube.com/watch?v=xxxx)</p>
        <div id="videoRows">
            @foreach($videos as $i => $v)
            <div class="video-row border rounded p-3 mb-3 position-relative">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-video-row" aria-label="حذف"><i class="bi bi-trash"></i></button>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small">رابط الفيديو</label>
                        <input type="url" name="videos[{{ $i }}][url]" class="form-control form-control-sm" value="{{ $v['url'] ?? '' }}" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">عنوان (اختياري)</label>
                        <input type="text" name="videos[{{ $i }}][title]" class="form-control form-control-sm" value="{{ $v['title'] ?? '' }}" placeholder="عنوان الفيديو">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var idx = {{ count($videos) }};
    document.getElementById('addVideoRow')?.addEventListener('click', function() {
        var tpl = '<div class="video-row border rounded p-3 mb-3 position-relative">' +
            '<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-video-row"><i class="bi bi-trash"></i></button>' +
            '<div class="row g-2">' +
            '<div class="col-md-6"><label class="form-label small">رابط الفيديو</label><input type="url" name="videos[' + idx + '][url]" class="form-control form-control-sm" placeholder="https://..."></div>' +
            '<div class="col-md-6"><label class="form-label small">عنوان (اختياري)</label><input type="text" name="videos[' + idx + '][title]" class="form-control form-control-sm" placeholder="عنوان الفيديو"></div>' +
            '</div></div>';
        document.getElementById('videoRows').insertAdjacentHTML('beforeend', tpl);
        idx++;
    });
    document.getElementById('videoRows')?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-video-row')) e.target.closest('.video-row')?.remove();
    });
});
</script>
