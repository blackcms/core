@if (empty($widgetSetting) || $widgetSetting->status == 1)
    <div class="col-md-3 col-12 pb-2">
        <a class="widget-stats card p-2 text-center" href="{{ $widget->route }}">
            <i class="{{ $widget->icon }} la-4x"></i>
            <div class="mt-2 h1">
                <span data-counter="counterup" data-value="{{ $widget->statsTotal }}">
                    0
                </span>
                <span>{{ $widget->title }}</span>
            </div>
        </a>
    </div>
@endif
