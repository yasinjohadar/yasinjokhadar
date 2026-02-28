@extends('admin.layouts.master')

@section('page-title')
تعديل الكورس
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div><h4 class="mb-0">تعديل: {{ $course->title }}</h4></div>
            <div class="ms-auto"><a href="{{ route('admin.courses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-2"></i>رجوع</a></div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card custom-card mb-4">
                        <div class="card-header"><div class="card-title">معلومات الكورس</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">التصنيف <span class="text-danger">*</span></label>
                                <select name="course_category_id" class="form-select @error('course_category_id') is-invalid @enderror" required>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('course_category_id', $course->course_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">العنوان <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $course->title) }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الرابط (Slug)</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $course->slug) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">وصف قصير</label>
                                <textarea name="short_description" rows="2" class="form-control">{{ old('short_description', $course->short_description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الوصف الكامل</label>
                                <textarea name="description" rows="5" class="form-control">{{ old('description', $course->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">صورة الكورس</label>
                                @if($course->image)
                                <div class="mb-2"><img src="{{ route('course.image', ['filename' => basename($course->image)]) }}" alt="" class="rounded" style="max-height:80px"></div>
                                @endif
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">اترك فارغاً للإبقاء على الصورة الحالية</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر ($) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $course->price) }}" required>
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر القديم ($)</label>
                                    <input type="number" step="0.01" name="old_price" class="form-control" value="{{ old('old_price', $course->old_price) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">المدة (ساعات)</label>
                                    <input type="number" name="duration_hours" class="form-control" value="{{ old('duration_hours', $course->duration_hours) }}" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">عدد الدروس</label>
                                    <input type="number" name="lessons_count" class="form-control" value="{{ old('lessons_count', $course->lessons_count) }}" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">عدد الطلاب</label>
                                    <input type="number" name="students_count" class="form-control" value="{{ old('students_count', $course->students_count) }}" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">المستوى</label>
                                    <input type="text" name="level" class="form-control" value="{{ old('level', $course->level) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اللغة</label>
                                    <input type="text" name="language" class="form-control" value="{{ old('language', $course->language) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الشارة (Badge)</label>
                                <input type="text" name="badge" class="form-control" value="{{ old('badge', $course->badge) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">عنوان SEO</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $course->meta_title) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">وصف SEO</label>
                                <textarea name="meta_description" rows="2" class="form-control">{{ old('meta_description', $course->meta_description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">لمحة سريعة عن الدورة</label>
                                <textarea name="highlights" rows="3" class="form-control" placeholder="اكتب كل نقطة في سطر منفصل">{{ old('highlights', $course->highlights) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ماذا ستتعلم في هذه الدورة</label>
                                <textarea name="learn_items" rows="4" class="form-control" placeholder="اكتب كل نقطة في سطر منفصل">{{ old('learn_items', $course->learn_items) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المتطلبات المسبقة</label>
                                <textarea name="requirements" rows="3" class="form-control" placeholder="اكتب كل متطلب في سطر منفصل">{{ old('requirements', $course->requirements) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card custom-card mb-4">
                        <div class="card-header">
                            <div class="card-title">محتوى الكورس (الأقسام والدروس)</div>
                        </div>
                        <div class="card-body" id="course-content"
                             data-store-section-url="{{ route('admin.courses.sections.store', $course) }}">
                            <div class="mb-3">
                                <h6 class="mb-2">إضافة قسم جديد</h6>
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label">عنوان القسم الجديد</label>
                                        <input type="text" class="form-control" id="new-section-title">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">الترتيب</label>
                                        <input type="number" class="form-control" id="new-section-order" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="new-section-active" checked>
                                            <label class="form-check-label" for="new-section-active">قسم نشط</label>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100" id="add-section-btn">
                                            <i class="bi bi-plus-circle me-1"></i> إضافة قسم
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="course-content-alert" class="alert d-none" role="alert"></div>

                            @forelse($course->sections as $section)
                                <div class="border rounded mb-3 p-3 section-block"
                                     data-section-id="{{ $section->id }}"
                                     data-update-url="{{ route('admin.sections.update', $section) }}"
                                     data-delete-url="{{ route('admin.sections.destroy', $section) }}"
                                     data-lessons-store-url="{{ route('admin.sections.lessons.store', $section) }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>{{ $section->title }}</strong>
                                            <span class="text-muted ms-2">#{{ $section->order }}</span>
                                            @if(!$section->is_active)
                                                <span class="badge bg-secondary ms-1">غير نشط</span>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-action="edit-section">تعديل</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-action="delete-section">حذف</button>
                                        </div>
                                    </div>
                                    @if($section->description)
                                        <p class="mb-2 text-muted small">{{ $section->description }}</p>
                                    @endif

                                    @if($section->lessons->count())
                                        <div class="table-responsive mb-2">
                                            <table class="table table-sm align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:60px">#</th>
                                                        <th>عنوان الدرس</th>
                                                        <th style="width:120px">المدة (د)</th>
                                                        <th style="width:80px">معاينة</th>
                                                        <th style="width:80px">الحالة</th>
                                                        <th style="width:140px">إجراءات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($section->lessons as $lesson)
                                                        <tr class="lesson-row"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-update-url="{{ route('admin.lessons.update', $lesson) }}"
                                                            data-delete-url="{{ route('admin.lessons.destroy', $lesson) }}">
                                                            <td>{{ $lesson->order }}</td>
                                                            <td>{{ $lesson->title }}</td>
                                                            <td>{{ $lesson->duration_minutes ? $lesson->duration_minutes . ' دقيقة' : '-' }}</td>
                                                            <td>{{ $lesson->is_preview ? 'نعم' : 'لا' }}</td>
                                                            <td>{{ $lesson->is_active ? 'نشط' : 'مخفي' }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-outline-primary me-1"
                                                                        data-action="edit-lesson">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                                        data-action="delete-lesson">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <h6 class="mb-2">إضافة درس جديد لهذا القسم</h6>
                                        <div class="row g-2 align-items-end">
                                            <div class="col-md-5">
                                                <label class="form-label">عنوان الدرس الجديد</label>
                                                <input type="text" class="form-control" data-field="lesson-title">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">المدة (دقائق)</label>
                                                <input type="number" class="form-control" data-field="lesson-duration" min="0">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ترتيب</label>
                                                <input type="number" class="form-control" data-field="lesson-order" min="0">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" data-field="lesson-preview">
                                                    <label class="form-check-label">معاينة</label>
                                                </div>
                                                <button type="button" class="btn btn-success w-100"
                                                        data-action="add-lesson">
                                                    <i class="bi bi-plus-circle me-1"></i> إضافة درس
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">لم تتم إضافة أي أقسام بعد.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $course->order) }}" min="0">
                            </div>
                            <input type="hidden" name="is_active" value="0">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">كورس نشط</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-save me-2"></i>تحديث الكورس</button>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const contentRoot = document.getElementById('course-content');
        if (!contentRoot) return;

        const alertBox = document.getElementById('course-content-alert');

        function showMessage(type, message) {
            if (!alertBox) return;
            alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');
            alertBox.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
            alertBox.textContent = message;
        }

        async function sendRequest(url, method, data) {
            const options = {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: data ? JSON.stringify(data) : null,
            };

            const response = await fetch(url, options);
            if (!response.ok) {
                let msg = 'حدث خطأ غير متوقع.';
                try {
                    const json = await response.json();
                    if (json.message) {
                        msg = json.message;
                    } else if (json.errors) {
                        msg = Object.values(json.errors).flat().join(' - ');
                    }
                } catch (e) {}
                throw new Error(msg);
            }
            return response.json();
        }

        // إضافة قسم جديد
        document.getElementById('add-section-btn')?.addEventListener('click', async function () {
            const title = document.getElementById('new-section-title').value.trim();
            const order = document.getElementById('new-section-order').value;
            const isActive = document.getElementById('new-section-active').checked;
            if (!title) {
                showMessage('danger', 'يرجى إدخال عنوان القسم.');
                return;
            }
            const url = contentRoot.dataset.storeSectionUrl;
            try {
                await sendRequest(url, 'POST', {
                    title: title,
                    order: order || null,
                    is_active: isActive ? 1 : 0,
                });
                showMessage('success', 'تم إضافة القسم بنجاح.');
                location.reload();
            } catch (e) {
                showMessage('danger', e.message);
            }
        });

        // عمليات على الأقسام والدروس (edit/delete/add-lesson)
        contentRoot.addEventListener('click', async function (e) {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const action = btn.dataset.action;
            const sectionBlock = btn.closest('.section-block');

            try {
                if (action === 'delete-section') {
                    if (!confirm('هل أنت متأكد من حذف هذا القسم وجميع دروسه؟')) return;
                    await sendRequest(sectionBlock.dataset.deleteUrl, 'DELETE');
                    showMessage('success', 'تم حذف القسم بنجاح.');
                    sectionBlock.remove();
                    return;
                }

                if (action === 'edit-section') {
                    const currentTitle = sectionBlock.querySelector('strong').textContent.trim();
                    const newTitle = prompt('عنوان القسم:', currentTitle);
                    if (!newTitle) return;
                    const newOrder = prompt('ترتيب القسم (رقم):', sectionBlock.querySelector('.text-muted').textContent.replace('#','').trim());
                    const isActive = confirm('هل القسم نشط؟ (موافق = نشط / إلغاء = غير نشط)');
                    await sendRequest(sectionBlock.dataset.updateUrl, 'PUT', {
                        title: newTitle,
                        order: newOrder || 0,
                        is_active: isActive ? 1 : 0,
                    });
                    showMessage('success', 'تم تحديث القسم بنجاح.');
                    location.reload();
                    return;
                }

                if (action === 'add-lesson') {
                    const wrapper = btn.closest('.row');
                    const titleInput = wrapper.querySelector('[data-field=\"lesson-title\"]');
                    const durationInput = wrapper.querySelector('[data-field=\"lesson-duration\"]');
                    const orderInput = wrapper.querySelector('[data-field=\"lesson-order\"]');
                    const previewInput = wrapper.querySelector('[data-field=\"lesson-preview\"]');

                    const title = titleInput.value.trim();
                    if (!title) {
                        showMessage('danger', 'يرجى إدخال عنوان الدرس.');
                        return;
                    }
                    const url = sectionBlock.dataset.lessonsStoreUrl;
                    await sendRequest(url, 'POST', {
                        title: title,
                        duration_minutes: durationInput.value || null,
                        order: orderInput.value || null,
                        is_preview: previewInput.checked ? 1 : 0,
                    });
                    showMessage('success', 'تم إضافة الدرس بنجاح.');
                    location.reload();
                    return;
                }

                const lessonRow = btn.closest('.lesson-row');
                if (!lessonRow) return;

                if (action === 'delete-lesson') {
                    if (!confirm('حذف هذا الدرس؟')) return;
                    await sendRequest(lessonRow.dataset.deleteUrl, 'DELETE');
                    showMessage('success', 'تم حذف الدرس بنجاح.');
                    lessonRow.remove();
                    return;
                }

                if (action === 'edit-lesson') {
                    const currentTitle = lessonRow.children[1].textContent.trim();
                    const newTitle = prompt('عنوان الدرس:', currentTitle);
                    if (!newTitle) return;
                    const currentDuration = lessonRow.children[2].textContent.replace(' دقيقة', '').trim();
                    const newDuration = prompt('مدة الدرس (دقائق):', currentDuration || '0');
                    const isPreview = confirm('هل الدرس متاح كمعاينة؟ (موافق = نعم / إلغاء = لا)');
                    const isActive = confirm('هل الدرس نشط؟ (موافق = نشط / إلغاء = مخفي)');

                    await sendRequest(lessonRow.dataset.updateUrl, 'PUT', {
                        title: newTitle,
                        duration_minutes: newDuration || null,
                        order: parseInt(lessonRow.children[0].textContent.trim(), 10) || 0,
                        is_preview: isPreview ? 1 : 0,
                        is_active: isActive ? 1 : 0,
                    });
                    showMessage('success', 'تم تحديث الدرس بنجاح.');
                    location.reload();
                }
            } catch (err) {
                showMessage('danger', err.message);
            }
        });
    })();
</script>
@endsection
