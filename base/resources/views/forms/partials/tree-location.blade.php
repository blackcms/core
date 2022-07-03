<ul class="{{ $className ?? '' }}">
    @foreach ($locations->where('parent_id', $parent_id ?? 0) as $location)
        @php
            $totalChildren = $locations->where('parent_id', $location->id)->count()
        @endphp
        <li class="folder-root open" data-id="{{ $location->id }}">
            <a href="{{ $canEdit && $editRoute ? route($editRoute, $location->id) : '' }}" class="fetch-data location-name">
                @if ($totalChildren)
                    <i class="far fa-folder"></i>
                @else
                    <i class="far fa-file"></i>
                @endif
                <span>{{ $location->name }}</span>
                @if ($location->badge_with_count)
                    {!! $location->badge_with_count !!}
                @endif
            </a>
            @if ($location->url)
                <a href="{{ $location->url }}"
                    target="_blank"
                    class="text-info"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ trans('core/base::forms.view_new_tab') }}">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            @endif
            @if ($canDelete)
                <a href="#"
                    class="deleteDialog"
                    data-section="{{ route($deleteRoute, $location->id) }}"
                    role="button"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ trans('core/table::table.delete') }}">
                    <i class="fa fa-trash text-danger"></i>
                </a>
            @endif
            @if ($totalChildren)
                <i class="far fa-minus-square file-opener-i"></i>
                @include('core/base::forms.partials.tree-location', ['parent_id' => $location->id, 'className' => ''])
            @endif
        </li>
    @endforeach
</ul>
