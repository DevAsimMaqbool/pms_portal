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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

<!-- new design -->

<div class="app-ecommerce">
    <!-- tab open-->
    <div class="nav-align-top">

        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Form</button>
            </li>
             <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Table</button>
            </li> 
            
        </ul>
        <!-- main tab-->
        <div class="tab-content" style="padding:0;background: none;border: none;box-shadow: none;">
             @if(auth()->user()->hasRole(['HOD']))
            <!-- first tab-->
            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Rating on Impact of Research Conferences Organized</h4>
            </div>
            <!-- <div class="d-flex align-content-center flex-wrap gap-4">
                <div class="d-flex gap-4">
                <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'profitability_of_the_programs', 'id' => $indicatorId]) }}">View</a></div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="bx bx-upload"></i> Import Excel / CSV</button>
            </div> -->
            </div>
            <form id="researchForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Conference Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="conference_name">Conference Name</label>
                            <input type="text" class="form-control" id="conference_name" placeholder="Conference Name" name="conference_name" aria-label="Conference Name">
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="conference_theme">Conference Theme</label>
                            <input type="text" class="form-control" id="conference_theme" placeholder="Conference Theme" name="conference_theme" aria-label="Conference Theme">
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="conference_date">Conference Date</label>
                            <input type="date" class="form-control" id="conference_date" placeholder="Conference Date" name="conference_date" aria-label="Conference Date">
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="conference_venue">Conference Venue</label>
                            <input type="text" class="form-control" id="conference_venue" placeholder="Conference Venue" name="conference_venue" aria-label="Conference Venue">
                            </div>

                            <div class="col-md-6 mb-3">
                            <label for="conference_scope" class="form-label">Conference Scope</label>
                            <select name="conference_scope" class="select2 form-select" required>
                                <option value="">-- Select Conference Scope --</option>
                                <option value="national">National</option>
                                <option value="international">International</option>
                            </select>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label for="conference_scope" class="form-label">Scopus Indexing</label>
                            <select name="conference_scope" class="select2 form-select" required>
                                <option value="">-- Select Scopus Indexing --</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            </div>
                               
                        </div>
                        <!-- Description -->
                        
                    </div>
                    </div>
                    <!-- /Product Information -->


                     <!-- Product Information -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Participants’ Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                            <label class="form-label" for="national_participants">National Participants (Non-Industry)</label>
                            <input type="number" class="form-control" id="national_participants" placeholder="National Participants (Non-Industry)" name="national_participants" aria-label="National Participants (Non-Industry)">
                            </div>

                            <div class="col-md-4 mb-3">
                            <label class="form-label" for="international_participants">International Participants</label>
                            <input type="number" class="form-control" id="international_participants" placeholder="International Participants" name="international_participants" aria-label="International Participants">
                            </div>

                            <div class="col-md-4 mb-3">
                            <label class="form-label" for="industry_participants">Industry Participants</label>
                            <input type="number" class="form-control" id="industry_participants" placeholder="Industry Participants" name="industry_participants" aria-label="Industry Participants">
                            </div>
                        </div>
                        <!-- Description -->
                    </div>

                    <div class="card-header">
                        <h5 class="card-tile mb-0">Scholarly & Industry Impact Remarks</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="scholarly_impact">Scholarly Impact</label>
                            <textarea class="form-control" id="scholarly_impact" name="scholarly_impact" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="industry_engagement">Industry Engagement</label>
                            <textarea class="form-control" id="industry_engagement" name="industry_engagement" rows="2"></textarea>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="international_participation">International Participation</label>
                            <textarea class="form-control" id="international_participation" name="international_participation" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="indexing_recognition">Indexing & Recognition</label>
                            <textarea class="form-control" id="indexing_recognition" name="indexing_recognition" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                            <label class="form-label" for="overall_remarks">Overall Remarks</label>
                            <textarea class="form-control" id="overall_remarks" name="overall_remarks" rows="2"></textarea>
                            </div>
                        </div>
                        <!-- Description -->
                    </div>
                    </div>
                    <!-- /Product Information -->
                    
                    
                </div>
                <!-- /Second column -->

                <!-- Second column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Research Partners</h5>
                    </div>
                    <div class="card-body">
                        
                        
                        <div class="mb-3">
                            <label class="form-label" for="nature_of_partner">Nature of Partner</label>
                            <select name="nature_of_partner" class="select2 form-select nature_of_partner" required>
                                <option value="">-- Select Partner --</option>
                                <option value="academia">Academia</option>
                                <option value="industry">Industry</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="faculty" class="form-label">Partner Institute / Organization Name</label>
                            <input type="Text" class="form-control" id="partner_institute" placeholder="Partner Institute / Organization Name" name="partner_institute" aria-label="Partner Institute / Organization Name">
                        </div>

                         <div class="mb-3">
                            <label for="partner_country" class="form-label">Partner Country</label>
                            <select name="partner_country" class="select2 form-select partner_country" required>
                                <option value="">Select Country</option>
                                @foreach(getAllCountries() as $con)
<option value="{{ $con['code'] }}">
{{ $con['name'] }}
</option>
@endforeach
                            </select>
                        </div>
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                     <!-- Pricing Card -->
                    <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">International Participants’ Detail (Repeatable Section / Dynamic Rows)</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label" for="participant_name">Name</label>
                            <input type="text" class="form-control" id="participant_name" name="participant_name" placeholder="Participant Name">
                        </div>

                       <div class="mb-3">
                            <label class="form-label" for="participant_designation">Designation</label>
                            <input type="text" class="form-control" id="participant_designation" name="participant_designation" placeholder="Participant Designation">
                        </div>

                         <div class="mb-3">
                            <label class="form-label" for="participant_university">University / Organization</label>
                            <input type="text" class="form-control" id="participant_university" name="participant_university" placeholder="Participant Organization">
                        </div>
                        <div class="mb-3">
                        <label for="participant_country" class="form-label">Country</label>
                        <select name="participant_country" class="select2 form-select participant_country" required>
                        <option value="">Select Country</option>
                        @foreach(getAllCountries() as $con)
                        <option value="{{ $con['code'] }}">
                        {{ $con['name'] }}
                        </option>
                        @endforeach
                        </select>
                        </div>

                        <div class="mb-3">
                        <label for="participated_as" class="form-label">Participated As</label>
                        <select name="participated_as" class="select2 form-select participated_as" multiple required>
                        <option value="">Select</option>
                        <option value="Guest Speaker">Guest Speaker</option>
                        <option value="Participant">Participant</option>
                        <option value="Presenter">Presenter</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Session Chair">Session Chair</option>
                        </select>
                        </div>
                    </div>
                    </div>
                    <!-- /Pricing Card -->
                    <div class="mb-3" style="margin-top: 35px;">
                        <button type="submit" class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                
                </div>
                <!-- /Second column -->
                </div>
            </form>

            </div>
            <!-- /first tab-->
            @endif
            <!-- /second tab-->
            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
            </div>
            <!-- /second tab-->

        </div>
        <!-- /main tab-->

    </div>
    <!-- tab open-->
  </div>



<!-- / close new design -->
        <!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="importForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
            <input type="hidden" name="form_status" value="HOD">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Employability Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Upload Excel / CSV</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>

                    <small class="text-muted d-block mt-2">
                        Allowed: xlsx, xls, csv
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
@push('script')
       <script>
       
 document.addEventListener("DOMContentLoaded", function () {

    // SVG stars
    const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
    const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
    const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

    // Employer Rating
    const employerRaty = new Raty(document.getElementById("employerRating"), {
        number: 5,
        half: true,
        starOn: starOn,
        starHalf: starHalf,
        starOff: starOff,
        click: function(score) {
            document.getElementById("employer_satisfaction").value = score;
        }
    }).init();

    // Graduate Rating
    const graduateRaty = new Raty(document.getElementById("graduateRating"), {
        number: 5,
        half: true,
        starOn: starOn,
        starHalf: starHalf,
        starOff: starOff,
        click: function(score) {
            document.getElementById("graduate_satisfaction").value = score;
        }
    }).init();

});




       </script>
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {
              
              

                 $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                     // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                     
                    $.ajax({
                        url: "{{ route('employability.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('.select2').val(null).trigger('change');
                              // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;

                            document.getElementById("employer_satisfaction").value = "";
                            document.getElementById("graduate_satisfaction").value = "";

                            // Reset stars
                            employerRaty.setScore(0);
                            graduateRaty.setScore(0);
                        },
                        error: function (xhr) {
                            Swal.close();
                            // Clear previous errors before showing new ones
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                             if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                let input = form.find('[name="' + field + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else if (xhr.status === 409) {
                            // 🔥 Duplicate record message
                            Swal.fire({
                                icon: 'error',
                                title: 'Duplicate Entry',
                                text: xhr.responseJSON.message
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                        }
                    });
                });

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Importing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('employability.import') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.close();
                            Swal.fire('Success', res.message, 'success');
                            $('#importModal').modal('hide');
                            $('#importForm')[0].reset();
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire('Error', xhr.responseJSON.message ?? 'Import failed', 'error');
                        }
                    });
                });


            });
        </script>
    @endif
    @endpush