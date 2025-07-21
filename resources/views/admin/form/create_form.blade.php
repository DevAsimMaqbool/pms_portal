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
                <h5>Create Form </h5>
                <form method="POST" action="{{ route('forms.store') }}" enctype="multipart/form-data" class="row">
                    @csrf
                    <div class="row g-6">

                        <div class="col-md-12">
                            <label class="form-label" for="bs-validation-name">Form Title</label>
                            <input name="title" type="text" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <div id="fields-wrapper">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 mt-2">
                        <button type="button" onclick="addField()" class="btn btn-primary me-4">+ Add Field</button>
                    </div>
                    <div class="d-flex mt-5">
                        <!-- <button class="btn btn-primary ms-auto">Submit</button> -->
                        <button class="btn btn-primary w-100 waves-effect waves-light">Submit</button>
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

<script>
    let fieldCount = 0;

    function addField() {
        const wrapper = document.getElementById('fields-wrapper');
        const index = fieldCount++;

        const html = `<div class="row g-6">
                    <div class="col-md-6">
                        <label class="form-label">Label:</label>
                        <input class="form-control" name="fields[${index}][label]" required>
</div><div class="col-md-6">
                        <label class="form-label">Name:</label>
                        <input class="form-control" name="fields[${index}][name]" required>
</div><div class="col-md-6">
                        <label class="form-label">Type:</label>
                        <select class="form-select" name="fields[${index}][type]" onchange="handleTypeChange(event, ${index})" required>
                            <option value="">Select</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                            <option value="file">File</option>
                        </select>
</div>
                        <div id="options-${index}" style="display:none;" class="col-md-6">
                            <label class="form-label">Options (comma separated):</label>
                            <input class="form-control" name="fields[${index}][options]" placeholder="Option1,Option2,Option3">
                        </div>
                         <label class="form-label">
                            <input class="form-check-input" type="checkbox" name="fields[${index}][required]"> Required
                        </label>
</div>
                       
                    
                `;

        wrapper.insertAdjacentHTML('beforeend', html);
    }

    function handleTypeChange(e, index) {
        const type = e.target.value;
        const optionsDiv = document.getElementById(`options-${index}`);
        if (['select', 'checkbox', 'radio'].includes(type)) {
            optionsDiv.style.display = 'block';
        } else {
            optionsDiv.style.display = 'none';
        }
    }
</script>