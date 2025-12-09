@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
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

                    <div class="row g-3" style="padding:20px; font-family:Arial;">
                        <!-- Type -->
                        <div class="col-md-6">
                            <label for="sopFile" class="form-label">PMS SOPs</label>
                            <input class="form-control" type="file" id="sopFile" name="sop_file">
                            @if($policy->sop_file)
                                <p class="mt-2">Current File:
                                    <a href="{{ asset('storage/' . $policy->sop_file) }}" target="_blank">View</a>
                                </p>
                            @endif
                        </div>

                        <!-- File -->
                        <div class="col-md-6">
                            <label for="policyFile" class="form-label">PMS Policy</label>
                            <input class="form-control" type="file" id="policyFile" name="policy_file">
                            @if($policy->policy_file)
                                <p class="mt-2">Current File:
                                    <a href="{{ asset('storage/' . $policy->policy_file) }}" target="_blank">View</a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-4 text-center mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light">UPDATE</button>
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