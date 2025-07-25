
<?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/form-validation.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/animate-css/animate.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
   <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
  <!-- Permission Table -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="table border-top" id="complaintTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Indicator</th>
            <th>Indicator Category</th>
            <th>KFA</th>
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
                    <input type="hidden" id="indicatorca_categoryId">
                    <div class="col-12 form-control-validation mb-4">
                       <label class="form-label" for="key-performance-area">Key Performance Area</label>
                        <select id="key-performance-area" class="form-select" name="key_performance_area" required>
                        </select>
                        <div class="invalid-feedback" id="key_performance_areaError"></div>
                    </div>
                     <div class="col-12 form-control-validation mb-4">
                       <label class="form-label" for="indicator-category">Indicator Category</label>
                        <select id="indicator-category" class="form-select" name="indicator_category" required>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/popular.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js')); ?>"></script>
<script src="<?php echo e(asset('admin/assets/js/extended-ui-sweetalert2.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>
    const modal = new bootstrap.Modal(document.getElementById('indicatorCategorytModal'));
    let isEdit = false;

    function fetchIndicatorCategory() {
        $.ajax({
            url: "<?php echo e(route('indicator.index')); ?>",
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
                        c.indicator || 'N/A',
                        c.category?.indicator_category || 'N/A',
                        c.category?.key_performance_area?.performance_area || 'N/A',
                        formattedDate,
                        `<div class="d-flex align-items-center">
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="editIndicatorCategory(${c.id})">
                                <i class="icon-base ti tabler-edit icon-22px"></i>
                            </a>
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="deleteIndicatorCategory(${c.id})">
                                <i class="icon-base ti tabler-trash icon-md"></i>
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
                            { title: "KFA" },
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
        $('#indicatorca_categoryId').val('');
        $('#nameError').text('');
        modal.show();
    }

    function editIndicatorCategory(id) {
        isEdit = true;
        $.get(`/indicator-category/${id}/edit`, function (data) {
            $('#indicatorca_categoryId').val(data.id);
            $('#key-performance-area').val(data.key_performance_area.id);
            $('#indicator-category').val(data.indicator_category);
            $('#modalTitle').text('Edit Indicator Category');
            $('#nameError').text('');
            modal.show();
        });
    }

    $('#indicatorCategoryForm').submit(function (e) {
        e.preventDefault();
        const id = $('#indicatorca_categoryId').val();
        const url = isEdit ? `/indicator-category/${id}` : "<?php echo e(route('indicator-category.store')); ?>";
        const method = isEdit ? 'PUT' : 'POST';
        const formData = {
            _token: "<?php echo e(csrf_token()); ?>",
            _method: method,
            key_performance_area: $('#key-performance-area').val(),
            indicator_category: $('#indicator-category').val()
        };

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (res) {
                $('#indicatorCategoryForm')[0].reset();
                $('#indicatorca_categoryId').val('');
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
    function deleteIndicatorCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/indicator-category/${id}`,
                    method: 'POST',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        _method: 'DELETE'
                    },
                    success: function (res) {
                        fetchIndicatorCategory(); // Refresh the table
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The Indicator Category has been deleted.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong while deleting.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    $('#key-performance-area').change(function () {
        const kpaId = $(this).val();
        if (kpaId) {
            $.get(`/indicator-categories/${kpaId}`, function (data) {
                let options = '<option value="">Select Category</option>';
                data.forEach(function (cat) {
                    options += `<option value="${cat.id}">${cat.indicator_category}</option>`;
                });
                $('#indicator-category').html(options);
            });
        } else {
            $('#indicator-category').html('<option value="">Select KPA first</option>');
        }
    });
    $(document).ready(function () {
        fetchIndicatorCategory();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\pms\resources\views\admin\indicator.blade.php ENDPATH**/ ?>