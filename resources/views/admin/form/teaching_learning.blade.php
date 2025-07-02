@extends('layouts.app')
@push('style')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
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
                    <div class="card mb-6">
                        <h5 class="card-header">Multi Column with Form Separator</h5>
                        <form class="card-body">
                        <h6>1. Account Details</h6>
                        <div class="row g-6">
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-username">Username</label>
                            <input type="text" id="multicol-username" class="form-control" placeholder="john.doe" />
                            </div>
                             <div class="col-md-6">
                            <label class="form-label" for="multicol-email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="multicol-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="multicol-email2" />
                                <span class="input-group-text" id="multicol-email2">@example.com</span>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-first-name">First Name</label>
                            <input type="text" id="multicol-first-name" class="form-control" placeholder="John" />
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-last-name">Last Name</label>
                            <input type="text" id="multicol-last-name" class="form-control" placeholder="Doe" />
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-country">Country</label>
                            <select id="multicol-country" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select</option>
                                <option value="Australia">Australia</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Japan">Japan</option>
                                <option value="Korea">Korea, Republic of</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Russia">Russian Federation</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                            </select>
                            </div>
                            <div class="col-md-6 select2-primary">
                            <label class="form-label" for="multicol-language">Language</label>
                            <select id="multicol-language" class="select2 form-select" multiple>
                                <option value="en" selected>English</option>
                                <option value="fr" selected>French</option>
                                <option value="de">German</option>
                                <option value="pt">Portuguese</option>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-birthdate">Birth Date</label>
                            <input type="text" id="multicol-birthdate" class="form-control dob-picker" placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="multicol-phone">Phone No</label>
                            <input type="text" id="multicol-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" />
                            </div>
                        </div>
                        <div class="pt-6">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                        </form>
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