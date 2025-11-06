@extends('layouts.app')

@push('style')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Examples -->
        <div class="row mb-12 g-6">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #4b0000 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sitara-e-Qiyadat</h5>
                        <p class="card-text">Chairman’s Leadership Excellence Award</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #4b0000 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-threes.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Fakhr-e-Karkardagi</h5>
                        <p class="card-text">Rector’s Academic Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #4b0000 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tamgha-e-Tahqeeq</h5>
                        <p class="card-text">Research Excellence Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #4b0000 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-one.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Chaudhry Muhammad Akram</h5>
                        <p class="card-text"> Entrepreneurial Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #4b0000 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fours.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Service Superheroes</h5>
                        <p class="card-text">Awards</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light">Explore</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- Examples -->
    </div>
@endsection

@push('script')
    {{--
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-ecommerce-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards-advance.js') }}"></script> --}}


@endpush