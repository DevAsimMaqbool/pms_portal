
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
      <table class="table border-top" id="keyPerformanceTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
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
    <div class="modal fade" id="keyPerformanceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple">
            <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h3 class="modal-title" id="modalTitle">Add Key Performance Area</h3>
                    <p class="text-body-secondary">Key Performance Area you may use and assign to your users.</p>
                </div>
                
                <form id="keyPerformanceForm" class="row">
                    <input type="hidden" id="keyPerformanceId">
                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label" for="key-performance-area">Name</label>
                        <input type="text" id="key-performance-area" name="key_performance_area" required class="form-control" />
                        <div class="invalid-feedback" id="key-performance-areaError"></div>
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
    const modal = new bootstrap.Modal(document.getElementById('keyPerformanceModal'));
    let isEdit = false;

    function fetchKeyperformance() {
        $.ajax({
            url: "<?php echo e(route('key-performance-area.index')); ?>",
            method: "GET",
            dataType: "json",
            success: function (data) {
                
                const rowData = data.map((s, i) => {
                    const createdAt = new Date(s.created_at);
                    const formattedDate = createdAt.toISOString().split('T')[0];
                    return [
                        i + 1,
                        s.performance_area || 'N/A',
                        formattedDate,
                        `<div class="d-flex align-items-center">
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="editKeyperformance(${s.id})">
                                <i class="icon-base ti tabler-edit icon-22px"></i>
                            </a>
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="deleteKeyperformance(${s.id})">
                                <i class="icon-base ti tabler-trash icon-md"></i>
                            </a>
                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="performance/${s.id}">
                                <i class="icon-base ti tabler-eye icon-md"></i>
                            </a>
                        </div>`
                    ];
                });

                // Initialize DataTable only once
                if (!$.fn.DataTable.isDataTable('#keyPerformanceTable')) {
                    window.keyPerformanceTable = $('#keyPerformanceTable').DataTable({
                        processing: true,
                        paging: true,
                        searching: true,
                        ordering: true,
                        data: rowData,
                        columns: [
                            { title: "#" },
                            { title: "Name" },
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
                                                text: '<i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i> <span class="d-none d-sm-inline-block">Add Key Performance Area</span>',
                                                className: "btn",
                                                action: function () {
                                                    openAddKeyPerformanceModal();
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
                    window.keyPerformanceTable.clear().rows.add(rowData).draw();
                }
            },
            error: function (xhr) {
                console.error("Error fetching complaint:", xhr.responseText);
            }
        });
    }

    function openAddKeyPerformanceModal() {
        isEdit = false;
        $('#modalTitle').text('Add Key Performance Area');
        $('#keyPerformanceForm')[0].reset();
        $('#keyPerformanceId').val('');
        $('.invalid-feedback').text('');
        modal.show();
    }

    function editKeyperformance(id) {
        isEdit = true;
        $.get(`/key-performance-area/${id}/edit`, function (data) {
            $('#keyPerformanceId').val(data.id);
            $('#key-performance-area').val(data.performance_area);
            $('#modalTitle').text('Edit Key Performance Area');
            $('.invalid-feedback').text('');
            modal.show();
        });
    }

    $('#keyPerformanceForm').submit(function (e) {
        e.preventDefault();
        const id = $('#keyPerformanceId').val();
        const url = isEdit ? `/key-performance-area/${id}` : "<?php echo e(route('key-performance-area.store')); ?>";
        const method = isEdit ? 'PUT' : 'POST';
        const formData = {
            _token: "<?php echo e(csrf_token()); ?>",
            _method: method,
            key_performance_area: $('#key-performance-area').val()
        };
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (res) {
                $('#keyPerformanceForm')[0].reset();
                $('#keyPerformanceId').val('');
                modal.hide();
                Swal.fire({
                title: "Good job!",
                icon: "success",
                 customClass: {
                    confirmButton: "btn btn-primary waves-effect waves-light"
                },
                buttonsStyling: !1
                });
                fetchKeyperformance();
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                 $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]).show();
                    });
            }
        });
    });
    function deleteKeyperformance(id) {
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
                    url: `/key-performance-area/${id}`,
                    method: 'POST',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        _method: 'DELETE'
                    },
                    success: function (res) {
                        fetchKeyperformance(); // Refresh the table
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The Key Performance Area has been deleted.',
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


    $(document).ready(function () {
        fetchKeyperformance();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\pms\resources\views/admin/key_performance_area.blade.php ENDPATH**/ ?>