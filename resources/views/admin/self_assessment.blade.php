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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row g-6">
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
                                        <option value="Fall 2025" {{ isset($records) && $records->first()?->term == 'Fall 2025' ? 'selected' : '' }}>Fall 2025</option>
                                        <option value="Spring 2025" {{ isset($records) && $records->first()?->term == 'Spring 2025' ? 'selected' : '' }}>Spring 2025
                                        </option>
                                    </select>
                                </div>
                                <table class="table border-top">
                                    <thead>
                                        <tr>
                                            <th>KPA</th>
                                            <th>General Comments</th>
                                            <th>Challenge</th>
                                            <th>Strength</th>
                                            <th>Training Required</th>
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
                                                    <textarea name="data[{{ $i }}][general_comments]"
                                                        class="form-control">{{ $record->general_comments ?? '' }}</textarea>
                                                </td>

                                                <td>
                                                    <textarea name="data[{{ $i }}][challenge]"
                                                        class="form-control">{{ $record->challenge ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    <textarea name="data[{{ $i }}][strength]"
                                                        class="form-control">{{ $record->strength ?? '' }}</textarea>
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
        $(document).ready(function () {
            $('#term').on('change', function () {
                var kfaId = $(this).val();

                $.ajax({
                    url: '{{ route("self-assessment.termData") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        term: kfaId
                    },
                    success: function (data) {
                        console.log(data);
                        var kpas = [
                            'Teaching and Learning',
                            'Research, Innovation and Commercialisation',
                            'Institutional Engagement (Core only)',
                            'Institutional Engagement (Operational+ Character Strengths)'
                        ];

                        kpas.forEach(function (kpa, index) {
                            var record = data[kpa] || {};
                            $('textarea[name="data[' + index + '][general_comments]"]').val(record.general_comments || '');
                            $('textarea[name="data[' + index + '][challenge]"]').val(record.challenge || '');
                            $('textarea[name="data[' + index + '][strength]"]').val(record.strength || '');
                            $('textarea[name="data[' + index + '][working]"]').val(record.working || '');
                        });
                    },
                    error: function (xhr) {
                        console.error('Error fetching term data', xhr);
                    }
                });
            });
        }); 
    </script>
@endpush