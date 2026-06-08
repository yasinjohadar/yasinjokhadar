<style>
    .project-card-preview {
        aspect-ratio: 16 / 9;
        border-radius: 10px;
        overflow: hidden;
        background: linear-gradient(145deg, rgba(230, 0, 0, 0.08), rgba(26, 26, 46, 0.06));
        border: 1px dashed #dee2e6;
    }

    .project-card-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .project-card-preview-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #6c757d;
        font-size: 0.85rem;
    }

    .project-card-preview-placeholder i {
        font-size: 2rem;
        color: #e60000;
    }
</style>

<div class="card custom-card mb-4">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-image me-2"></i>صورة الكارد</div>
    </div>
    <div class="card-body">
        <div class="project-card-preview mb-3" id="project-card-preview">
            @if(isset($project) && $project->image)
                <img
                    src="{{ $project->image_url }}"
                    alt="معاينة كارد {{ $project->title }}"
                    class="project-card-preview-img"
                    id="project-card-preview-img"
                >
                <div class="project-card-preview-placeholder d-none" id="project-card-preview-placeholder">
                    <i class="bi bi-image"></i>
                    <span>معاينة الكارد</span>
                </div>
            @else
                <div class="project-card-preview-placeholder" id="project-card-preview-placeholder">
                    <i class="bi bi-image"></i>
                    <span>معاينة الكارد</span>
                </div>
                <img src="" alt="" class="project-card-preview-img d-none" id="project-card-preview-img">
            @endif
        </div>

        <label class="form-label" for="project-card-image-input">رفع صورة</label>
        <input
            type="file"
            name="image"
            id="project-card-image-input"
            class="form-control @error('image') is-invalid @enderror"
            accept="image/jpeg,image/png,image/webp,image/gif"
        >
        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <small class="text-muted d-block mt-2">
            نسبة 16:9 — يُفضّل 1920×1080 بكسل. تظهر في كارد المشروع بصفحة المشاريع.
        </small>
        @if(isset($project) && $project->image)
            <small class="text-muted d-block mt-1">اترك الحقل فارغاً للإبقاء على الصورة الحالية.</small>
        @endif
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const input = document.getElementById('project-card-image-input');
        const previewImg = document.getElementById('project-card-preview-img');
        const placeholder = document.getElementById('project-card-preview-placeholder');

        if (!input || !previewImg || !placeholder) {
            return;
        }

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                previewImg.src = event.target.result;
                previewImg.classList.remove('d-none');
                placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endpush
