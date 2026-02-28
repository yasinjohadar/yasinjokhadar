@extends('admin.layouts.master')

@section('page-title')
رسائل التواصل
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">رسائل التواصل</h4>
                <p class="mb-0 text-muted">رسائل النموذج من صفحة تواصل معنا</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">فلترة وبحث</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">بحث</label>
                            <input type="text" name="search" class="form-control" placeholder="الاسم، البريد، أو نص الرسالة..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الموضوع</label>
                            <select name="subject" class="form-select">
                                <option value="">الكل</option>
                                <option value="course" {{ request('subject') === 'course' ? 'selected' : '' }}>استفسار عن دورة تدريبية</option>
                                <option value="project" {{ request('subject') === 'project' ? 'selected' : '' }}>طلب مشروع برمجي</option>
                                <option value="private" {{ request('subject') === 'private' ? 'selected' : '' }}>تدريب خاص</option>
                                <option value="collab" {{ request('subject') === 'collab' ? 'selected' : '' }}>تعاون وشراكة</option>
                                <option value="other" {{ request('subject') === 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="read" class="form-select">
                                <option value="">الكل</option>
                                <option value="unread" {{ request('read') === 'unread' ? 'selected' : '' }}>غير مقروءة</option>
                                <option value="read" {{ request('read') === 'read' ? 'selected' : '' }}>مقروءة</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search me-1"></i> بحث
                            </button>
                            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة الرسائل ({{ $messages->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>التاريخ</th>
                                <th>الاسم</th>
                                <th>البريد</th>
                                <th>الموضوع</th>
                                <th>مقروءة</th>
                                <th width="120">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                                <td>{{ $loop->iteration + ($messages->currentPage() - 1) * $messages->perPage() }}</td>
                                <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                <td><strong>{{ $message->name }}</strong></td>
                                <td>{{ $message->email }}</td>
                                <td><span class="badge bg-primary-transparent">{{ \App\Models\ContactMessage::subjectLabel($message->subject) }}</span></td>
                                <td>
                                    @if($message->is_read)
                                        <span class="badge bg-success-transparent text-success">مقروءة</span>
                                    @else
                                        <span class="badge bg-warning-transparent text-warning">جديدة</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-sm btn-primary-light" title="عرض">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-light" title="حذف">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد رسائل تواصل حالياً</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($messages->hasPages())
            <div class="card-footer">
                {{ $messages->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
