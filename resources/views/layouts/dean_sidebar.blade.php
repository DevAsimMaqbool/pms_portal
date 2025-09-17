<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">

  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      <img style="width: 175px;" src="{{ asset('admin/assets/img/avatars/superior.svg') }}">
    </a>


    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
      <i class="icon-base ti tabler-x d-block d-xl-none"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboards -->

    <li class="menu-item {{ request()->routeIs('rector-dashboard.index') ? 'active' : '' }}">
      <a href="{{ route('rector-dashboard.index') }}" class="menu-link">
        <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
        <div data-i18n="Teacher">Teacher</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon icon-base ti tabler-smart-home"></i>
        <div data-i18n="Home">Home</div>
      </a>
    </li>
@if(auth()->user()->hasRole(['Dean']))
    @php
        $teacherRoleId = auth()->user()->roles->firstWhere('name', 'Dean')->id ?? null;

        $assignments = \App\Models\RoleKpaAssignment::with([
            'kpa',
            'category',
            'indicator.indicatorForm'
        ])
        ->where('role_id', $teacherRoleId)
        ->get();

        // Group by KPA → Category → Indicators
        $result = $assignments->groupBy('kpa.id')->map(function ($kpaGroup) {
            $kpa = $kpaGroup->first()->kpa;

            return [
                'id' => $kpa->id,
                'performance_area' => $kpa->performance_area,
                'created_by' => $kpa->created_by,
                'updated_by' => $kpa->updated_by,
                'created_at' => $kpa->created_at,
                'updated_at' => $kpa->updated_at,
                'category' => $kpaGroup->groupBy('category.id')->map(function ($catGroup) {
                    $category = $catGroup->first()->category;

                    return [
                        'id' => $category->id,
                        'key_performance_area_id' => $category->key_performance_area_id,
                        'indicator_category' => $category->indicator_category,
                        'created_by' => $category->created_by,
                        'updated_by' => $category->updated_by,
                        'created_at' => $category->created_at,
                        'updated_at' => $category->updated_at,
                        'indicator' => $catGroup->map(function ($item) {
                            $indicator = $item->indicator;

                            return [
                                'id' => $indicator->id,
                                'indicator_category_id' => $indicator->indicator_category_id,
                                'indicator' => $indicator->indicator,
                                'created_by' => $indicator->created_by,
                                'updated_by' => $indicator->updated_by,
                                'created_at' => $indicator->created_at,
                                'updated_at' => $indicator->updated_at,
                                'indicator_form' => $indicator->indicatorForm ?? [],
                            ];
                        })->values()
                    ];
                })->values()
            ];
        })->values();
    @endphp

    {{-- Render Menu --}}
    @foreach($result as $kpa)
        <li class="menu-item active">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon" style="
                  display: inline-flex;
                  align-items: center;
                  justify-content: center;
                  width: 24px;
                  height: 24px;
                  border-radius: 50%;
                  background: #eee;
                  font-weight: bold;
                  font-size: 14px;">
                    {{ $loop->iteration }}
                </span>
                <div data-i18n="{{ $kpa['performance_area'] }}">
                    {{ $kpa['performance_area'] }}
                </div>
            </a>

            {{-- Level 2: Indicator Categories --}}
            <ul class="menu-sub">
                @foreach($kpa['category'] as $category)
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <div data-i18n="{{ $category['indicator_category'] }}">
                                {{ $category['indicator_category'] }}
                            </div>
                        </a>

                        {{-- Level 3: Indicators --}}
                        @if(!empty($category['indicator']))
                            <ul class="menu-sub">
                                @foreach($category['indicator'] as $indicator)
                                    <li class="menu-item">
                                        <a href="{{ route('indicator.form', [
                                            'area' => $kpa['id'],
                                            'category' => $category['id'],
                                            'indicator' => $indicator['id']
                                        ]) }}" class="menu-link">
                                            <div data-i18n="{{ $indicator['indicator'] }}">
                                                {{ $indicator['indicator'] }}
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach

  @else
    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
      <a href="{{ route('users.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-users"></i>
      <div data-i18n="Users">Users</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('key-performance-area.index') ? 'active' : '' }}">
      <a href="{{ route('key-performance-area.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-star"></i>
      <div data-i18n="Key Performance Area">Key Performance Area</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('indicator-category.index') ? 'active' : '' }}">
      <a href="{{ route('indicator-category.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-users-group"></i>
      <div data-i18n="Indicator Category">Indicator Category</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('indicator.index') ? 'active' : '' }}">
      <a href="{{ route('indicator.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-heart"></i>
      <div data-i18n="Indicator">Indicator</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('teaching_learning') ? 'active' : '' }}">
      <a href="teaching_learning" class="menu-link">
      <i class="menu-icon icon-base ti tabler-settings"></i>
      <div data-i18n="Assign Indicators">Assign Indicators</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('user.kpa') ? 'active' : '' }}">
      <a href="{{ route('user.kpa') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-eye"></i>
      <div data-i18n="View Assigned Indicators">View Assigned Indicators</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">
      <a href="{{ route('departments.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-list-details"></i>
      <div data-i18n="View Departents">View Departents</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('user-role.index') ? 'active' : '' }}">
      <a href="{{ route('user-role.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-list-details"></i>
      <div data-i18n="Roles">Roles</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('role-permission.index') ? 'active' : '' }}">
      <a href="{{ route('role-permission.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-list-details"></i>
      <div data-i18n="Permission">Permission</div>
      </a>
    </li>
    <!-- <li class="menu-item {{ request()->routeIs('assigndepartment.index') ? 'active' : '' }}">
      <a href="{{ route('assigndepartment.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-heart"></i>
      <div data-i18n="Assign Department">Assign Department</div>
      </a>
    </li> -->
    <li class="menu-item {{ request()->routeIs('students.index') ? 'active' : '' }}">
      <a href="{{ route('students.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-heart"></i>
      <div data-i18n="Students">Students</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('assign-form.index') ? 'active' : '' }}">
      <a href="{{ route('assign-form.index') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-heart"></i>
      <div data-i18n="Assign Form To User">Assign Form To User</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('forms.assigned') ? 'active' : '' }}">
      <a href="{{ route('forms.assigned') }}" class="menu-link">
      <i class="menu-icon icon-base ti tabler-message-heart"></i>
      <div data-i18n="Go To Forms">Go To Forms</div>
      </a>
    </li>
  @endif

  </ul>

</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
    <i class="ti tabler-menu icon-base"></i>
    <i class="ti tabler-chevron-right icon-base"></i>
  </a>
</div>
<!-- Menu -->