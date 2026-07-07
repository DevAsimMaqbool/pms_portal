@extends('layouts.app')

@push('style')

<style>

/* ================= TREE BASE ================= */
.tree ul {
    padding-left: 25px;
    margin-left: 10px;
    border-left: 2px dashed #dee2e6;
}

.tree li {
    list-style: none;
    margin: 10px 0;
}

/* ================= CARD NODE ================= */
.tree-node {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 10px 14px;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    cursor: pointer;
    transition: 0.2s ease-in-out;
    font-size: 14px;
}

/* hover effect */
.tree-node:hover {
    transform: translateY(-2px);
    border-color: #0d6efd;
    box-shadow: 0 6px 14px rgba(13,110,253,0.15);
}

/* ================= LEVEL COLORS ================= */
.root {
    border-left: 5px solid #0d6efd;
}

.goal {
    border-left: 5px solid #ffc107;
}

.objective {
    border-left: 5px solid #0dcaf0;
}

.kpi {
    border-left: 5px solid #dc3545;
}

/* ================= COLLAPSE ================= */
.collapse-box {
    display: none;
}

.collapse-box.show {
    display: block;
}

/* ================= BADGE ================= */
.badge {
    font-size: 10px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .tree ul {
        padding-left: 15px;
    }

    .tree-node {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        font-size: 12px;
    }
}

</style>

@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

{{-- <div class="card shadow-sm border-0">

  <!-- HEADER -->
  <div class="card-header text-white">
    <h5 class="mb-0">
      <span class="iconify me-2" data-icon="tabler:hierarchy"></span>
      Scorecard Tree View
    </h5>
  </div>

  <div class="card-body tree">

    <ul>

      <!-- ROOT -->
      <li>

        <div class="d-flex align-items-center root tree-node bg-label-primary" onclick="toggleBox('g1')">
            <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
            <div class="me-2">
                <h6 class="mb-0">RECTOR SCORECARD</h6>
                <small class="text-body">RECTOR SCORECARD description</small>
            </div>
            <div class="d-flex align-items-center">
                <div class="badge bg-primary">Root</div>
            </div>
            </div>
        </div>

        <div id="g1" class="collapse-box show">

          <ul>

            <!-- GOAL -->
            <li>

              <div class="d-flex align-items-center goal tree-node bg-label-warning" onclick="toggleBox('obj1')">
                    <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">RECTOR SCORECARD</h6>
                        <small class="text-body">RECTOR SCORECARD description</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="badge bg-warning text-dark">Goal</div>
                    </div>
                    </div>
                </div>

              <div id="obj1" class="collapse-box show">

                <ul>

                  <!-- OBJECTIVE -->
                  <li>

                    <div class="d-flex align-items-center objective tree-node bg-label-info" onclick="toggleBox('kpi1')">
                        <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Objective 1.1</h6>
                            <small class="text-body">Objective 1.1 description</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="badge bg-info">Objective</div>
                        </div>
                        </div>
                    </div>

                    <div id="kpi1" class="collapse-box show">

                      <ul>

                        <li>
                         
                           <div class="d-flex align-items-center kpi tree-node bg-label-danger">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Graduate Employability Rate</h6>
                                    <small class="text-body">Graduate Employability Rate description</small>
                                </div>
                                </div>
                            </div>
                        </li>

                        <li>
                           <div class="d-flex align-items-center kpi tree-node bg-label-danger">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Graduate Employability Rate</h6>
                                    <small class="text-body">Graduate Employability Rate description</small>
                                </div>
                                </div>
                            </div>
                        </li>

                        <li>
                          <div class="d-flex align-items-center kpi tree-node bg-label-danger">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Graduate Employability Rate</h6>
                                    <small class="text-body">Graduate Employability Rate description</small>
                                </div>
                                </div>
                            </div>
                        </li>

                        <li>
                          <div class="d-flex align-items-center kpi tree-node bg-label-danger">
                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Graduate Employability Rate</h6>
                                    <small class="text-body">Graduate Employability Rate description</small>
                                </div>
                                </div>
                            </div>
                        </li>

                      </ul>

                    </div>

                  </li>

                </ul>

              </div>

            </li>

            <!-- GOAL 2 -->
            <li>

               <div class="d-flex align-items-center goal tree-node bg-label-warning">
                    <div class="badge bg-label-secondary text-body p-2 me-4 rounded"><i class="icon-base ti tabler-shadow icon-md"></i></div>
                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">G2: Research Excellence</h6>
                        <small class="text-body">G2: Research Excellence description</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="badge bg-warning text-dark">Goal</div>
                    </div>
                    </div>
                </div>

            </li>

          </ul>

        </div>

      </li>

    </ul>

  </div>

</div> --}}








<div class="card shadow-sm border-0">

    <!-- HEADER -->
    <div class="card-header text-white">
        <h5 class="mb-0">
            <span class="iconify me-2" data-icon="tabler:hierarchy"></span>
            Scorecard Tree View
        </h5>
    </div>

    <div class="card-body tree">

        <ul>

            <!-- ROOT -->
            <li>

                <div class="d-flex align-items-center root tree-node bg-label-primary"
                     onclick="toggleBox('g1')">

                    <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                        <i class="icon-base ti tabler-shadow icon-md"></i>
                    </div>

                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">

                        <div class="me-2">
                            <h6 class="mb-0">
                                Rector Goal-Base Performance Scorecard
                            </h6>

                            <small class="text-body">
                               Rating Scale *
                            </small>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="badge bg-primary">
                                Root
                            </div>
                        </div>

                    </div>

                </div>

                <div id="g1" class="collapse-box show">

                    <ul>

                        @foreach($assignments as $assign)

                        @php
                            $role = \App\Models\Role::find($assign['role_id']);

                            $goal = \App\Models\Goal::find($assign['goal_id']);

                            $kpa = \App\Models\KeyPerformanceArea::find($assign['kpa_id']);
                            $S2Rdriver = \App\Models\S2RDriver::find($goal['s2r_driver_id']);

                            $objectives = collect($assign['data'])
                                            ->groupBy('objective_id');
                        @endphp

                        <!-- GOAL -->
                        <li>

                            <div class="d-flex align-items-center goal tree-node bg-label-warning"
                                 onclick="toggleBox('goal{{ $assign['goal_id'] }}{{ $assign['role_id'] }}')">

                                <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                    <i class="icon-base ti tabler-shadow icon-md"></i>
                                </div>

                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">

                                    <div class="me-2">

                                        <h6 class="mb-0">
                                            {{ $goal?->goal_name }}
                                        </h6>

                                        <small class="text-body">
                                            Role:
                                            {{ $role?->name }} | Cod: {{ $goal?->goal_cod }} | S2Rdriver: {{ $S2Rdriver?->driver_name }}
                                        </small>

                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="badge bg-warning text-dark">
                                            Goal
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div id="goal{{ $assign['goal_id'] }}{{ $assign['role_id'] }}"
                                 class="collapse-box show">

                                <ul>

                                    @foreach($objectives as $objectiveId => $rows)

                                    @php
                                        $objective = \App\Models\Objective::find($objectiveId);
                                    @endphp

                                    <!-- OBJECTIVE -->
                                    <li>

                                        <div class="d-flex align-items-center objective tree-node bg-label-info"
                                             onclick="toggleBox('obj{{ $objectiveId }}')">

                                            <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                                <i class="icon-base ti tabler-shadow icon-md"></i>
                                            </div>

                                            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">

                                                <div class="me-2">

                                                    <h6 class="mb-0">
                                                        {{ $objective?->title }}
                                                    </h6>

                                                    <small class="text-body">
                                                        Objective Cod:
                                                        {{ $objective?->objective_cod }}
                                                    </small>

                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="badge bg-info">
                                                        Objective
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div id="obj{{ $objectiveId }}"
                                             class="collapse-box show">

                                            <ul>

                                                @foreach($rows as $row)
                                                @php
                                                    $dimension = \App\Models\Dimension::find($row->dimension_id);
                                                @endphp

                                                <li>

                                                    <div class="d-flex align-items-center kpi tree-node bg-label-danger">

                                                        <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                                            <i class="icon-base ti tabler-shadow icon-md"></i>
                                                        </div>

                                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">

                                                            <div class="me-2">

                                                                <h6 class="mb-0">
                                                                    {{ $dimension?->name }}
                                                                </h6>

                                                                <small class="text-body">

                                                                    Target:
                                                                    {{ $row->dimension_target }}

                                                                    |

                                                                    Weight:
                                                                    {{ $row->dimension_weight }}

                                                                </small>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </li>

                                                @endforeach

                                            </ul>

                                        </div>

                                    </li>

                                    @endforeach

                                </ul>

                            </div>

                        </li>

                        @endforeach

                    </ul>

                </div>

            </li>

        </ul>

    </div>

</div>








</div>

@endsection 
@push('script')


<script>
function toggleBox(id) {
    let el = document.getElementById(id);
    if (!el) return;

    el.classList.toggle('show');
}
</script>
@endpush
