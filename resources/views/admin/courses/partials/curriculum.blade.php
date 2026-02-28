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

