@extends('layouts.pdf')

@section('title', 'Goal Mapping Report')

@section('content')

<style>
    @page {
        margin: 8px 10px;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 9px;
        line-height: 1.2;
        color: #2c3e50;
    }

    .section-title {
        background: #1f4e78;
        color: #fff;
        padding: 5px;
        text-align: center;
        font-size: 11px;
        margin: 6px 0;
    }

    table {
        width:100%;
        border-collapse:collapse;
        margin-bottom:10px;
    }

    th{
        background:#1f4e78;
        color:#fff;
        border:1px solid #d0d7de;
        padding:4px;
        font-size:8px;
    }

    td{
        border:1px solid #d0d7de;
        padding:4px;
        font-size:8px;
        vertical-align:top;
    }

    .signature-line{
        margin-top:30px;
        border-top:1px solid #000;
        width:80%;
    }
</style>

{{-- ===================================================== --}}
{{-- GOAL STATEMENTS --}}
{{-- ===================================================== --}}

<div class="section-title">
    Goal Statements
</div>

@foreach($assignments as $assignment)

<table>

    <tr style="background:#f5f5f5;font-weight:bold;">
        <td colspan="2">

            {{ $assignment->goal->goal_cod }}

            -

            {{ $assignment->goal->goal_name }}

        </td>
    </tr>

    <tr>

        <td width="20%">
            Role
        </td>

        <td>

            {{ $assignment->role->name }}

        </td>

    </tr>

    <tr>

        <td>
            Driver
        </td>

        <td>

            {{ $assignment->goal->driver->driver_name ?? '' }}

        </td>

    </tr>

    <tr>

        <td>
            KPA
        </td>

        <td>

            {{ $assignment->kpa->performance_area ?? '' }}

        </td>

    </tr>

    <tr>

        <td>
            Goal Statement
        </td>

        <td>

            {{ $assignment->goal->goal_statement }}

        </td>

    </tr>

</table>

@endforeach


{{-- ===================================================== --}}
{{-- GOAL / OBJECTIVE MAPPING --}}
{{-- ===================================================== --}}

<div class="section-title">
    Goal & Strategic Objective Mapping
</div>

<table>

    <thead>

    <tr>

        <th width="10%">Goal</th>

        <th width="15%">Role</th>

        <th width="15%">KPA</th>

        <th width="30%">Goal Statement</th>

        <th width="30%">Objective</th>

    </tr>

    </thead>

    <tbody>

@foreach($assignments as $assignment)

@foreach($assignment->details->groupBy('objective_id') as $objectiveId => $details)

@php
$objective = $details->first()->objective;
@endphp

<tr>

<td>

{{ $assignment->goal->goal_cod }}

</td>

<td>

{{ $assignment->role->name }}

</td>

<td>

{{ $assignment->kpa->performance_area ?? '' }}

</td>

<td>

{{ $assignment->goal->goal_statement }}

</td>

<td>

{{ $objective->objective_cod }}

-

{{ $objective->title }}

</td>

</tr>

@endforeach

@endforeach

</tbody>

</table>


{{-- ===================================================== --}}
{{-- KPI MAPPING --}}
{{-- ===================================================== --}}

@foreach($assignments as $assignment)

<div class="section-title">

{{ $assignment->goal->goal_cod }}

-

{{ $assignment->goal->goal_name }}

</div>

<table>

<thead>

<tr>

<th width="22%">
Objective
</th>

<th width="18%">
Dimension
</th>

<th width="22%">
Indicator
</th>

<th width="10%">
Target
</th>

<th width="10%">
Weight
</th>

<th width="8%">
Period
</th>

<th width="10%">
Contributor
</th>

</tr>

</thead>

<tbody>
@foreach($assignment->details->groupBy('objective_id') as $objectiveId => $details)

    @php
        $objective = $details->first()->objective;

        $objectiveRowspan = 0;

        foreach($details as $detail){
            $objectiveRowspan += max($detail->indicators->count(),1);
        }

        $firstObjective = true;
    @endphp


    @foreach($details as $detail)

        @php

            $dimensionRowspan = max($detail->indicators->count(),1);

            $firstDimension = true;

        @endphp


        @forelse($detail->indicators as $assignmentIndicator)

            <tr>

                {{-- OBJECTIVE --}}
                @if($firstObjective)

                    <td rowspan="{{ $objectiveRowspan }}">

                        {{ $objective->objective_cod }}

                        -

                        {{ $objective->title }}

                    </td>

                @endif


                {{-- DIMENSION --}}
                @if($firstDimension)

                    <td rowspan="{{ $dimensionRowspan }}">

                        {{ $detail->dimension->dimension_cod }}

                        -

                        {{ $detail->dimension->name }}

                    </td>

                @endif


                {{-- KPI --}}
                <td>

                    {{ $assignmentIndicator->indicator->indicator }}

                </td>


                {{-- TARGET --}}
                <td>

                    {{ $detail->dimension_target }}

                </td>


                {{-- WEIGHT --}}
                <td>

                    {{ $detail->dimension_weight }}

                </td>


                {{-- PERIOD --}}
                <td>

                    Annual

                </td>


                {{-- CONTRIBUTOR --}}
                <td>

                    {{ $assignment->role->name }}

                </td>

            </tr>

            @php

                $firstObjective = false;

                $firstDimension = false;

            @endphp

        @empty

            <tr>

                @if($firstObjective)

                    <td rowspan="{{ $objectiveRowspan }}">

                        {{ $objective->objective_cod }}

                        -

                        {{ $objective->title }}

                    </td>

                @endif


                <td>

                    {{ $detail->dimension->dimension_cod }}

                    -

                    {{ $detail->dimension->name }}

                </td>


                <td colspan="5" style="text-align:center">

                    No Indicator Assigned

                </td>

            </tr>

            @php

                $firstObjective = false;

            @endphp

        @endforelse

    @endforeach

@endforeach

</tbody>

</table>

@endforeach


{{-- ===================================================== --}}
{{-- APPROVAL --}}
{{-- ===================================================== --}}

<div class="section-title">
    Approval & Endorsement
</div>

<table>

    <tr>

        <th>
            Chairman Board of Governors
        </th>

        <th>
            Rector
        </th>

        <th>
            Date of Approval
        </th>

    </tr>

    <tr>

        <td style="height:70px;text-align:center;vertical-align:bottom;">

            <div class="signature-line"></div>

            Signature & Name

        </td>

        <td style="text-align:center;vertical-align:bottom;">

            <div class="signature-line"></div>

            Signature & Name

        </td>

        <td style="text-align:center;vertical-align:bottom;">

            <div class="signature-line"></div>

            Signature & Date

        </td>

    </tr>

</table>

@endsection