<nav class="nav nav-pills">
    <a class="nav-link {{ is_active('admin.admin-users.index', 'active', true) }}"
        href="{{ route('admin.admin-users.index') }}">
        <i class="fas fa-user-shield fa-fw mr-2"></i>@lang('headings.admin-users.label')
    </a>

    <a class="nav-link {{ is_active('admin.client-users.index', 'active', true) }}"
        href="{{ route('admin.client-users.index') }}">
        <i class="fas fa-user-friends fa-fw mr-2"></i>@lang('headings.client-users.label')
    </a>
</nav>