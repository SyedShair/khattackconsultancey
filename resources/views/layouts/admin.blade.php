<!DOCTYPE html>
       <html lang="en" data-bs-theme="{{ $appSetting->theme ?? 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

           <title>@yield('title') | {{ $appSetting->app_name ?? config('app.name') }}</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- NAVBAR -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="{{ url('/dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">

               
                @auth
                   <li class="nav-item dropdown user-menu">
    <a href="#"
       class="nav-link dropdown-toggle d-flex align-items-center"
       data-bs-toggle="dropdown"
       aria-expanded="false">

        <img src="{{ auth()->user()->avatar
    ? asset('storage/' . auth()->user()->avatar)
    : asset('assets/img/user2-160x160.jpg') }}"
    class="user-image rounded-circle shadow"
    alt="{{ auth()->user()->name }}">
        <span class="d-none d-md-inline">
            {{ auth()->user()->name }}
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

        {{-- User Image --}}
        <li class="user-header text-bg-primary text-center p-3">
          <img src="{{ auth()->user()->avatar
    ? asset('storage/' . auth()->user()->avatar)
    : asset('assets/img/user2-160x160.jpg') }}"
    class="user-image rounded-circle shadow"
    alt="{{ auth()->user()->name }}">

            <p class="mb-0 mt-2">
                {{ auth()->user()->name }}

                @if(auth()->user()->role ?? false)
                    - {{ auth()->user()->role }}
                @endif

                <small class="d-block">
                    Member since {{ auth()->user()->created_at->format('M. Y') }}
                </small>
            </p>
        </li>

        {{-- Menu Body --}}
        

        {{-- Menu Footer --}}
        <li class="user-footer p-2">
            <a href="#"
               class="btn btn-outline-secondary">
                Profile
            </a>

            <form method="POST"
                  action="{{ route('logout') }}"
                  class="d-inline float-end">
                @csrf

                <button type="submit"
                        class="btn btn-outline-danger">
                    Sign out
                </button>
            </form>
        </li>

    </ul>
</li>
                @endauth

            </ul>

        </div>
    </nav>

    <!-- SIDEBAR -->
    <aside class="app-sidebar bg-body-secondary shadow" {{ ($appSetting->theme ?? 'light') === 'dark' ? 'dark-mode' : '' }}>

        <div class="sidebar-brand">
              <a href="{{ url('/dashboard') }}" class="brand-link">


           <img src="{{ asset('storage/' . $appSetting->logo ?? asset('adminlte/img/AdminLTELogo.png') ) }}"
                class="brand-image opacity-75 shadow" alt="Logo">
       </a>
        </div>

      <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}"
                           class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">USER MANAGEMENT</li>

                    <li class="nav-item has-treeview {{ request()->is('users*', 'roles*', 'permissions*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('users*', 'roles*', 'permissions*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>
                                User Management
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ url('/users') }}"
                                   class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Users</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/roles') }}"
                                   class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-shield-lock"></i>
                                    <p>Roles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/permissions') }}"
                                   class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-key"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>


                        </ul>
                    </li>

                    <li class="nav-header">App Settings</li>
                            <li class="nav-item">
                                <a href="{{ url('/settings') }}"
                                   class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-gear"></i>
                                    <p>Settings</p>
                                </a>
                            </li>
 <li class="nav-header">RECRUITMENT</li>
 
                    <li class="nav-item has-treeview {{ request()->is('admin/vacancies*', 'admin/applications*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/vacancies*', 'admin/applications*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-briefcase"></i>
                            <p>
                                Careers
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
 
                            <li class="nav-item">
                                <a href="{{ url('/admin/vacancies') }}"
                                   class="nav-link {{ request()->is('admin/vacancies*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-list-check"></i>
                                    <p>Vacancies</p>
                                </a>
                            </li>
 
                            <li class="nav-item">
                                <a href="{{ url('/admin/applications') }}"
                                   class="nav-link {{ request()->is('admin/applications*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-lines-fill"></i>
                                    <p>Applications</p>
                                </a>
                            </li>
 
                        </ul>
                    </li>
   <li class="nav-header">WEBSITE CONTENT</li>
 
                    <li class="nav-item">
                        <a href="{{ url('/admin/hero-slides') }}"
                           class="nav-link {{ request()->is('admin/hero-slides*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-images"></i>
                            <p>Hero Slides</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ url('/admin/services') }}"
                           class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-grid-3x3-gap"></i>
                            <p>Services</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">@yield('page_title', 'Dashboard')</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>

    </main>

    <footer class="app-footer">
        <strong>{{ config('app.name') }}</strong>
        <div class="float-end d-none d-sm-inline-block">
            <b>Laravel</b> 12 · AdminLTE 4
        </div>
    </footer>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>

@stack('scripts')

</body>
</html>
