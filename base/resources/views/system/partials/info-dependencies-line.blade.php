<ul>
    @if(is_array($item['dependencies']))
        @foreach($item['dependencies'] as $dependencyName => $dependencyVersion)
            <li>{{ $dependencyName }} : <code>{{ $dependencyVersion }}</code></li>
        @endforeach
    @else
        <li><code>{{ $item['dependencies'] }}</code></li>
    @endif
</ul>
