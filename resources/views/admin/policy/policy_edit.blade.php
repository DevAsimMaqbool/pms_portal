@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
             <h5 class="card-header">Edit Policies & SOPs</h5>
            <div class="card-datatable table-responsive card-body">
                @if ($errors->any())
                    <div id="errorAlert" class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <script>
                        setTimeout(function () {
                            const alert = document.getElementById('errorAlert');
                            if (alert) alert.style.display = 'none';
                        }, 2000); // 2000ms = 2 seconds
                    </script>
                @endif

                <form id="researchForm" class="row" method="POST" action="{{ route('policy.update', $policy->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- For non-GET/POST, use method spoofing -->
                    @method('POST') <!-- keep POST for update route as per controller -->

                    <div class="row g-3">
                        <!-- Type -->
                         <div class="col-md-12 d-none">
                                    <input class="form-control" type="text" id="sop_name" name="sop_name" value="{{ $policy->sop_name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="sopFile" class="form-label">PMS {{ $policy->sop_name }}</label>
                            <input class="form-control" type="file" id="sopFile" name="sop_file">
                            @if($policy->sop_file)
                                <p class="mt-2">Current File:
                                    <a href="{{ asset('storage/' . $policy->sop_file) }}" target="_blank">View</a>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="mb-6">
                                <label for="contributions" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>@if($policy->description){{ $policy->description }}@endif
                                </textarea>
                            </div>
                        </div>
                    </div>


                    <div class="text-end" style="margin-left: -20px;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">UPDATE</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush