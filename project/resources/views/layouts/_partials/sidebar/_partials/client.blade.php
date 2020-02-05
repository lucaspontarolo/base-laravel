<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="{{ request()->is('home*', '/') ? 'active' : null }}">
    <a class="nav-link" href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Dashboard Geral">
      <i class="fas fa-fire"></i>
      <span>Dashboard Geral</span>
    </a>
  </li>
</ul>