@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Performance Improvement Plan</h5>

            <button
                class="btn btn-primary"
                id="addPip">

                <i class="ti tabler-plus"></i>
                Add PIP

            </button>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                    class="table table-bordered"
                    id="pipTable"
                    width="100%">

                    <thead>

                    <tr>

                        <th>#</th>

                        <th>Faculty Members</th>

                        <th>Description</th>

                        <th>Document</th>

                        <th>Created</th>

                        <th width="150">Action</th>

                    </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>



<!-- Modal -->

<div
    class="modal fade"
    id="pipModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                id="pipForm"
                enctype="multipart/form-data">

                @csrf

                <input
                    type="hidden"
                    id="pip_id"
                    name="pip_id">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Performance Improvement Plan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- Faculty -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Faculty Members

                            </label>

                            <select
                                class="form-select select2"
                                id="faculty_member_id"
                                name="faculty_member_id[]"
                                multiple>

                                @foreach($facultyMembers as $member)

                                    <option value="{{ $member->id }}">

                                        {{ $member->name }}

                                        @if($member->roles->count())

                                            ({{ $member->roles->first()->name }})

                                        @endif

                                    </option>

                                @endforeach

                            </select>

                            <span class="text-danger faculty_member_id_error"></span>

                        </div>

                        <!-- Description -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                class="form-control"
                                rows="5"
                                id="description"
                                name="description"></textarea>

                            <span class="text-danger description_error"></span>

                        </div>

                        <!-- Document -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Upload Document

                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="document"
                                name="document">

                            <span class="text-danger document_error"></span>

                        </div>

                        <!-- Existing Document -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Current Document

                            </label>

                            <div id="currentDocument">

                                No File

                            </div>

                        </div>

                        <!-- Status -->

                        <div class="col-md-6 mb-3 d-none">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                class="form-select"
                                id="status"
                                name="status">

                                <option value="not_started" selected>

                                    Not Started

                                </option>

                                <option value="inprogress">

                                    In Progress

                                </option>

                                <option value="completed">

                                    Completed

                                </option>

                            </select>

                            <span class="text-danger status_error"></span>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-label-secondary"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('script')

<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>

<script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

<script>

$(function(){

    $('#faculty_member_id').select2({

        dropdownParent:$('#pipModal'),

        width:'100%',

        placeholder:'Select Faculty Members'

    });

});
$(document).ready(function () {

    loadPipData();

    // ============================
    // Add New
    // ============================

    $("#addPip").click(function () {

        $("#pipForm")[0].reset();

        $("#pip_id").val("");

        $("#faculty_member_id").val(null).trigger("change");

        $("#currentDocument").html("");

        $(".text-danger").html("");

        $("#pipModal").modal("show");

    });


    // ============================
    // Save & Update
    // ============================

    $("#pipForm").submit(function (e) {

        e.preventDefault();

        $(".text-danger").html("");

        let id = $("#pip_id").val();

        let formData = new FormData(this);

        let url = "{{ route('pip.store') }}";

        if (id != "") {

            url = "/pip/" + id;

            formData.append("_method", "PUT");

        }

        $.ajax({

            url: url,

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            beforeSend: function () {

                $("button[type=submit]")
                    .prop("disabled", true)
                    .html("Saving...");

            },

            success: function (response) {

                $("button[type=submit]")
                    .prop("disabled", false)
                    .html("Save");

                $("#pipModal").modal("hide");

                $("#pipForm")[0].reset();

                $("#faculty_member_id")
                    .val(null)
                    .trigger("change");

                loadPipData();

                Swal.fire({

                    icon: "success",

                    title: "Success",

                    text: response.message,

                    timer: 1800,

                    showConfirmButton: false

                });

            },

            error: function (xhr) {

                $("button[type=submit]")
                    .prop("disabled", false)
                    .html("Save");

                $(".text-danger").html("");

                if (xhr.status == 422) {

                    $.each(xhr.responseJSON.errors, function (key, value) {

                        $("." + key + "_error").html(value[0]);

                    });

                } else {

                    Swal.fire({

                        icon: "error",

                        title: "Error",

                        text: xhr.responseJSON.message

                    });

                }

            }

        });

    });


    // ============================
    // Edit
    // ============================

    $(document).on("click", ".editBtn", function () {

        let id = $(this).data("id");

        $(".text-danger").html("");

        $.ajax({

            url: "/pip/" + id,

            type: "GET",

            success: function (response) {

                $("#pip_id").val(response.id);

                $("#description").val(response.description);

                $("#status").val(response.status);

                $("#document").val("");

                if (response.faculty_member_id) {

                    $("#faculty_member_id")
                        .val(response.faculty_member_id)
                        .trigger("change");

                }

                if (response.document) {

                    $("#currentDocument").html(

                        '<a href="/storage/' +

                        response.document +

                        '" target="_blank" class="btn btn-sm btn-info">View Document</a>'

                    );

                } else {

                    $("#currentDocument").html("No File");

                }

                $("#pipModal").modal("show");

            }

        });

    });


    // ============================
    // Delete
    // ============================

    $(document).on("click", ".deleteBtn", function () {

        let id = $(this).data("id");

        Swal.fire({

            title: "Delete Record?",

            text: "You won't be able to recover this record.",

            icon: "warning",

            showCancelButton: true,

            confirmButtonText: "Yes Delete",

            cancelButtonText: "Cancel"

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "/pip/" + id,

                    type: "POST",

                    data: {

                        _token: "{{ csrf_token() }}",

                        _method: "DELETE"

                    },

                    success: function (response) {

                        loadPipData();

                        Swal.fire({

                            icon: "success",

                            title: "Deleted",

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        });

                    },

                    error: function (xhr) {

                        Swal.fire({

                            icon: "error",

                            title: "Error",

                            text: xhr.responseJSON.message

                        });

                    }

                });

            }

        });

    });

});
// ===========================
// Load Data
// ===========================

function loadPipData() {

    $.ajax({

        url: "{{ route('pip.index') }}",

        type: "GET",

        success: function (response) {

            $('#pipTable').DataTable({

                destroy: true,

                processing: true,

                data: response,

                columns: [

                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },

                    {
                        data: "assign_users",
                        render: function (data) {

                            return renderUsers(data);

                        }
                    },

                    {
                        data: "description"
                    },

                    {
                        data: "document",
                        render: function (data) {

                            return renderDocument(data);

                        }
                    },

                   

                    {
                        data: "created_at",
                        render: function (data) {

                            return formatDate(data);

                        }
                    },

                    {
                        data: "id",
                        render: function (data) {

                            return renderAction(data);

                        }
                    }

                ]

            });

        }

    });

}


// ===========================
// Faculty Names
// ===========================

function renderUsers(users) {

    if (!users || users.length == 0) {

        return '<span class="badge bg-label-danger">No Faculty</span>';

    }

    let html = '';

    users.forEach(function (item) {

        html +=
            '<span class="badge bg-label-primary me-1 mb-1">' +
            item.user.name +
            '</span>';

    });

    return html;

}


// ===========================
// Document
// ===========================

function renderDocument(document) {

    if (!document) {

        return "-";

    }

    let file = "/storage/" + document;

    let ext = document.split('.').pop().toLowerCase();

    if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) >= 0) {

        return `<img
                    src="${file}"
                    width="60"
                    height="60"
                    class="img-thumbnail doc-preview"
                    data-src="${file}"
                    style="cursor:pointer;">`;

    }

    return `<a
                href="${file}"
                target="_blank"
                class="btn btn-sm btn-info">

                View File

            </a>`;

}


// ===========================
// Status Dropdown
// ===========================

function renderStatusDropdown(id, status) {

    return `

    <select
        class="form-select form-select-sm status-select"
        data-id="${id}">

        <option value="not_started"

        ${status=='not_started'?'selected':''}>

        Not Started

        </option>

        <option value="inprogress"

        ${status=='inprogress'?'selected':''}>

        In Progress

        </option>

        <option value="completed"

        ${status=='completed'?'selected':''}>

        Completed

        </option>

    </select>

    `;

}


// ===========================
// Action Buttons
// ===========================

function renderAction(id) {

    return `

        <button

            class="btn btn-sm btn-warning editBtn"

            data-id="${id}">

            <i class="ti tabler-edit"></i>

        </button>

        <button

            class="btn btn-sm btn-danger deleteBtn"

            data-id="${id}">

            <i class="ti tabler-trash"></i>

        </button>

    `;

}


// ===========================
// Date
// ===========================

function formatDate(date) {

    if (!date) {

        return "-";

    }

    return new Date(date)
        .toLocaleDateString();

}


// ===========================
// Preview Image
// ===========================

$(document).on("click",".doc-preview",function(){

    Swal.fire({

        title:"Document",

        imageUrl:$(this).data("src"),

        imageWidth:500,

        confirmButtonText:"Close"

    });

});


// ===========================
// Status Update
// ===========================

$(document).on("change",".status-select",function(){

    let id=$(this).data("id");

    let status=$(this).val();

    $.ajax({

        url:"/pip/"+id+"/update-status",

        type:"POST",

        data:{

            _token:"{{ csrf_token() }}",

            status:status

        },

        success:function(response){

            Swal.fire({

                icon:"success",

                title:"Updated",

                text:response.message,

                timer:1500,

                showConfirmButton:false

            });

        },

        error:function(){

            Swal.fire({

                icon:"error",

                title:"Error",

                text:"Unable to update status."

            });

        }

    });

});

</script>

@endpush