@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
      <style>
        .avatar-xl{ width:72px; height:72px; border-radius:50%; object-fit:cover; }
        .metric{ font-size:.9rem; color:#6c757d; }
        .mini-tile{ border:1px solid var(--bs-border-color); border-radius:.75rem; padding:1rem; background:#fff; height:100%; }
        .mini-tile .label{ color:#6e6b7b; font-size:.8rem; }
        .mini-tile .value{ font-weight:700; font-size:1.1rem; }
        .spark-holder{ height:120px; }
        .kpa-card h6{ margin-bottom:.25rem; }
        .indicator-row{ display:flex; align-items:center; justify-content:space-between; padding:.5rem 0; border-bottom:1px dashed var(--bs-border-color); }
        .indicator-row:last-child{ border-bottom:none; }
        .status-badge{ padding:.35rem .5rem; }
        .filter-row .form-select{ min-width:220px; }
    </style>
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
  <!-- Content -->
     <div class="container-xxl flex-grow-1 container-p-y">

                    <!-- ===================== Tabs: Summary / Detailed ===================== -->
                    <ul class="nav nav-pills flex-wrap gap-2 mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-summary" role="tab">Summary View</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-detailed" role="tab">Detailed View</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- =============================== SUMMARY VIEW =============================== -->
                        <div class="tab-pane fade show active" id="tab-summary" role="tabpanel">

                            <!-- Header: Profile + HR Tiles + Overall Tracker -->
                            <div class="row g-4 align-items-stretch mb-4">
                                <!-- Profile -->
                                <div class="col-12 col-xl-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <img class="avatar-xl me-3" src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="avatar"/>
                                                <div>
                                                    <h4 class="mb-1" id="empName">Dr. Ali Raza</h4>
                                                    <div class="text-muted">Professor – Computer Science</div>
                                                    <div class="metric">Department: Information Technology</div>
                                                    <div class="metric">DOJ: <span id="doj">2015-09-01</span></div>
                                                    <div class="fw-semibold text-primary" id="serviceYears">—</div>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-6"><div class="mini-tile text-center"><div class="label">Grade</div><div class="value">B+</div></div></div>
                                                <div class="col-6"><div class="mini-tile text-center"><div class="label">Appraisal</div><div class="value">Exceeds</div></div></div>
                                                <div class="col-6"><div class="mini-tile text-center"><div class="label">Courses (AY)</div><div class="value">10</div></div></div>
                                                <div class="col-6"><div class="mini-tile text-center"><div class="label">Papers</div><div class="value">5</div></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- HR Stats -->
                                <div class="col-12 col-xl-4">
                                    <div class="row g-3 h-100">
                                        <div class="col-6">
                                            <div class="mini-tile">
                                                <div class="d-flex justify-content-between"><span class="label">Years of Service</span><i class="ti ti-user-check"></i></div>
                                                <div class="value mt-2" id="yosVal">—</div>
                                                <div class="text-muted small">Auto from DOJ</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mini-tile">
                                                <div class="d-flex justify-content-between"><span class="label">Attendance %</span><i class="ti ti-calendar"></i></div>
                                                <div class="value mt-2">96%</div>
                                                <div class="text-muted small">Last semester</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mini-tile">
                                                <div class="d-flex justify-content-between"><span class="label">Awards</span><i class="ti ti-award"></i></div>
                                                <div class="mt-2"><span class="badge bg-label-primary me-1">Best Teacher</span><span class="badge bg-label-success me-1">Research Grant</span><span class="badge bg-label-info">Mentor</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Overall Performance Tracker (Support Tracker style) -->
                                <div class="col-12 col-xl-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0">Overall Performance</h5>
                                                <span class="text-muted small">Weighted</span>
                                            </div>
                                            <div id="overallRadial"></div>
                                            <div class="row text-center mt-3 g-0">
                                                <div class="col"><small class="text-muted">Target</small><div class="fw-bold">80%</div></div>
                                                <div class="col"><small class="text-muted">Current</small><div class="fw-bold" id="overallNow">—</div></div>
                                                <div class="col"><small class="text-muted">Δ vs last</small><div class="fw-bold text-success">+3%</div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- KPA Cards (mini radials) -->
                            <div class="row g-3 mb-4" id="kpaCardsRow"><!-- JS fills --></div>

                            <!-- Trend Chart (Earning Reports style) -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Performance Trend</h5>
                                        <span class="text-muted small">Semesters</span>
                                    </div>
                                    <div id="trendArea"></div>
                                </div>
                            </div>

                            <!-- Indicator Snapshot (like Sales by Countries list) -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Indicator Snapshot</h5>
                                    <div id="indicatorSnapshot"><!-- JS fills --></div>
                                </div>
                            </div>

                        </div>

                        <!-- =============================== DETAILED VIEW =============================== -->
                        <div class="tab-pane fade" id="tab-detailed" role="tabpanel">

                            <!-- Filters -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row g-3 filter-row">
                                        <div class="col-sm-6 col-md-4">
                                            <label class="form-label">Filter by KPA</label>
                                            <select id="filterKPA" class="form-select">
                                                <option value="all" selected>All KPAs</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <label class="form-label">Filter by Category</label>
                                            <select id="filterCategory" class="form-select" disabled>
                                                <option value="all" selected>All Categories</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Accordion: KPA → Categories → Indicators -->
                            <div class="accordion mb-4" id="kpaAccordion"><!-- JS fills --></div>

                            <!-- Detailed Table (Project list style) -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">All Indicators (Detailed)</h5>
                                        <span class="text-muted small">Prototype data</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Indicator</th>
                                                <th>Category</th>
                                                <th>KPA</th>
                                                <th>Weight</th>
                                                <th>Score</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody id="detailedTableBody"><!-- JS fills --></tbody>
                                        </table>
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
  <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}
    "></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}
      "></script>
  <!-- <script src="{{ asset('admin/assets/js/cards-statistics.js') }}"></script> -->
  <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>
  
<script>
    // =========================== Data from your Excel (2-3 indicators per category) ===========================
    // NOTE: Scores and weights are dummy placeholders; replace from ERP later.
    const KPAS = [
        {"name":"Teaching and Learning","weight":0.45,"score":86,"categories":[
                {"name":"Teaching Delivery  (PG/UG)","indicators":[
                        {"name":"Student Teaching Satisfaction (feedback)","weight":0.25,"score":88,"status":"Achieved"},
                        {"name":"QEC - Observation / Peer review","weight":0.10,"score":79,"status":"Improving"}
                    ]},
                {"name":"Teaching Management","indicators":[
                        {"name":"Classes Held in Time/Commencement of Classes","weight":0.15,"score":74,"status":"Improving"},
                        {"name":"Student Attendance (class/lab)","weight":0.10,"score":92,"status":"Achieved"},
                        {"name":"Student Punctuality","weight":0.10,"score":84,"status":"Achieved"}
                    ]},
                {"name":"Teaching Innovation","indicators":[
                        {"name":"Adoption of active learning techniques (flipped classroom...)","weight":0.15,"score":81,"status":"Improving"}
                    ]},
                {"name":"Teaching Output","indicators":[
                        {"name":"Student Pass Percentage","weight":0.20,"score":86,"status":"Achieved"},
                        {"name":"Improvement in student performance metrics (grades, assessments)","weight":0.10,"score":78,"status":"Improving"}
                    ]},
                {"name":"Teaching Outcomes - Student","indicators":[
                        {"name":"Testimonials/Qualitative Feedback from Students","weight":0.10,"score":82,"status":"Achieved"},
                        {"name":"Guidance of students on projects resulting in impact","weight":0.10,"score":76,"status":"Pending"}
                    ]}
            ]},
        {"name":"Research, Innovation and Commercialisation","weight":0.25,"score":69,"categories":[
                {"name":"Research Productivity & Quality","indicators":[
                        {"name":"# of Research Publications (Scopus Indexed)","weight":0.20,"score":63,"status":"Pending"}
                    ]},
                {"name":"Other Knowledge Products","indicators":[
                        {"name":"Policy Briefs / White Papers / Case Studies (count)","weight":0.10,"score":71,"status":"Improving"}
                    ]},
                {"name":"Research Supervision at PG Level","indicators":[
                        {"name":"MS/PhD Supervision (active)","weight":0.10,"score":72,"status":"Improving"}
                    ]}
            ]},
        {"name":"Institutional Engagement \n(Core only)","weight":0.15,"score":75,"categories":[
                {"name":"Performance in deparmental tasks - day to day, Participation in departmental","indicators":[
                        {"name":"Departmental Task Completion","weight":0.10,"score":90,"status":"Achieved"}
                    ]},
                {"name":"Performance in events (if any)","indicators":[
                        {"name":"Event Participation/Coordination","weight":0.10,"score":66,"status":"Improving"}
                    ]}
            ]},
        {"name":"Institutional Engagement (Operational+ Character Strengths)","weight":0.15,"score":92,"categories":[
                {"name":"assigned operational roles in the department/faculty (if any)","indicators":[
                        {"name":"Operational Role Effectiveness","weight":0.10,"score":94,"status":"Achieved"}
                    ]},
                {"name":"Performance in deparmental tasks - day to day, Participation in departmental/institutional governing bodies etc","indicators":[
                        {"name":"Governing Body Participation","weight":0.05,"score":88,"status":"Achieved"}
                    ]},
                {"name":"Performance in events/tasks (other than the assigned operational role) (core)","indicators":[
                        {"name":"Additional Institutional Tasks","weight":0.05,"score":86,"status":"Achieved"}
                    ]}
            ]}
    ];

    // Trend (dummy)
    const trendSemesters = ['Fall 22','Spring 23','Fall 23','Spring 24','Fall 24','Spring 25'];
    const trendScores = [68, 72, 75, 79, 81, 84];

    // ============================== Helpers ==============================
    function statusBadge(status){
        const map = { 'Achieved':'bg-success', 'Improving':'bg-warning', 'Pending':'bg-danger' };
        return `<span class="badge ${map[status]||'bg-secondary'} status-badge">${status}</span>`;
    }

    // Service years from DOJ
    (function calcService(){
        const dojEl = document.getElementById('doj');
        const outEl = document.getElementById('serviceYears');
        const yosEl = document.getElementById('yosVal');
        const doj = new Date(dojEl.textContent.trim());
        const now = new Date();
        let years = now.getFullYear() - doj.getFullYear();
        const m = now.getMonth() - doj.getMonth();
        if (m < 0 || (m === 0 && now.getDate() < doj.getDate())) years--;
        const monthsTotal = (now.getFullYear() - doj.getFullYear())*12 + (now.getMonth() - doj.getMonth());
        const rem = ((monthsTotal % 12) + 12) % 12;
        const text = `${years} yrs ${rem} mos of service`;
        outEl.textContent = text; yosEl.textContent = `${years}+`;
    })();

    // Overall value
    const overallVal = Math.round(KPAS.reduce((acc,k)=>acc + (k.score * k.weight), 0));
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('overallNow').textContent = overallVal + '%';
    });

    // ============================== SUMMARY: Apex Charts ==============================
    // Overall radial (Support Tracker style)
    new ApexCharts(document.querySelector('#overallRadial'), {
        chart: { type:'radialBar', height: 290 },
        series: [overallVal],
        labels: ['Overall'],
        colors: ['#28c76f'],
        plotOptions: { radialBar: { hollow: { size:'68%' }, dataLabels: { name:{ offsetY: 18 }, value: { fontSize:'24px' } } } }
    }).render();

    // KPA cards (mini radials)
    (function renderKpaCards(){
        const row = document.getElementById('kpaCardsRow');
        KPAS.forEach((k, idx) => {
            const color = ['#28c76f','#ff9f43','#00cfe8','#7367f0'][idx % 4];
            const col = document.createElement('div'); col.className = 'col-12 col-sm-6 col-xl-3';
            col.innerHTML = `
          <div class="card kpa-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <h6 class="mb-0">${k.name}</h6>
                <span class="badge bg-label-secondary">W ${(k.weight*100).toFixed(0)}%</span>
              </div>
              <div id="kpaSpark_${idx}" class="spark-holder"></div>
              <div class="d-flex justify-content-between mt-1 small text-muted">
                <span>Score</span><span class="fw-bold">${k.score}%</span>
              </div>
            </div>
          </div>`;
            row.appendChild(col);
            new ApexCharts(document.querySelector(`#kpaSpark_${idx}`), {
                chart:{ type:'radialBar', height:120, sparkline:{enabled:true} },
                series:[k.score], colors:[color],
                plotOptions:{ radialBar:{ hollow:{size:'58%'}, dataLabels:{ show:true, value:{ fontSize:'18px' } } } }
            }).render();
        });
    })();

    // Trend area (Earning Reports style)
    new ApexCharts(document.querySelector('#trendArea'), {
        chart: { type:'area', height: 290, toolbar: {show:false} },
        series: [{ name:'Overall %', data: trendScores }],
        xaxis: { categories: trendSemesters },
        dataLabels: { enabled:false },
        stroke: { curve:'smooth', width:3 },
        colors: ['#7367f0'],
        fill: { type:'gradient', gradient:{ shadeIntensity:.5, opacityFrom:.4, opacityTo:.05 } }
    }).render();

    // Indicator Snapshot (top ~8 indicators across KPAs)
    (function renderIndicatorSnapshot(){
        const host = document.getElementById('indicatorSnapshot');
        const rows = [];
        KPAS.forEach(k => k.categories.forEach(c => c.indicators.slice(0,2).forEach(ind => {
            rows.push({ kpa:k.name, category:c.name, name:ind.name, score:ind.score, status:ind.status });
        })));
        rows.slice(0,8).forEach(r => {
            host.innerHTML += `
          <div class="indicator-row">
            <div>
              <div class="fw-semibold">${r.name}</div>
              <div class="text-muted small">${r.category} — <span class="text-primary">${r.kpa}</span></div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="fw-bold">${r.score}%</div>
              ${statusBadge(r.status)}
            </div>
          </div>`;
        });
    })();

    // ============================== DETAILED: Filters + Accordion + Table ==============================
    const kpaSelect = document.getElementById('filterKPA');
    const catSelect = document.getElementById('filterCategory');

    // Populate KPA filter
    KPAS.forEach((k, i) => { const o = document.createElement('option'); o.value = 'k'+i; o.textContent = k.name; kpaSelect.appendChild(o); });

    function populateCategories(){
        catSelect.innerHTML = '<option value="all" selected>All Categories</option>';
        const val = kpaSelect.value;
        if (val==='all'){ catSelect.disabled = true; return; }
        catSelect.disabled = false;
        const idx = parseInt(val.slice(1),10);
        KPAS[idx].categories.forEach((c,j)=>{ const o=document.createElement('option'); o.value='c'+j; o.textContent=c.name; catSelect.appendChild(o); });
    }

    kpaSelect.addEventListener('change', ()=>{ populateCategories(); applyFilters(); });
    catSelect.addEventListener('change', applyFilters);

    function buildAccordion(){
        const acc = document.getElementById('kpaAccordion'); acc.innerHTML = '';
        KPAS.forEach((k, i) => {
            const item = document.createElement('div'); item.className = 'accordion-item';
            const hid = `kpaHead_${i}`; const cid = `kpaCollapse_${i}`;
            item.innerHTML = `
          <h2 class="accordion-header" id="${hid}">
            <button class="accordion-button ${i>0?'collapsed':''}" type="button" data-bs-toggle="collapse" data-bs-target="#${cid}" aria-expanded="${i===0?'true':'false'}" aria-controls="${cid}">
              ${k.name} — <span class="ms-2 text-success">${k.score}%</span>
            </button>
          </h2>
          <div id="${cid}" class="accordion-collapse collapse ${i===0?'show':''}" aria-labelledby="${hid}" data-bs-parent="#kpaAccordion">
            <div class="accordion-body">
              ${k.categories.map((cat, j) => `
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <h6 class="mb-0">${cat.name}</h6>
                      <span class="badge bg-label-secondary">Category</span>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                          <tr>
                            <th style="min-width:260px;">Indicator</th>
                            <th>Weight</th>
                            <th>Score</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          ${cat.indicators.map(ind => `
                            <tr data-kpa="k${i}" data-cat="c${j}">
                              <td>${ind.name}</td>
                              <td>${ind.weight.toFixed(2)}</td>
                              <td>${ind.score}%</td>
                              <td>${statusBadge(ind.status)}</td>
                            </tr>
                          `).join('')}
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              `).join('')}
            </div>
          </div>`;
            acc.appendChild(item);
        });
    }

    function buildDetailedTable(){
        const tbody = document.getElementById('detailedTableBody'); tbody.innerHTML = '';
        KPAS.forEach((k, i) => k.categories.forEach((c, j) => c.indicators.forEach(ind => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-kpa', 'k'+i); tr.setAttribute('data-cat','c'+j);
            tr.innerHTML = `<td>${ind.name}</td><td>${c.name}</td><td>${k.name}</td><td>${ind.weight.toFixed(2)}</td><td>${ind.score}%</td><td>${statusBadge(ind.status)}</td>`;
            tbody.appendChild(tr);
        })));
    }

    function applyFilters(){
        const kVal = kpaSelect.value; const cVal = catSelect.value;
        document.querySelectorAll('#kpaAccordion tbody tr, #detailedTableBody tr').forEach(tr => {
            const mk = (kVal==='all') || (tr.dataset.kpa===kVal);
            const mc = (cVal==='all') || (tr.dataset.cat===cVal);
            tr.style.display = (mk && mc) ? '' : 'none';
        });
        // Also hide accordion items with no visible rows
        document.querySelectorAll('#kpaAccordion .accordion-item').forEach(item => {
            const anyVisible = Array.from(item.querySelectorAll('tbody tr')).some(r => r.style.display !== 'none');
            item.style.display = anyVisible ? '' : 'none';
        });
    }

    // Build on load
    buildAccordion();
    buildDetailedTable();

</script>
@endpush