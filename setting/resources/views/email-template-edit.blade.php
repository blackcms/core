@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    {!! Form::open(['route' => ['setting.email.template.store']]) !!}
    <div>
        <div class="row">
            <div class="col-12">
                <div class="annotated-section-title">
                    <h2>{{ trans('core/setting::setting.email.title') }}</h2>
                </div>
                <div class="annotated-section-description p-none-t">
                    <p class="color-note">
                        {!! clean(trans('core/setting::setting.email.description')) !!}
                    </p>
                    <div class="available-variable">
                        @foreach(EmailHandler::getVariables('core') as $coreKey => $coreVariable)
                            <p><span class="text-danger">{{ $coreKey }}</span>: {{ $coreVariable }}</p>
                        @endforeach
                        @foreach(EmailHandler::getVariables($addonData['name']) as $moduleKey => $moduleVariable)
                            <p><span class="text-danger">{{ $moduleKey }}</span>: {{ trans($moduleVariable) }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card email-template-edit-wrap">
                    <div class="card-body">
                        @if ($emailSubject)
                            <div class="form-group mb-3">
                                <label class="text-title-field"
                                    for="email_subject">
                                    {{ trans('core/setting::setting.email.subject') }}
                                </label>
                                <input type="hidden" name="email_subject_key"
                                    value="{{ get_setting_email_subject_key($addonData['type'], $addonData['name'], $addonData['template_file']) }}">
                                <input data-counter="300" type="text" class="next-input"
                                    name="email_subject"
                                    id="email_subject"
                                    value="{{ $emailSubject }}">
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <input type="hidden" name="template_path" value="{{ get_setting_email_template_path($addonData['name'], $addonData['template_file']) }}">
                            <label class="text-title-field"
                                for="email_content">{{ trans('core/setting::setting.email.content') }}</label>
                            <textarea id="mail-template-editor" name="email_content" class="form-control" style="overflow-y:scroll; height: 500px;">{{ $emailContent }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="border: none">
            <div class="col-12">
                &nbsp;
            </div>
            <div class="col-12">
                <a href="{{ route('settings.email') }}" class="btn btn-secondary">{{ trans('core/setting::setting.email.back') }}</a>
                <a class="btn btn-primary btn-trigger-reset-to-default" data-target="{{ route('setting.email.template.reset-to-default') }}">{{ trans('core/setting::setting.email.reset_to_default') }}</a>
                <button class="btn btn-primary" type="submit" name="submit">{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::modalAction('reset-template-to-default-modal', trans('core/setting::setting.email.confirm_reset'), 'info', trans('core/setting::setting.email.confirm_message'), 'reset-template-to-default-button', trans('core/setting::setting.email.continue')) !!}
@endsection
