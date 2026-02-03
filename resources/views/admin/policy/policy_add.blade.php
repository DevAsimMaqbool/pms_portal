@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <form id="researchForm" class="row" method="POST" action="{{ route('policy.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3" style="padding:20px; font-family:Arial;">
                        <div class="col-md-6">
                            <label for="sopFile" class="form-label">PMS SOPs</label>
                            <input class="form-control" type="file" id="sopFile" name="sop_file">
                        </div>
                        <div class="col-md-6">
                            <label for="policyFile" class="form-label">PMS Policy</label>
                            <input class="form-control" type="file" id="policyFile" name="policy_file">
                        </div>
                    </div>
                    <div class="mt-3 text-end" style="margin-left: -20px;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
@endpush