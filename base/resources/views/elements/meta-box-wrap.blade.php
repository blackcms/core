<div id="{{ $box['id'] }}" class="card meta-boxes">
     <div class="widget-title">
          <h4><span>{!! BaseHelper::clean($box['title']) !!}</span></h4>
     </div>
     <div class="widget-body">
          {!! $callback !!}
     </div>
</div>