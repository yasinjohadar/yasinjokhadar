@php
    $editing = isset($galleryImage);
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">بيانات الصورة</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">عنوان الصورة <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $editing ? $galleryImage->title : '') }}" required
                           placeholder="مثال: ورشة عمل تطوير الويب">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف (اختياري)</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                              placeholder="وصف مختصر للصورة...">{{ old('description', $editing ? $galleryImage->description : '') }}</textarea>
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
                           value="{{ old('order', $editing ? $galleryImage->order : 0) }}" min="0">
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                           name="is_featured" {{ old('is_featured', $editing ? $galleryImage->is_featured : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">عرضها في الصفحة الرئيسية (مميزة)</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                           name="is_active" {{ old('is_active', $editing ? $galleryImage->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">الصورة نشطة</label>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">الصورة <span class="text-danger">*</span></div>
            </div>
            <div class="card-body">
                @if($editing && $galleryImage->image)
                    <div class="mb-3 text-center">
                        <img src="{{ $galleryImage->image_url }}" alt="{{ $galleryImage->title }}" class="rounded mb-2" style="max-width:100%;height:auto;max-height:160px;object-fit:cover">
                        <div class="text-muted small">سيتم استبدال الصورة عند رفع صورة جديدة.</div>
                    </div>
                @endif

                <div class="mb-3">
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" {{ $editing ? '' : 'required' }}>
                    @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @if(!$editing)
                        <div class="form-text">مطلوب عند الإضافة. الأنواع: JPG, PNG, GIF, WebP. الحد الأقصى 4 ميجابايت.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
