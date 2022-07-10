<div class="meta-boxes form-actions form-actions-default action-{{ $direction ?? 'horizontal' }}">
    <div class="btn-set">
        @php do_action(BASE_ACTION_FORM_ACTIONS, 'default') @endphp
        @if (!isset($only_save) || $only_save == false)
            <button type="submit" name="submit" value="apply" class="btn btn-primary">
                <i class="las la-check la-2x"></i> {{ trans('core/base::forms.save_and_continue') }}
            </button>
        @endif
        <button type="submit" name="submit" value="save" class="btn btn-primary">
            <i class="{{ $saveIcon ?? 'las la-save la-2x' }}"></i> {{ $saveTitle ?? trans('core/base::forms.save') }}
        </button>
    </div>
</div>
<div id="waypoint"></div>
<div class="form-actions form-actions-fixed-top @if (setting('admin_style_sidebar')) sidebar @endif hidden">
    {!! Breadcrumbs::render('main', page_title()->getTitle(false)) !!}
    <div class="btn-set">
        @php do_action(BASE_ACTION_FORM_ACTIONS, 'fixed-top') @endphp
        <button type="submit" name="submit" value="save" class="btn btn-primary">
            <i class="{{ $saveIcon ?? 'las la-save la-2x' }}"></i> {{ $saveTitle ?? trans('core/base::forms.save') }}
        </button>
        @if (!isset($only_save) || $only_save == false)
            &nbsp;
            <button type="submit" name="submit" value="apply" class="btn btn-primary">
                <i class="las la-check la-2x"></i> {{ trans('core/base::forms.save_and_continue') }}
            </button>
        @endif
    </div>
</div>
