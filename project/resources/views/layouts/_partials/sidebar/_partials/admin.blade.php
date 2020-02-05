<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="{{ request()->is('home*', '/') ? 'active' : null }}">
    <a class="nav-link" href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Dashboard Geral">
      <i class="fas fa-fire"></i>
      <span>Dashboard Geral</span>
    </a>
  </li>

  <li class="menu-header">@lang('headings.common.registration')</li>
  <li class="{{ is_active(['admin.admin-users.index', 'admin.client-users.index']) }}">
    <a class="nav-link" href="{{ route('admin.admin-users.index') }}" data-toggle="tooltip" data-placement="right"
      title="@lang('headings.common.users')">
      <i class="fas fa-users"></i>
      <span>@lang('headings.common.users')</span>
    </a>
  </li>
</ul>