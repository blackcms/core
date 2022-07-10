@if (setting('admin_style_sidebar'))
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <div class="sidebar">
                <div class="sidebar-content">
                    <ul class="page-sidebar-menu page-header-fixed {{ session()->get('sidebar-menu-toggle') ? 'page-sidebar-menu-closed' : '' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        @foreach ($menus = dashboard_menu()->getAll() as $menu)
                            @php $menu = apply_filters(BASE_FILTER_DASHBOARD_MENU, $menu); @endphp
                            <li class="nav-item @if ($menu['active']) active @endif" id="{{ $menu['id'] }}">
                                <a href="{{ $menu['url'] }}" class="nav-link nav-toggle">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <span class="title">
                                        {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                                        {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']) !!}
                                    </span>
                                    @if (isset($menu['children']) && count($menu['children']))
                                        <i class="las la-ellipsis-h" style="float: right;"></i>
                                    @endif
                                </a>
                                @if (isset($menu['children']) && count($menu['children']))
                                    <ul class="sub-menu @if (!$menu['active']) hidden-ul @endif">
                                        @foreach ($menu['children'] as $item)
                                            <li class="nav-item @if ($item['active']) active @endif" id="{{ $item['id'] }}">
                                                <a href="{{ $item['url'] }}" class="nav-link">
                                                    <i class="{{ $item['icon'] }}"></i>
                                                    {{ trans($item['name']) }}
                                                    {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $item['id']) !!}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
