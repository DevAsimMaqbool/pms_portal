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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <h5>Assign Indicators to Role</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('assignments.store') }}" method="POST" class="row">
                    @csrf
                    <input type="hidden" id="indicator_Id">
                    <div class="col-4 form-control-validation mb-4">
                        <label class="form-label" for="role_id">Select Role</label>
                        <select name="role_id" class="select2 form-select" data-allow-clear="true" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="role_idError"></div>
                    </div>
                    <div class="col-4 form-control-validation mb-4">
                        <label class="form-label" for="kpa">Key Performance Area</label>
                        <select id="kpa" name="key_performance_area_id" class="form-select" required>
                            <option value="">-- Select KPA --</option>
                            @foreach($kpas as $kpa)
                                <option value="{{ $kpa->id }}">{{ $kpa->performance_area }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback" id="kpaError"></div>
                    </div>

                    <div class="col-4 form-control-validation mb-4">
                        <label class="form-label" for="category">Indicator Category</label>
                        <select id="category" class="form-select" data-allow-clear="true" name="indicator_category_id"
                            required>
                        </select>
                        <div class="invalid-feedback" id="categoryError"></div>
                    </div>
                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label" for="indicator">Indicators</label>
                        <div id="indicators"></div>
                        <div class="invalid-feedback" id="indicatorError"></div>
                    </div>
                    <div class="col-1 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">Assign</button>
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
@endpush
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kpaDropdown = document.getElementById('kpa');

            if (!kpaDropdown) {
                console.error("❌ Element with id='kpa' not found.");
                return;
            }

            console.log("✅ Element with id='kpa' found.");

            kpaDropdown.addEventListener('change', function () {
                let kpaId = this.value;
                fetch(`/categories/${kpaId}`)
                    .then(res => res.json())
                    .then(data => {
                        let categorySelect = document.getElementById('category');
                        categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
                        data.forEach(c => {
                            categorySelect.innerHTML += `<option value="${c.id}">${c.indicator_category}</option>`;
                        });
                        document.getElementById('indicators').innerHTML = '';
                    });
            });
        });

        document.getElementById('category').addEventListener('change', function () {
            let categoryId = this.value;
            fetch(`/indicators/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    let indicatorDiv = document.getElementById('indicators');
                    indicatorDiv.innerHTML = '';
                    data.forEach(ind => {
                        indicatorDiv.innerHTML += `<div class="form-check custom-option custom-option-basic"><label class="form-check-label custom-option-content" for="indicator-${ind.id}"><input class="form-check-input" name="indicators[]" type="checkbox" value="${ind.id}" id="indicator-${ind.id}"><span class="custom-option-header"><span class="h6 mb-0">${ind.indicator}</span></span></label></div>`;
                    });
                });
        });
    </script>
@endpush