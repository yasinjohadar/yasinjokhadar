@php
    $editing = isset($video);
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">بيانات الفيديو</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">عنوان الفيديو <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $editing ? $video->title : '') }}" required
                           placeholder="مثال: أساسيات تطوير الويب">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">رابط يوتيوب <span class="text-danger">*</span></label>
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                           value="{{ old('video_url', $editing ? $video->video_url : '') }}" required
                           placeholder="https://www.youtube.com/watch?v=... أو https://youtu.be/...">
                    @error('video_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">عدد المشاهدات</label>
                    <input type="number" name="views_count" class="form-control @error('views_count') is-invalid @enderror"
                           value="{{ old('views_count', $editing ? $video->views_count : 0) }}" min="0">
                    @error('views_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف (اختياري)</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                              placeholder="وصف مختصر للفيديو...">{{ old('description', $editing ? $video->description : '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card custom-card mb-3">
            <div class="card-header">
                <div class="card-title">الإعدادات</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                           value="{{ old('order', $editing ? $video->order : 0) }}" min="0">
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="is_featured" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                           name="is_featured" value="1" {{ old('is_featured', $editing ? $video->is_featured : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">عرضه في الصفحة الرئيسية (مميز)</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                           name="is_active" value="1" {{ old('is_active', $editing ? $video->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">الفيديو نشط</label>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">صورة مصغرة (اختياري)</div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-2">إن لم ترفع صورة، سيتم استخدام صورة يوتيوب التلقائية.</p>
                @if($editing && $video->thumbnail)
                    <div class="mb-3 text-center">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="rounded mb-2" style="max-width:100%;height:auto;max-height:120px;object-fit:cover">
                        <div class="text-muted small">سيتم استبدال الصورة عند رفع صورة جديدة.</div>
                    </div>
                @endif

                <div class="mb-3">
                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                    @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
