@extends('admin.layouts.master')

@section('page-title')
لوحة التحكم
@stop

@section('content')
  <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <div>
                        <h4 class="mb-0">مرحباً بعودتك!</h4>
                        <p class="mb-0 text-muted">لوحة تحكم مركز الإدارة.</p>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <p class="text-muted mb-0">اختر من القائمة الجانبية للبدء.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End::app-content -->
@stop
