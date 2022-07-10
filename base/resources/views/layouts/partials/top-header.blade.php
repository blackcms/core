<div class="page-header navbar navbar-static-top">
    <div class="page-header-inner">
        <div class="page-logo">
            @if (setting('admin_logo') || config('core.base.general.logo'))
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ setting('admin_logo') ? MediaManagement::getImageUrl(setting('admin_logo')) : url(config('core.base.general.logo')) }}" alt="logo" class="logo-default" />
                </a>
            @endif

            @auth
                @if (setting('admin_style_sidebar'))
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                @endif
            @endauth
        </div>

        @auth
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                <span></span>
            </a>
        @endauth

        @include('core/base::layouts.partials.top-menu')
    </div>
</div>

@if (!setting('admin_style_sidebar'))
    <nav class="admin-navbar navbar navbar-expand-lg navbar-dark py-0 px-3">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @foreach ($menus = dashboard_menu()->getAll() as $menu)
                    @php $menu = apply_filters(BASE_FILTER_DASHBOARD_MENU, $menu); @endphp
                    <li class="nav-item @if (isset($menu['children']) && count($menu['children'])) dropdown @endif ">
                        <a class="nav-link
                            @if (isset($menu['children']) && count($menu['children'])) dropdown-toggle @endif
                            @if ($menu['active']) text-white @endif" id="{{ $menu['id'] }}
                        "
                        @if (isset($menu['children']) && count($menu['children']))
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        @else
                            href="{{ $menu['url'] }}"
                        @endif
                        title="{{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span class="title">
                                {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                                {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']) !!}
                            </span>
                        </a>
                        @if (isset($menu['children']) && count($menu['children']))
                            <div class="dropdown-menu w-100 mb-2" aria-labelledby="{{ $menu['id'] }}">
                                @foreach ($menu['children'] as $item)
                                    <a class="dropdown-item @if ($item['active']) active @endif" href="{{ $item['url'] }}">
                                        {{-- <i class="{{ $item['icon'] }}"></i> --}}
                                        {{ trans($item['name']) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
@endif
