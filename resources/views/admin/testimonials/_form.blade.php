@php
    $editing = isset($testimonial);
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">بيانات الرأي</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">اسم الطالب <span class="text-danger">*</span></label>
                    <input type="text" name="student_name" class="form-control @error('student_name') is-invalid @enderror"
                           value="{{ old('student_name', $editing ? $testimonial->student_name : '') }}" required>
                    @error('student_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الوظيفة / الوصف</label>
                    <input type="text" name="student_title" class="form-control @error('student_title') is-invalid @enderror"
                           value="{{ old('student_title', $editing ? $testimonial->student_title : '') }}"
                           placeholder="مثال: مطور واجهات أمامية – سوريا">
                    @error('student_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">اسم الدورة</label>
                    <input type="text" name="course_name" class="form-control @error('course_name') is-invalid @enderror"
                           value="{{ old('course_name', $editing ? $testimonial->course_name : '') }}"
                           placeholder="مثال: دورة تطوير الويب الشاملة">
                    @error('course_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">التقييم (عدد النجوم)</label>
                    <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ (int) old('rating', $editing ? $testimonial->rating : 5) === $i ? 'selected' : '' }}>
                                {{ $i }} نجوم
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">نص الرأي <span class="text-danger">*</span></label>
                    <textarea name="quote" rows="4" class="form-control @error('quote') is-invalid @enderror"
                              placeholder="اكتب رأي الطالب هنا...">{{ old('quote', $editing ? $testimonial->quote : '') }}</textarea>
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
                           value="{{ old('order', $editing ? $testimonial->order : 0) }}">
                    @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured"
                           name="is_featured" {{ old('is_featured', $editing ? $testimonial->is_featured : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">عرضه في الصفحة الرئيسية (مميز)</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                           name="is_active" {{ old('is_active', $editing ? $testimonial->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">هذا الرأي نشط</label>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">صورة الطالب (اختياري)</div>
            </div>
            <div class="card-body">
                @if($editing && $testimonial->avatar)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->student_name }}" class="rounded-circle mb-2" style="width:80px;height:80px;object-fit:cover">
                        <div class="text-muted small">سيتم استبدال الصورة عند رفع صورة جديدة.</div>
                    </div>
                @endif

                <div class="mb-3">
                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                    @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

