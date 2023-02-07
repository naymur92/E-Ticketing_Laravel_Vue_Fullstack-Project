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
        <a class="collapse-item {{ isActive('trains.index') }}" href="{{ route('trains.index') }}">Train List</a>
        <a class="collapse-item {{ isActive('trains.create') }}" href="{{ route('trains.create') }}">Add Train</a>
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
