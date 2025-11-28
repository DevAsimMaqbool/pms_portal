@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card">
                <div class="card-datatable table-responsive card-body">
                    <form id="researchForm" class="row" method="POST"
                          action="{{ route('employee.rating.update', $rating->id) }}">
                        @csrf
                        <div class="row" style="padding:20px; display:flex; flex-wrap:wrap; gap:15px;">

                            <!-- Faculty Member -->
                            <div class="col-md-6">
                                <label class="form-label">Name of Faculty Member</label>
                                <select name="employee_id" class="select2 form-select" required  disabled>
                                    <option value="">-- Select Faculty Member --</option>
                                    @foreach($facultyMembers as $member)
                                        <option value="{{ $member->id }}" 
                                            {{ $rating->employee_id == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Responsibility & Accountability -->
                            <h6 style="width:100%; margin-top:20px; font-weight:bold;">1- Responsibility & Accountability</h6>

                            <div class="col-md-6 mt-1" style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                                <label style="font-weight:bold; margin-bottom:8px;">Admits mistakes and takes responsibility for correcting them</label>
                                <div style="margin-top:8px;">
                                    @foreach([20 => 'Strongly Disagree', 40 => 'Disagree', 60 => 'Neutral', 80 => 'Agree', 100 => 'Strongly Agree'] as $val => $label)
                                        <label style="margin-right:15px;">
                                            <input type="radio" name="responsibility_accountability_1" value="{{ $val }}"
                                                {{ $rating->responsibility_accountability_1 == $val ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6 mt-1" style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                                <label style="font-weight:bold; margin-bottom:8px;">Keeps commitments and meets deadlines consistently</label>
                                <div style="margin-top:8px;">
                                    @foreach([20 => 'Strongly Disagree', 40 => 'Disagree', 60 => 'Neutral', 80 => 'Agree', 100 => 'Strongly Agree'] as $val => $label)
                                        <label style="margin-right:15px;">
                                            <input type="radio" name="responsibility_accountability_2" value="{{ $val }}"
                                                {{ $rating->responsibility_accountability_2 == $val ? 'checked' : '' }}> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Repeat Sections 2-5 in same pattern -->
                            @php
    $sections = [
        'empathy_compassion' => '2- Empathy & Compassion',
        'humility_service' => '3- Humility & Service',
        'honesty_integrity' => '4- Honesty & Integrity',
        'inspirational_leadership' => '5- Inspirational Leadership'
    ];
                            @endphp

                            @foreach($sections as $key => $title)
                                <h6 style="width:100%; margin-top:30px; font-weight:bold;">{{ $title }}</h6>
                                @for($i = 1; $i <= 2; $i++)
                                    <div class="col-md-6 mt-1" style="flex:1 1 calc(50% - 15px); padding:15px; border:1px solid #ddd; border-radius:6px;">
                                        <label style="font-weight:bold; margin-bottom:8px;">
                                            {{ ucwords(str_replace('_', ' ', $key)) }} {{ $i }}
                                        </label>
                                        <div style="margin-top:8px;">
                                            @foreach([20 => 'Strongly Disagree', 40 => 'Disagree', 60 => 'Neutral', 80 => 'Agree', 100 => 'Strongly Agree'] as $val => $label)
                                                <label style="margin-right:15px;">
                                                    <input type="radio" name="{{ $key }}_{{ $i }}" value="{{ $val }}"
                                                        {{ $rating->{$key . '_' . $i} == $val ? 'checked' : '' }}> {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endfor
                            @endforeach

                            <!-- Remarks -->
                            <div style="width:100%; margin-top:30px; margin-bottom:20px;">
                                <label style="font-weight:bold; margin-bottom:8px; display:block;">Remarks</label>
                                <textarea name="remarks" style="width:100%; height:120px; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ $rating->remarks }}</textarea>
                            </div>

                        </div>

                        <div class="col-4 text-center demo-vertical-spacing">
                            <button class="btn btn-primary w-100 waves-effect waves-light">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@push('script')
<script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endpush
