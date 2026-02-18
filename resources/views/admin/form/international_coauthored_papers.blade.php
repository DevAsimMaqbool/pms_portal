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
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <h6>International co-Authored Papers</h6>
                <form id="researchForm" enctype="multipart/form-data" class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value=" $areaId ">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="$categoryId">
                    <input type="hidden" id="indicator_id" name="indicator_id" value="$indicatorId ">

                    <div class="row">
                        <div class="row g-6 mb-6">
                            <div class="col-md-6">
                                <label for="no_of_international_coauthers" class="form-label">No of International
                                    co-authers</label>
                                <input type="text" id="no_of_international_coauthers" class="form-control"
                                    name="no_of_international_coauthers">
                            </div>

                            <div class="col-md-6">
                                <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
                                <input type="text" id="name_of_coauthers" class="form-control" name="name_of_coauthers">
                            </div>
                            <div class="col-md-6">
                                <label for="author_rank" class="form-label">Author rank</label>
                                <input type="text" id="author_rank" class="form-control" name="author_rank">
                            </div>
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" id="designation" class="form-control" name="designation">
                            </div>

                            <div class="col-md-6">
                                <label for="name_of_university_country" class="form-label">Name of University &
                                    Country</label>
                                <input type="text" id="name_of_university_country" class="form-control"
                                    name="name_of_university_country">
                            </div>
                        </div>


                        <div id="author-past-container">
                            <div class="past-group row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">No of papers co-authored with this person in the past</label>
                                    <input type="text" name="past[0][no_of_papers_past]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
                                    <input type="text" id="past[0][name_of_coauthers_past]" class="form-control"
                                        name="name_of_coauthers">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Author Rank</label>
                                    <input type="text" name="past[0][author_rank_past]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Name of University & Country</label>
                                    <input type="text" name="past[0][name_of_university_country_past]" class="form-control"
                                        required>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="add-coauthor"><i
                                    class="icon-base ti tabler-plus me-1"></i> <span
                                    class="align-middle">Add</span></button>
                        </div>

                    </div>
                    <div class="col-1 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
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
@push('script')
    <script>
        $(document).ready(function () {
            let pastIndex = 1;

            // Add new author group
            $('#add-coauthor').click(function () {
                let newGroup = `
                                    <div class="past-group row g-3 mb-3">

                                    <div class="col-md-4">
                                    <label class="form-label">No of papers co-authored with this person in the past</label>
                                    <input type="text" name="past[${pastIndex}][no_of_papers_past]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">

                                    <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
                                    <input type="text" id="past[${pastIndex}][name_of_coauthers_past]" class="form-control"
                                    name="name_of_coauthers">
                                    </div>
                                    <div class="col-md-4">
                                    <label class="form-label">Author Rank</label>
                                    <input type="text" name="past[${pastIndex}][author_rank_past]" class="form-control" required>
                                    </div>

                                    <div class="col-md-4">
                                    <label class="form-label">Name of University & Country</label>
                                    <input type="text" name="past[${pastIndex}][name_of_university_country_past]" class="form-control"
                                    required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
                                    </div>
                                    </div>`;

                $('#author-past-container').append(newGroup);
                pastIndex++;
            });

            // Remove a past group
            $(document).on('click', '.remove-past', function () {
                $(this).closest('.past-group').remove();
            });
        });
    </script>
@endpush