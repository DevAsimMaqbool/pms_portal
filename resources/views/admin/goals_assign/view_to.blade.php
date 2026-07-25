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

                        <li>


                        <!-- GOAL -->
                        <div class="d-flex align-items-center goal tree-node bg-label-warning"
                        onclick="toggleBox('goal{{$assign->id}}')">


                        <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                        <i class="icon-base ti tabler-circle-letter-g icon-md"></i>
                        </div>


                        <div class="d-flex justify-content-between w-100">


                        <div>

                        <h6 class="mb-0">

                        {{ $assign->goal?->goal_name }}

                        </h6>


                        <small>

                        Role:
                        {{ $assign->role?->name }}

                        |

                        Code:
                        {{ $assign->goal?->goal_cod }}

                        |

                        Driver:
                        {{ $assign->goal?->driver?->driver_name }}

                        </small>


                        </div>

                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning text-dark">
                            Goal
                            </span>
                        </div>


                        </div>


                        </div>



                        <div id="goal{{$assign->id}}" class="collapse-box show">


                        <ul>
                         <li>

                                <div class="d-flex align-items-center tree-node bg-label-success"
                                    onclick="toggleBox('users{{ $assign->id }}')">

                                    <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                        <i class="icon-base ti tabler-users icon-md"></i>
                                    </div>

                                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">

                                        <div class="me-2">
                                            <h6 class="mb-0">
                                                Assigned Users
                                            </h6>

                                            <small class="text-body">
                                                Total Users:
                                                {{ $assign->users->count() }}
                                            </small>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success">
                                                Users
                                            </span>
                                        </div>

                                    </div>

                                </div>

                                <div id="users{{ $assign->id }}" class="collapse-box show">

                                    <ul>

                                        @forelse($assign->users as $assignmentUser)

                                            <li>

                                                <div class="d-flex align-items-center tree-node bg-label-secondary">

                                                    <div class="badge bg-label-primary text-body p-2 me-4 rounded">
                                                        <i class="icon-base ti tabler-user icon-md"></i>
                                                    </div>

                                                    <div class="w-100">

                                                        <h6 class="mb-0">
                                                            {{ $assignmentUser->user?->name }}
                                                        </h6>

                                                        <small class="text-body">
                                                            {{ $assignmentUser->user?->email }}
                                                        </small>

                                                    </div>
                                                    <a class="badge bg-success" href="{{ route('goals-assign.create.custom', $assign->id) }}">
                                                        Ckick to assign
                                                    </a>

                                                </div>

                                            </li>

                                        @empty

                                            <li>
                                                <div class="alert alert-warning mb-0">
                                                    No users assigned.
                                                </div>
                                            </li>

                                        @endforelse

                                    </ul>

                                </div>

                            </li>

                        @foreach($assign->details->groupBy('objective_id') as $objectiveId => $details)

                            @php
                                $objective = $details->first()->objective;
                            @endphp

                            <li>

                                <!-- OBJECTIVE -->
                                <div class="d-flex align-items-center objective tree-node bg-label-info"
                                    onclick="toggleBox('objective{{ $assign->id }}{{ $objectiveId }}')">

                                    <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                        <i class="icon-base ti tabler-circle-letter-o icon-md"></i>
                                    </div>

                                    <div class="w-100">
                                        <h6 class="mb-0">
                                            {{ $objective?->title }}
                                        </h6>

                                        <small>
                                            Code:
                                            {{ $objective?->objective_cod }}
                                        </small>
                                    </div>

                                    <span class="badge bg-info">
                                        Objective
                                    </span>

                                </div>

                                <div id="objective{{ $assign->id }}{{ $objectiveId }}"
                                    class="collapse-box show">

                                    <ul>

                                        @foreach($details as $detail)

                                            @foreach($detail->indicators as $assignmentIndicator)

                                                <li>

                                                    <div class="d-flex align-items-center kpi tree-node bg-label-danger">

                                                        <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                                            <i class="icon-base ti tabler-circle-letter-d icon-md"></i>
                                                        </div>

                                                        <div class="w-100">

                                                            <h6 class="mb-0">
                                                                {{ $assignmentIndicator->indicator?->indicator }}
                                                            </h6>

                                                            <small>
                                                                Dimension:
                                                                {{ $detail->dimension?->name }}

                                                                |

                                                                Target:
                                                                {{ $detail->dimension_target }}

                                                                |

                                                                Weight:
                                                                {{ $detail->dimension_weight }}
                                                            </small>

                                                        </div>

                                                        <span class="badge bg-danger">
                                                            KPI
                                                        </span>

                                                    </div>

                                                </li>

                                            @endforeach

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
