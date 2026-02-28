@php
    $editing = isset($partner);
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">بيانات الشريك / العميل</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">الاسم / عنوان البطاقة <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $editing ? $partner->name : '') }}" required
                           placeholder="مثال: اسم الشركة الأولى">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">النوع <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        @foreach(\App\Models\Partner::typesForSelect() as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $editing ? $partner->type : '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف (اختياري)</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                              placeholder="نبذة عن الشركة أو العميل...">{{ old('description', $editing ? $partner->description : '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">العبارة / الاقتباس (اختياري)</label>
                    <textarea name="quote" rows="2" class="form-control @error('quote') is-invalid @enderror"
                              placeholder='مثال: "شريك موثوق يلتزم بالمواعيد والجودة."'>{{ old('quote', $editing ? $partner->quote : '') }}</textarea>
                    @error('quote')
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
                           value="{{ old('order', $editing ? $partner->order : 0) }}" min="0">
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                           name="is_featured" {{ old('is_featured', $editing ? $partner->is_featured : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">عرضه في الصفحة الرئيسية (مميز)</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                           name="is_active" {{ old('is_active', $editing ? $partner->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">نشط</label>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">الشعار (اختياري)</div>
            </div>
            <div class="card-body">
                @if($editing && $partner->logo)
                    <div class="mb-3 text-center">
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="rounded mb-2" style="max-width:100%;height:auto;max-height:100px;object-fit:contain">
                        <div class="text-muted small">سيتم استبدال الشعار عند رفع صورة جديدة.</div>
                    </div>
                @endif

                <div class="mb-3">
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    @error('logo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-text">إن لم ترفع شعاراً، سيظهر الشعار الافتراضي.</div>
                </div>
            </div>
        </div>
    </div>
</div>
