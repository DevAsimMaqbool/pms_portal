@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->

                            <form id="researchForm1" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                                
                                <div class="row g-6">
                                    <div class="col-12 col-lg-8">
                                        <div class="card h-100">
                                        <h5 class="card-header">Achievement on tasks assigned by the dean</h5>
                                            <div class="card-body">
                                                <div class="mb-6">
                                                    <label class="form-label">Task</label>
                                                    <select name="task" class="form-select" required="">
                                                        <option value="">Select Task</option>
                                                        <option value="Committees Participated/Chaired">Committees Participated/Chaired</option>
                                                        <option value="Policy Development Contributions">Policy Development Contributions</option>
                                                        <option value="Program Accreditation/Compliance Work">Program Accreditation/Compliance Work</option>
                                                        <option value="Quality Assurance Contributions">Quality Assurance Contributions</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-6">
                                                    <label for="contributions" class="form-label">Contributions</label>
                                                    <textarea class="form-control" id="contributions" rows="3"></textarea>
                                                </div>

                                                <div class="mb-6">
                                                    <label for="outcome" class="form-label">Outcome</label>
                                                    <textarea class="form-control" id="outcome" rows="3"></textarea>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mx-2">
                                                    <img src="{{ asset('admin/assets/img/illustrations/boy-with-laptop-light.png') }}" alt="girl-unlock-password-light" width="335" class="img-fluid"style="visibility: visible;">
                                                </div>
                                                <div class="mb-6">
                                                    <label for="time" class="form-label">Date</label>
                                                    <input class="form-control" type="date" value="2021-06-18" id="html5-date-input">
                                                </div>
                                                <div class="mb-6">
                                                    <label for="time" class="form-label">Time</label>
                                                    <input class="form-control" type="time" value="12:30:00" id="html5-time-input">
                                                </div>
                                            </div>
                                        </div>    
                                    </div>    
                                </div>
                                <div class="col-4 text-center demo-vertical-spacing">
                                    <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
@endpush