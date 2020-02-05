<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <div class="navbar-brand mr-auto">
        <span class="d-none d-sm-inline-block">{{ config('app.name') }}</span>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="avatar" src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none ">
                    {{ current_user()->name }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Ações</div>
                    @php
                        $profileRouteName = (current_user()->hasRole(\App\Enums\UserRolesEnum::ADMIN) ? 'admin.profile' : 'client.profile')
                    @endphp
                    <a href="{{ route($profileRouteName) }}" class="dropdown-item has-icon {{ is_active($profileRouteName) }}">
                        <i class="far fa-user"></i> Perfil
                    </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger" data-toggle="modal" data-target="#logout-modal">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
