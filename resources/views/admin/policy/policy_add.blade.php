@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
        <div class="col-md-12">
           @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="ti tabler-check me-2"></i>
                                {{ session('success') }}

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ti tabler-alert-circle me-2"></i>
                                {{ session('error') }}

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the following errors:</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif
        </div>
            <div class="col-md-6">
                 <div class="card">
                 <h5 class="card-header">PMS SOPs</h5>
                    <div class="card-datatable table-responsive card-body">
                        <form id="researchForm" class="row" method="POST" action="{{ route('policy.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                            <div class="col-md-12 d-none">
                                    <input class="form-control" type="text" id="sop_name" name="sop_name" value="SOP" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="sopFile" class="form-label">PMS SOPs</label>
                                    <input class="form-control" type="file" id="sopFile" name="sop_file" required>
                                   
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-6">
                                        <label for="contributions" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-end" style="margin-left: -20px;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           <div class="col-md-6">
                 <div class="card">
                 <h5 class="card-header">PMS Policy</h5>
                    <div class="card-datatable table-responsive card-body">
                        <form id="researchForm" class="row" method="POST" action="{{ route('policy.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                            <div class="col-md-12 d-none">
                                    <input class="form-control" type="text" id="sop_name" name="sop_name" value="POLICY" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="sopFile" class="form-label">PMS Policy</label>
                                    <input class="form-control" type="file" id="sopFile" name="sop_file" required>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-6">
                                        <label for="contributions" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-end" style="margin-left: -20px;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        


        
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
@endpush