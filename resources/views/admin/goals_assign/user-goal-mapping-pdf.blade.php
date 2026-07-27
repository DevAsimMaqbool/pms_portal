@extends('layouts.pdf')

@section('title', 'User Goal Mapping Report')

@section('content')

<style>
    @page{
        margin:8px 10px;
    }

    body{
        font-family: DejaVu Sans,sans-serif;
        font-size:9px;
        color:#2c3e50;
        line-height:1.2;
    }

    .section-title{
        background:#1f4e78;
        color:#fff;
        padding:6px;
        text-align:center;
        font-size:11px;
        font-weight:bold;
        margin:8px 0;
    }

    table {
    width: 100%;
    border-collapse: collapse;
    page-break-inside: auto;
}

thead {
    display: table-header-group;
}

tfoot {
    display: table-footer-group;
}

tr {
    page-break-inside: avoid !important;
    page-break-after: auto;
}

td, th {
    page-break-inside: avoid !important;
}

    th{
        background:#1f4e78;
        color:#fff;
        border:1px solid #ccc;
        padding:5px;
        font-size:8px;
    }

    td{
        border:1px solid #ccc;
        padding:5px;
        font-size:8px;
        vertical-align:top;
    }

    .signature-line{
        margin-top:30px;
        border-top:1px solid #000;
        width:80%;
        margin-left:auto;
        margin-right:auto;
    }

    .text-center{
        text-align:center;
    }

    .bg-light{
        background:#f5f5f5;
    }

</style>

{{-- ========================================================= --}}
{{-- USER INFORMATION --}}
{{-- ========================================================= --}}

@if($assignments->count())

@php
$user = optional($assignments->first()->users->first())->user;
@endphp

<div class="section-title">
    Employee Information
</div>

<table>

    <tr>

        <td width="20%">
            Employee Name
        </td>

        <td>
            {{ $user->name ?? '-' }}
        </td>

    </tr>

    <tr>

        <td>
            Email
        </td>

        <td>
            {{ $user->email ?? '-' }}
        </td>

    </tr>

</table>

@endif

{{-- ========================================================= --}}
{{-- GOAL STATEMENTS --}}
{{-- ========================================================= --}}

<div class="section-title">
    Goal Statements
</div>

@forelse($assignments as $assignment)

<table>

    <tr class="bg-light">

        <td colspan="2">

            <strong>

                {{ $assignment->goal->goal_cod }}

                -

                {{ $assignment->goal->goal_name }}

            </strong>

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

            {{ $assignment->goal->driver->driver_name ?? '-' }}

        </td>

    </tr>

    <tr>

        <td>
            KPA
        </td>

        <td>

            {{ $assignment->kpa->performance_area ?? '-' }}

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

@empty

<table>

    <tr>

        <td class="text-center">

            No Goal Assigned.

        </td>

    </tr>

</table>

@endforelse


{{-- ========================================================= --}}
{{-- GOAL & OBJECTIVE MAPPING --}}
{{-- ========================================================= --}}

<div class="section-title">

    Goal & Strategic Objective Mapping

</div>

<table>

    <thead>

    <tr>

        <th width="10%">
            Goal
        </th>

        <th width="15%">
            Role
        </th>

        <th width="15%">
            KPA
        </th>

        <th width="30%">
            Goal Statement
        </th>

        <th width="30%">
            Strategic Objective
        </th>

    </tr>

    </thead>

    <tbody>

    @forelse($assignments as $assignment)

        @foreach($assignment->groupedObjectives as $objectiveId => $details)

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

                    {{ $assignment->kpa->performance_area ?? '-' }}

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

    @empty

        <tr>

            <td colspan="5" class="text-center">

                No Record Found

            </td>

        </tr>

    @endforelse

    </tbody>

</table>
{{-- ========================================================= --}}
{{-- KPI MAPPING --}}
{{-- ========================================================= --}}

@foreach($assignments as $assignment)

<div class="section-title" style="page-break-before: always;">

    {{ $assignment->goal->goal_cod }}
    -
    {{ $assignment->goal->goal_name }}

</div>

<table>

    <thead>

    <tr>

        <th width="18%">
            Strategic Objective
        </th>

        <th width="16%">
            Dimension
        </th>

        <th width="22%">
            KPI / Indicator
        </th>

        <th width="8%">
            Target
        </th>

        <th width="8%">
            Achieved
        </th>

        <th width="8%">
            Remaining
        </th>

        <th width="8%">
            Weight
        </th>

        <th width="6%">
            Period
        </th>

        <th width="12%">
            Contributor
        </th>

    </tr>

    </thead>

    <tbody>

    @foreach($assignment->groupedObjectives as $objectiveId => $details)

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

                $achieved = optional($detail->userDetails->first())->target_achieved ?? 0;

                $remaining = max(
                    0,
                    (float)$detail->dimension_target - (float)$achieved
                );

            @endphp

            @forelse($detail->indicators as $assignmentIndicator)

            <tr>

                {{-- Objective --}}
                @if($firstObjective)

                <td rowspan="{{ $objectiveRowspan }}">

                    <strong>

                        {{ $objective->objective_cod }}

                    </strong>

                    <br>

                    {{ $objective->title }}

                </td>

                @endif

                {{-- Dimension --}}
                @if($firstDimension)

                <td rowspan="{{ $dimensionRowspan }}">

                    <strong>

                        {{ $detail->dimension->dimension_cod }}

                    </strong>

                    <br>

                    {{ $detail->dimension->name }}

                </td>

                @endif

                {{-- Indicator --}}
                <td>

                    {{ $assignmentIndicator->indicator->indicator }}

                </td>

                {{-- Target --}}
                <td class="text-center">

                    {{ $detail->dimension_target }}

                </td>

                {{-- Achieved --}}
                <td class="text-center">

                    {{ optional($detail->userDetails->first())->target_achieved ?? '-' }}

                </td>

                {{-- Remaining --}}
                <td class="text-center">

                    {{ $remaining }}

                </td>

                {{-- Weight --}}
                <td class="text-center">

                    {{ $detail->dimension_weight }}

                </td>

                {{-- Period --}}
                <td class="text-center">

                    Annual

                </td>

                {{-- Contributor --}}
                <td>

                    {{ optional($assignment->users->first()->user)->name ?? '-' }}

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

                    <strong>

                        {{ $objective->objective_cod }}

                    </strong>

                    <br>

                    {{ $objective->title }}

                </td>

                @endif

                @if($firstDimension)

                <td>

                    <strong>

                        {{ $detail->dimension->dimension_cod }}

                    </strong>

                    <br>

                    {{ $detail->dimension->name }}

                </td>

                @endif

                <td colspan="7" class="text-center">

                    No Indicator Assigned

                </td>

            </tr>

            @php

                $firstObjective = false;

                $firstDimension = false;

            @endphp

            @endforelse

        @endforeach

    @endforeach

    </tbody>

</table>

@endforeach
{{-- ========================================================= --}}
{{-- APPROVAL & ENDORSEMENT --}}
{{-- ========================================================= --}}

<div class="section-title">
    Approval & Endorsement
</div>

@php
    $employee = optional(optional($assignments->first())->users->first())->user;
@endphp

<table>

    <thead>

        <tr>

            <th width="34%">
                Employee
            </th>

            <th width="33%">
                Immediate Supervisor
            </th>

            <th width="33%">
                Head of Department
            </th>

        </tr>

    </thead>

    <tbody>

        <tr>

            <td style="height:90px;vertical-align:bottom;text-align:center;">

                <div class="signature-line"></div>

                <strong>

                    {{ $employee->name ?? '' }}

                </strong>

                <br>

                Employee Signature

            </td>

            <td style="vertical-align:bottom;text-align:center;">

                <div class="signature-line"></div>

                Signature

            </td>

            <td style="vertical-align:bottom;text-align:center;">

                <div class="signature-line"></div>

                Signature

            </td>

        </tr>

    </tbody>

</table>

<table>

    <tr>

        <td width="33%">

            <strong>Date :</strong>

            {{ now()->format('d M Y') }}

        </td>

        <td width="34%" class="text-center">

            <strong>Role :</strong>

            {{ optional(optional($assignments->first())->role)->name }}

        </td>

        <td width="33%" style="text-align:right;">

            <strong>Total Goals :</strong>

            {{ $assignments->count() }}

        </td>

    </tr>

</table>

<div style="margin-top:25px;text-align:center;font-size:8px;color:#666;">

    This report is system generated from the Performance Management System.

    <br>

    Generated on {{ now()->format('d M Y h:i A') }}

</div>

@endsection