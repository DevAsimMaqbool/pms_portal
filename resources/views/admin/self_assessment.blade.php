@extends('layouts.app')
@push('style')
    <style>
        .avatar-xl {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
        }

        .metric {
            font-size: .9rem;
            color: #6c757d;
        }

        .mini-tile {
            border: 1px solid var(--bs-border-color);
            border-radius: .75rem;
            padding: 1rem;
            background: #fff;
            height: 100%;
        }

        .mini-tile .label {
            color: #6e6b7b;
            font-size: .8rem;
        }

        .mini-tile .value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .spark-holder {
            height: 120px;
        }

        .kpa-card h6 {
            margin-bottom: .25rem;
        }

        .indicator-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem 0;
            border-bottom: 1px dashed var(--bs-border-color);
        }

        .indicator-row:last-child {
            border-bottom: none;
        }

        .status-badge {
            padding: .35rem .5rem;
        }

        .filter-row .form-select {
            min-width: 220px;
        }
    </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row g-6">
                        <!-- <div class="col-md-6 col-xxl-6">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="m-0 me-2">KPA</h5>
                                        </div>
                                    </div>
                                    <div class="px-5 py-4 border border-start-0 border-end-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-uppercase">Name</p>
                                            <p class="mb-0 text-uppercase">Performance</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-label-success"><i
                                                            class="icon-base ti tabler-book icon-lg"></i></span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">Teaching and Learning</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="badge bg-label-secondary">90%</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-label-success"><i
                                                            class="icon-base ti tabler-bulb icon-lg"></i></span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">Research, Innovation and Commercialisation</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="badge bg-label-secondary">91%</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-label-warning"><i
                                                            class="icon-base ti tabler-circle-dot icon-lg"></i></span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">Institutional Engagement
                                                            (Core only)</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="badge bg-label-secondary">92%</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-label-danger"><i
                                                            class="icon-base ti tabler-building-community icon-lg"></i></span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">Institutional Engagement (Operational+ Character
                                                            Strengths)</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="badge bg-label-secondary">97%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        <!-- Support Tracker -->
                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Self Assessment</h5>
                                    <small class="text-body-secondary float-end"></small>
                                </div>
                                <div class="card-body">
                                    <div class="card-datatable table-responsive">
                                        <form action="{{ route('self-assessment.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="term" class="form-label">Select Term</label>
                                                <select id="term" class="form-select" name="term" required>
                                                    <option value="">Select Option</option>
                                                    <option value="Fall" {{ isset($records) && $records->first()?->term == 'Fall' ? 'selected' : '' }}>Fall</option>
                                                    <option value="Spring" {{ isset($records) && $records->first()?->term == 'Spring' ? 'selected' : '' }}>Spring
                                                    </option>
                                                </select>
                                            </div>
                                            <table class="table border-top">
                                                <thead>
                                                    <tr>
                                                        <th>KPA</th>
                                                        <th>Challenge</th>
                                                        <th>Working</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
    $kpas = [
        0 => 'Teaching and Learning',
        1 => 'Research, Innovation and Commercialisation',
        2 => 'Institutional Engagement (Core only)',
        3 => 'Institutional Engagement (Operational+ Character Strengths)',
    ];
                                                    @endphp

                                                    @foreach($kpas as $i => $kpa)
                                                                                                @php
        $record = $records[$kpa] ?? null;
                                                                                                @endphp
                                                                                                <tr>
                                                                                                    <td>{{ $kpa }}</td>

                                                                                                    <td>
                                                                                                        <textarea name="data[{{ $i }}][challenge]"
                                                                                                            class="form-control">{{ $record->challenge ?? '' }}</textarea>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <textarea name="data[{{ $i }}][working]"
                                                                                                            class="form-control">{{ $record->working ?? '' }}</textarea>
                                                                                                    </td>
                                                                                                </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                            
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/js/cards-analytics.js')}}"></script>

    <script>

    </script>
@endpush