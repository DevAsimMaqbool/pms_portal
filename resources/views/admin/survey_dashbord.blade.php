@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('admin/assets/img/pages/profile-banner.png') }}" alt="Banner image"
                            class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6">{{ $employee['name'] }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                        <li class="list-inline-item d-flex gap-2 align-items-center"><i
                                                class="icon-base ti tabler-palette icon-lg"></i><span
                                                class="fw-medium">{{ $employee['job_title'] }}</span></li>
                                        <li class="list-inline-item d-flex gap-2 align-items-center"><i
                                                class="icon-base ti tabler-gender-bigender  icon-lg"></i><span
                                                class="fw-medium">{{ $employee['gender'] }}</span></li>
                                        <li class="list-inline-item d-flex gap-2 align-items-center"><i
                                                class="icon-base ti tabler-calendar  icon-lg"></i><span class="fw-medium">
                                                {{ $employee['birthday'] }} </span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <!-- About User -->
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text text-uppercase text-body-secondary small mb-0">About</p>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4"><i
                                            class="icon-base ti tabler-user icon-lg"></i><span class="fw-medium mx-2">Full
                                            Name:</span> <span>{{ $employee['name'] }}</span></li>
                                    <li class="d-flex align-items-center mb-4"><i
                                            class="icon-base ti tabler-check icon-lg"></i><span
                                            class="fw-medium mx-2">Status:</span> <span>{{ $employee['status'] }}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4"><i
                                            class="icon-base ti tabler-crown icon-lg"></i><span
                                            class="fw-medium mx-2">Role:</span> <span>{{ $employee['level'] }}</span></li>
                                    <li class="d-flex align-items-center mb-4"><i
                                            class="icon-base ti tabler-id-badge-2 icon-lg"></i><span
                                            class="fw-medium mx-2">CNIC:</span> <span>{{ $employee['cnic'] }}</span></li>
                                    <li class="d-flex align-items-center mb-2"><i
                                            class="icon-base ti tabler-blob icon-lg"></i><span class="fw-medium mx-2">Blood
                                            G:</span> <span>{{ $employee['blood_group'] }}</span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text text-uppercase text-body-secondary small mb-0">Contacts</p>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="icon-base ti tabler-phone-call icon-lg"></i><span
                                            class="fw-medium mx-2">Contact:</span>
                                        <span>{{ $employee['mobile_phone'] }}</span>
                                    </li>

                                    <li class="d-flex align-items-center mb-4">
                                        <i class="icon-base ti tabler-mail icon-lg"></i><span
                                            class="fw-medium mx-2">Email:</span>
                                        <span>{{ $employee['email'] }}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4"><i
                                            class="icon-base ti tabler-map-pin icon-lg"></i><span
                                            class="fw-medium mx-2">location:</span>
                                        <span>{{ $employee['work_location'] }}</span>
                                    </li>
                                </ul>
                                <p class="card-text text-uppercase text-body-secondary small mb-0">other</p>
                                <ul class="list-unstyled mb-0 mt-3 pt-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <span
                                            class="fw-medium mx-2">Department:</span><span>{{ $employee['department'] }}</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <span
                                            class="fw-medium mx-2">Manager:</span><span>{{ $employee['manager_name'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
                <!--/ About User -->
            </div>

        </div>
        <!--/ User Profile Content -->
    </div>
    <!-- / Content -->


@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endpush