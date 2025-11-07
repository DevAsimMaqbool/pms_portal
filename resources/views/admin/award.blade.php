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
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                        <img class="img-fluid" src="{{ asset('admin/assets/img/avatars/rewards-fives.png') }}"
                            alt="Card girl image" width="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sitara-e-Qiyadat</h5>
                        <p class="card-text">Chairman’s Leadership Excellence Award</p>
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#SitaraeQiyadat">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="text-center"
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
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
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
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
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
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
                        style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
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

    <div class="modal fade" id="SitaraeQiyadat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel4">Sitara-e-Qiyadat</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- data -->
                        <div class="row rounded-3" style="background:linear-gradient(135deg, #000000 0%, #1a0000 40%, #ad4949 100%)">
                            <div class="col-md-8 order-md-0 order-1 d-flex justify-content-center align-items-center text-white">
                                <p class="mb-6">The Sitara-e-Qiyadat – Chairman’s Leadership Excellence Award has been established to honor outstanding leaders within the Superior University community whose vision, commitment, and influence have set new benchmarks of excellence. This prestigious award recognizes individuals who not only demonstrate exceptional leadership within their areas of responsibility but also embody the spirit of innovation, courage, and
                                service that leadership demands in shaping society. The Sitara-e-Qiyadat award symbolizes the pioneering spirit of Superior University: a spirit that believes in leading from the front, creating new possibilities, and making meaningful contributions to society. It is a tribute to those leaders who exemplify Superior’s commitment to excellence, and whose efforts ripple far beyond the boundaries.</p>
                                
                            </div>
                            <div class="col-md-4 order-md-1 order-0">
                                <div class="text-center mx-3 mx-md-0">
                                <img src="{{ asset('admin/assets/img/avatars/rewards-twos.png') }}" class="img-fluid" alt="Api Key Image" width="202">
                                </div>
                            </div>
                        </div>
                   <!-- /data -->
                    <!-- data -->
                        <div class="row mt-6">
                            
                            <div class="col-md-12">
                                  

                                  <div class="table-responsive text-nowrap">
                                <table class="table table-bordered table-hover"">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Award Category</th>
                                        <th>Level</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best Deen of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best Support Leader</span>
                                        </td>
                                        <td>Universitry Administration</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best Program Leader-UnderGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best Program Leader-PostGrad of the Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Special Initiatives</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best House Leader</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>
                                        <i class="icon-base ti tabler-user-heart icon-md text-success me-4"></i>
                                        <span class="fw-medium">Best HOD of Year</span>
                                        </td>
                                        <td>Universitry</td>
                                        <td><span class="badge bg-label-primary me-1">Annual</span></td>
                                       
                                    </tr>
                                    
                                    </tbody>
                                </table>
                                </div>



                            </div>
                        </div>
                   <!-- /data -->
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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