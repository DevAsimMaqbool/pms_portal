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
  <!-- Permission Table -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="table border-top" id="complaintTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Indicator Category</th>
            <th>Indicator</th>
            <th>Created Date</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
  <!--/ Permission Table -->

  <!-- Modal -->
  <!-- Add Permission Modal -->
    <div class="modal fade" id="indicatorCategorytModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple">
            <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h3 class="modal-title" id="modalTitle">Add Indicator</h3>
                    <p class="text-body-secondary">Indicator you may use and assign to your users.</p>
                </div>
                
                <form id="indicatorCategoryForm" class="row">
                    <input type="hidden" id="indicator_Id">
                    <div class="col-12 form-control-validation mb-4">
                       <label class="form-label" for="key-performance-area">Key Performance Area</label>
                        <select id="key-performance-area" class="select2 form-select" data-allow-clear="true" name="key_performance_area" required>
                        </select>
                        <div class="invalid-feedback" id="key_performance_areaError"></div>
                    </div>
                     <div class="col-12 form-control-validation mb-4">
                       <label class="form-label" for="indicator-category">Indicator Category</label>
                        <select id="indicator-category" class="select2 form-select" data-allow-clear="true" name="indicator_category" required>
                        </select>
                        <div class="invalid-feedback" id="indicator_categoryError"></div>
                    </div>
                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label" for="indicator">Name</label>
                        <input type="text" id="indicator" name="indicator" required class="form-control" />
                        <div class="invalid-feedback" id="indicator_categoryaError"></div>
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Save</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
<!--/ Add Permission Modal -->


  <!-- /Modal --></div>
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
     let selectedCategoryId = null;
    const modal = new bootstrap.Modal(document.getElementById('indicatorCategorytModal'));
    let isEdit = false;

    function fetchIndicatorCategory() {
        $.ajax({
            url: "{{ route('indicator.index') }}",
            method: "GET",
            dataType: "json",
            success: function (data) {
                
                const Indicator = data.indicators;
                const KeyPerformanceArea = data.KeyPerformanceArea;
                // Populate user dropdown
                let keyperformanceOptions = '<option value="">Select Area</option>';
                KeyPerformanceArea.forEach(KeyPerformanceArea => {
                    keyperformanceOptions += `<option value="${KeyPerformanceArea.id}">${KeyPerformanceArea.performance_area}</option>`;
                });
                $('#key-performance-area').html(keyperformanceOptions);

                const rowData = Indicator.map((c, i) => {
                    const createdAt = new Date(c.created_at);
                    const formattedDate = createdAt.toISOString().split('T')[0];
                    return [
                        i + 1,
                        c.indicator_category || 'N/A',
                        Array.isArray(c.indicators) && c.indicators.length
                        ? c.indicators.map(ind => ind.indicator).join('<br>') : 'N/A',
                        formattedDate,
                        `<div class="d-flex align-items-center">
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="editIndicatorCategory(${c.id})">
                                <i class="icon-base ti tabler-edit icon-22px"></i>
                            </a>
                        </div>`
                    ];
                });

                // Initialize DataTable only once
                if (!$.fn.DataTable.isDataTable('#complaintTable')) {
                    window.complaintTable = $('#complaintTable').DataTable({
                        processing: true,
                        paging: true,
                        searching: true,
                        ordering: true,
                        data: rowData,
                        columns: [
                            { title: "#" },
                            { title: "Indicator" },
                            { title: "Indicator Category" },
                            { title: "Created Date" },
                            { title: "Actions", orderable: false }
                        ],
                        layout: {
                            topStart: {
                                rowClass: "row m-3 my-0 justify-content-between",
                                features: [
                                    {
                                        pageLength: {
                                            menu: [10, 25, 50, 100],
                                            text: "Show _MENU_"
                                        }
                                    },
                                    {
                                        buttons: [
                                            {
                                                text: '<i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i> <span class="d-none d-sm-inline-block">Add Indicator</span>',
                                                className: "btn",
                                                action: function () {
                                                    openAddIndicatorCategoryModal();
                                                }
                                            }
                                        ]
                                    }
                                ]
                            }
                        }
                    });
                } else {
                    // If already initialized, just refresh data
                    window.complaintTable.clear().rows.add(rowData).draw();
                }
            },
            error: function (xhr) {
                console.error("Error fetching complaint:", xhr.responseText);
            }
        });
    }

    function openAddIndicatorCategoryModal() {
        isEdit = false;
        $('#modalTitle').text('Add Indicator Category');
        $('#indicatorCategoryForm')[0].reset();
        $('#indicator_Id').val('');
        $('#nameError').text('');
        modal.show();
    }

    function editIndicatorCategory11(id) {
        isEdit = true;
        $.get(`/indicator/${id}/edit`, function (data) {
            let options_s = '<option value="">Select Category</option>';
            options_s += `<option value="${data.id}">${data.indicator_category}</option>`;
            $('#indicator-category').html(options_s).val(data.id);
            $('#indicator_Id').val(data.id);
            $('#key-performance-area').val(data.category.key_performance_area.id);
            $('#indicator-category').val(data.id);

            $('#indicator').val(data.indicator);

             // Set the tag list in Tagify field
            let tagInput = document.querySelector('#indicator');
            if (tagInput && tagInput._tagify) {
                // If already initialized, use set value
                tagInput._tagify.removeAllTags();
                tagInput._tagify.addTags(data.indicator.split(','));
            } else {
                // If not initialized yet, initialize with value
                tagInput.value = data.indicator;
                new Tagify(tagInput);
            }
            $('#modalTitle').text('Edit Indicator Category');
            $('#nameError').text('');
            modal.show();
        });
    }
    function editIndicatorCategory(id) {
        isEdit = true;

        $.get(`/indicator/${id}/edit`, function (data) {
            selectedCategoryId = data.id;
            // Clear current options
            $('#indicator-category').empty();
            // Set selected Indicator Category in a dropdown (if dropdown is used)
           


            // Set hidden input for ID
            $('#indicator_Id').val(data.id);
            // Set Key Performance Area dropdown
            $('#key-performance-area').val(data.key_performance_area_id).trigger('change');

            // Set the indicators using Tagify
            let tagInput = document.querySelector('#indicator');
            if (tagInput && tagInput._tagify) {
                tagInput._tagify.removeAllTags();
                tagInput._tagify.addTags(data.indicator.split(','));
            } else {
                tagInput.value = data.indicator;
                new Tagify(tagInput);
            }

            // Show modal and reset error message
            $('#modalTitle').text('Edit Indicator Category');
            $('#nameError').text('');
            modal.show();
        });
    }


    $('#indicatorCategoryForm').submit(function (e) {
        e.preventDefault();
        const id = $('#indicator_Id').val();
        const url = isEdit ? `/indicator/${id}` : "{{ route('indicator.store') }}";
        const method = isEdit ? 'PUT' : 'POST';
        let rawTags = $('#indicator').val();
        let parsedTags = [];
        parsedTags = JSON.parse(rawTags).map(tag => tag.value).join(',');
        const formData = {
            _token: "{{ csrf_token() }}",
            _method: method,
            key_performance_area: $('#key-performance-area').val(),
            indicator_category: $('#indicator-category').val(),
            indicator: parsedTags
        };
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (res) {
                $('#indicatorCategoryForm')[0].reset();
                $('#indicator_Id').val('');
                modal.hide();
                Swal.fire({
                title: "Good job!",
                icon: "success",
                 customClass: {
                    confirmButton: "btn btn-primary waves-effect waves-light"
                },
                buttonsStyling: !1
                });
                fetchIndicatorCategory();
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                 $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]).show();
                    });
            }
        });
    });

    $('#key-performance-area').change(function () {
        const kpaId = $(this).val();
        if (kpaId) {
            $.get(`/indicator-categories/${kpaId}`, function (data) {
                let options = '<option value="">Select Category</option>';
                data.forEach(function (cat) {
                    const selected = (cat.id == selectedCategoryId) ? 'selected' : '';
                    options += `<option value="${cat.id}" ${selected}>${cat.indicator_category}</option>`;
                });
                $('#indicator-category').html(options);
                 selectedCategoryId = null;
            });
        } else {
            $('#indicator-category').html('<option value="">Select KPA first</option>');
        }
    });
    $(document).ready(function () {
        fetchIndicatorCategory();
    });
    document.addEventListener("DOMContentLoaded", function () {
        const basicInput = document.querySelector("#indicator");
        if (basicInput) {
            new Tagify(basicInput);
        }
    });
</script>
@endpush