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
            line-height: 1.15;
            color: #2c3e50;
        }

        .section-title {
            background: #1f4e78;
            color: #fff;
            padding: 4px;
            font-size: 11px;
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f4e78;
            color: #fff;
            padding: 3px;
            font-size: 8px;
            border: 1px solid #d0d7de;
        }

        td {
            border: 1px solid #d0d7de;
            padding: 3px;
            font-size: 8px;
            vertical-align: top;
        }

        .signature-line {
            margin: 25px auto 3px;
            width: 60%;
            border-top: 1px solid #000;
        }
    </style>

    {{-- ===================== --}}
    {{-- PAGE 1: GOAL STATEMENTS --}}
    {{-- ===================== --}}

    <div class="section-title">Goal Statements</div>

    <table>

        @foreach($goals as $goal)

            <tr style="background:#f6f8fa;font-weight:bold;">
                <td colspan="2">
                    {{ $goal->goal_cod }} - {{ $goal->goal_name }}
                </td>
            </tr>

            <tr>
                <td>S2R Driver</td>
                <td>{{ $goal->driver->driver_name ?? '' }}</td>
            </tr>

            <tr>
                <td>Statement</td>
                <td>{{ $goal->goal_statement }}</td>
            </tr>

        @endforeach

    </table>

    {{-- ===================== --}}
    {{-- PAGE 2 --}}
    {{-- ===================== --}}

    <div class="section-title">Goals & Strategic Objective Mapping</div>

    <table>

        <thead>
            <tr>
                <th>Goal Code</th>
                <th>KPA</th>
                <th>Goal Statement</th>
                <th>Objective</th>
            </tr>
        </thead>

        <tbody>

            @foreach($goals as $goal)
                @foreach($goal->objectives as $objective)

                    @php
                        $kpas = [];

                        foreach ($objective->dimensions as $dimension) {
                            foreach ($dimension->goalAssignments as $assignment) {
                                if ($assignment->kpa) {
                                    $kpas[] = $assignment->kpa->performance_area
                                        ?? $assignment->kpa->title
                                        ?? '';
                                }
                            }
                        }
                    @endphp

                    <tr>
                        <td>{{ $goal->goal_cod }}</td>
                        <td>{{ implode(', ', array_unique(array_filter($kpas))) }}</td>
                        <td>{{ $goal->goal_statement }}</td>
                        <td>
                            {{ $objective->objective_cod }} - {{ $objective->title }}
                        </td>
                    </tr>

                @endforeach
            @endforeach

        </tbody>

    </table>

    {{-- ===================== --}}
    {{-- PAGE 3 --}}
    {{-- ===================== --}}

    @foreach($goals as $goal)

        <div class="section-title">
            {{ $goal->goal_cod }} - {{ $goal->goal_name }}
        </div>

        <table>

            <thead>
                <tr>
                    <th>Objective</th>
                    <th>Dimension</th>
                    <th>KPI</th>
                    <th>Target</th>
                    <th>Weight</th>
                    <th>Period</th>
                    <th>Contributor</th>
                </tr>
            </thead>

            <tbody>

                @foreach($goal->objectives as $objective)

                    @php
                        $dimensionGroups = [];

                        foreach ($objective->dimensions as $dimension) {

                            $kpiRows = [];

                            foreach ($dimension->goalAssignments as $assignment) {
                                foreach ($assignment->kpi_ids ?? [] as $kpiId) {
                                    if (isset($kpis[$kpiId])) {
                                        $kpiRows[] = [
                                            'kpi' => $kpis[$kpiId],
                                            'target' => $assignment->dimension_target ?? '',
                                            'weight' => $assignment->dimension_weight ?? '',
                                            'role' => $assignment->role->name ?? ''
                                        ];
                                    }
                                }
                            }

                            $dimensionGroups[] = [
                                'dimension' => $dimension,
                                'rows' => $kpiRows
                            ];
                        }

                        $objectiveRowspan = 0;
                        foreach ($dimensionGroups as $group) {
                            $objectiveRowspan += max(count($group['rows']), 1);
                        }

                        $firstObjectiveRow = true;
                    @endphp

                    @foreach($dimensionGroups as $group)

                        @php
                            $dimensionRowspan = max(count($group['rows']), 1);
                            $firstDimensionRow = true;
                        @endphp

                        @forelse($group['rows'] as $row)

                            <tr>

                                {{-- OBJECTIVE (ONCE) --}}
                                @if($firstObjectiveRow)
                                    <td rowspan="{{ $objectiveRowspan }}">
                                        {{ $objective->objective_cod }} - {{ $objective->title }}
                                    </td>
                                @endif

                                {{-- DIMENSION (ONCE) --}}
                                @if($firstDimensionRow)
                                    <td rowspan="{{ $dimensionRowspan }}">
                                        {{ $group['dimension']->dimension_cod }} - {{ $group['dimension']->name }}
                                    </td>
                                @endif

                                {{-- KPI ROW --}}
                                <td>{{ $row['kpi'] }}</td>
                                <td>{{ $row['target'] }}</td>
                                <td>{{ $row['weight'] }}</td>
                                <td>Annual</td>
                                <td>{{ $row['role'] }}</td>

                            </tr>

                            @php
                                $firstObjectiveRow = false;
                                $firstDimensionRow = false;
                            @endphp

                        @empty

                            <tr>

                                @if($firstObjectiveRow)
                                    <td rowspan="{{ $objectiveRowspan }}">
                                        {{ $objective->objective_cod }} - {{ $objective->title }}
                                    </td>
                                @endif

                                <td>{{ $group['dimension']->dimension_cod }} - {{ $group['dimension']->name }}</td>
                                <td colspan="5">No KPI Assigned</td>

                            </tr>

                            @php $firstObjectiveRow = false; @endphp

                        @endforelse

                    @endforeach

                @endforeach

            </tbody>

        </table>

    @endforeach

    {{-- ===================== --}}
    {{-- FINAL SECTION (RESTORED) --}}
    {{-- ===================== --}}

    <div class="section-title">Approval & Endorsement</div>

    <table>

        <tr>
            <td>Chairman Board of Governors</td>
            <td>Rector</td>
            <td>Date of Approval</td>
        </tr>

        <tr>
            <td>
                <div class="signature-line"></div>
                Signature & Name
            </td>

            <td>
                <div class="signature-line"></div>
                Signature & Name
            </td>

            <td>
                <div class="signature-line"></div>
                Signature & Date
            </td>
        </tr>

    </table>

@endsection