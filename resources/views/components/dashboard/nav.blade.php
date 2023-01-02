@php
    $nav = [
        'dashboard' => ['title' => 'Dashboard', 'route' => '', 'active' => ''],
        'categories' => ['title' => 'Categories', 'route' => 'dashboard.categories.index', 'active' => 'dashboard.categories.*'],
        'products' => ['title' => 'Products', 'route' => 'dashboard.products.index', 'active' => 'dashboard.products.*'],
        'users' => ['title' => 'Users', 'route' => '', 'active' => ''],
    ]
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @foreach ($nav as $key => $value)
        <li class="nav-item">
            <a href="{{ $value['route']? route($value['route']) : '#' }}" class="nav-link @if(Route::is($value['active'])) active @endif">
                <i class="nav-icon fas fa-th"></i>
                <p>{{ $value['title'] }}</p>
            </a>
        </li>
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->