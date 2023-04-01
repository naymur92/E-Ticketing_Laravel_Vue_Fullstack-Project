<?php

// set collapsed class
function isCollapsed($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];

    if ($current_controller != $controllerName) {
        echo 'collapsed';
    }
}

// set active class in li tag
function isActiveLI($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];

    if ($current_controller == $controllerName) {
        echo 'active';
    }
}

// set show class in a tag
function isShow($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];

    if ($current_controller == $controllerName) {
        echo 'show';
    }
}

// set active class
function isActive($routeName)
{
    if (Route::currentRouteName() == $routeName) {
        echo 'active';
    }
}
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-train"></i>
    </div>
    <div class="sidebar-brand-text mx-3">E-Ticket</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ isActiveLI('dashboard') }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  {{-- Nav item -users --}}
  <li class="nav-item {{ isActiveLI('users') }}">
    <a class="nav-link {{ isCollapsed('users') }}" href="#" data-toggle="collapse" data-target="#userMenu"
      aria-expanded="true" aria-controls="userMenu">
      <i class="fas fa-user"></i>
      <span>Users</span>
    </a>
    <div id="userMenu" class="collapse {{ isShow('users') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">User Components:</h6>
        <a class="collapse-item {{ isActive('users.index') }}" href="{{ route('users.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>Users List</a>
        <a class="collapse-item {{ isActive('users.create') }}" href="{{ route('users.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add User</a>
      </div>
    </div>
  </li>
  </li>

  {{-- Nav item -stations --}}
  <li class="nav-item {{ isActiveLI('stations') }}">
    <a class="nav-link {{ isCollapsed('stations') }}" href="#" data-toggle="collapse" data-target="#stationMenu"
      aria-expanded="true" aria-controls="stationMenu">
      <i class="fas fa-map-marker-alt"></i>
      <span>Stations</span>
    </a>
    <div id="stationMenu" class="collapse {{ isShow('stations') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Train Components:</h6>
        <a class="collapse-item {{ isActive('stations.index') }}" href="{{ route('stations.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>Stations
          List</a>
        <a class="collapse-item {{ isActive('stations.create') }}" href="{{ route('stations.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add
          Station</a>
      </div>
    </div>
  </li>


  {{-- Nav item -all-trains --}}
  <li class="nav-item {{ isActiveLI('train-lists') }}">
    <a class="nav-link {{ isCollapsed('train-lists') }}" href="#" data-toggle="collapse"
      data-target="#trainlistMenu" aria-expanded="true" aria-controls="trainlistMenu">
      <i class="fas fa-subway"></i>
      <span>Root Trains</span>
    </a>
    <div id="trainlistMenu" class="collapse {{ isShow('train-lists') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">TrainList Components:</h6>
        <a class="collapse-item {{ isActive('train-lists.index') }}" href="{{ route('train-lists.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>All Root
          Trains</a>
        <a class="collapse-item {{ isActive('train-lists.create') }}" href="{{ route('train-lists.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add
          Root
          Train</a>
      </div>
    </div>
  </li>

  {{-- Nav item - routes --}}
  <li class="nav-item {{ isActiveLI('routes') }}">
    <a class="nav-link {{ isCollapsed('routes') }}" href="#" data-toggle="collapse" data-target="#routesMenu"
      aria-expanded="true" aria-controls="routesMenu">
      <i class="fas fa-route"></i>
      <span>Routes</span>
    </a>
    <div id="routesMenu" class="collapse {{ isShow('routes') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Route Components:</h6>
        <a class="collapse-item {{ isActive('routes.index') }}" href="{{ route('routes.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>All Routes</a>
        <a class="collapse-item {{ isActive('routes.create') }}" href="{{ route('routes.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add Route</a>
      </div>
    </div>
  </li>


  {{-- Nav item -bogi-types --}}
  <li class="nav-item {{ isActiveLI('bogi-types') }}">
    <a class="nav-link {{ isCollapsed('bogi-types') }}" href="#" data-toggle="collapse"
      data-target="#bogiTypeMenu" aria-expanded="true" aria-controls="bogiTypeMenu">
      <i class="fas fa-th-list"></i>
      <span>Bogi Types</span>
    </a>
    <div id="bogiTypeMenu" class="collapse {{ isShow('bogi-types') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">BogiType Components:</h6>
        <a class="collapse-item {{ isActive('bogi-types.index') }}" href="{{ route('bogi-types.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>Bogi Types</a>
      </div>
    </div>
  </li>

  {{-- Nav item -trains --}}
  <li class="nav-item {{ isActiveLI('trains') }}">
    <a class="nav-link {{ isCollapsed('trains') }}" href="#" data-toggle="collapse" data-target="#trainMenu"
      aria-expanded="true" aria-controls="trainMenu">
      <i class="fas fa-subway"></i>
      <span>Trains</span>
    </a>
    <div id="trainMenu" class="collapse {{ isShow('trains') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Train Components:</h6>
        <a class="collapse-item {{ isActive('trains.index') }}" href="{{ route('trains.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>Train List</a>
        <a class="collapse-item {{ isActive('trains.create') }}" href="{{ route('trains.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add Train</a>
      </div>
    </div>
  </li>


  {{-- Nav item -schedules --}}
  <li class="nav-item {{ isActiveLI('schedules') }}">
    <a class="nav-link {{ isCollapsed('schedules') }}" href="#" data-toggle="collapse"
      data-target="#scheduleMenu" aria-expanded="true" aria-controls="scheduleMenu">
      <i class="fas fa-calendar-alt"></i>
      <span>Schedules</span>
    </a>
    <div id="scheduleMenu" class="collapse {{ isShow('schedules') }}" aria-labelledby="headingTwo"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Schedule Components:</h6>
        <a class="collapse-item {{ isActive('schedules.index') }}" href="{{ route('schedules.index') }}"><i
            class="fas fa-list mr-2 text-primary"></i>Schedules List</a>
        <a class="collapse-item {{ isActive('schedules.create') }}" href="{{ route('schedules.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Add Schedule</a>
      </div>
    </div>
  </li>

  {{-- Nav item --}}

  <!-- Heading -->
  {{-- <div class="sidebar-heading">
    Interface
  </div> --}}

  <!-- Nav Item - Pages Collapse Menu -->
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Components:</h6>
        <a class="collapse-item" href="buttons.html">Buttons</a>
        <a class="collapse-item" href="cards.html">Cards</a>
      </div>
    </div>
  </li> --}}

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
