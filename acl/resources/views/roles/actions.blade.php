<div class="card meta-boxes form-actions form-actions-default action-{{ $direction ?? 'horizontal' }}">
    <div class="widget-title">
        <h4>
            <span>{{ trans('core/base::forms.actions') }}</span>
        </h4>
    </div>
    <div class="widget-body">
        <div class="btn-set">
            @if ($role && $role->id)
                <a href="{{ route('roles.duplicate', [$role->id]) }}" class="btn btn-primary"><i class="fa fa-copy"></i> {{ trans('core/acl::permissions.duplicate') }}</a>
            @endif
            <button type="submit" name="submit" value="save" class="btn btn-primary">
                <i class="las la-save la-2x"></i> {{ trans('core/base::forms.save') }}
            </button>
            <button type="submit" name="submit" value="apply" class="btn btn-primary">
                <i class="las la-check la-2x"></i> {{ trans('core/base::forms.save_and_continue') }}
            </button>
        </div>
    </div>
</div>
<div id="waypoint"></div>
<div class="form-actions form-actions-fixed-top @if (setting('admin_style_sidebar')) sidebar @endif hidden">
    {!! Breadcrumbs::render('main', page_title()->getTitle(false)) !!}
    <div class="btn-set">
        @if ($role && $role->id)
            <a href="{{ route('roles.duplicate', [$role->id]) }}" class="btn btn-primary"><i class="fa fa-copy"></i> {{ trans('core/acl::permissions.duplicate') }}</a>
        @endif
        <button type="submit" name="submit" value="save" class="btn btn-primary">
            <i class="las la-save la-2x"></i> {{ trans('core/base::forms.save') }}
        </button>
        <button type="submit" name="submit" value="apply" class="btn btn-primary">
            <i class="las la-check la-2x"></i> {{ trans('core/base::forms.save_and_continue') }}
        </button>
    </div>
</div>
