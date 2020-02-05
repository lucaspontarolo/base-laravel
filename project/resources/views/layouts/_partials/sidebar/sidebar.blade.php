<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('home') }}">
        {{ config('app.name') }}
      </a>
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('home') }}">Base</a>
    </div>

    @if(current_user()->hasRole(\App\Enums\UserRolesEnum::ADMIN))
      @include('layouts._partials.sidebar._partials.admin')
    @elseif(current_user()->hasRole(\App\Enums\UserRolesEnum::CLIENT))
      @include('layouts._partials.sidebar._partials.client')
    @endif

  </aside>
</div>