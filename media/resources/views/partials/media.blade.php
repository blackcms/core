<div class="modal fade media-modal"
    data-keyboard="false"
    tabindex="-1"
    role="dialog"
    id="media_management_modal"
    aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-full">
        <div class="modal-content bb-loading">
            <div class="modal-header">
                <h4 class="modal-title"><strong>{{ trans('core/media::media.gallery') }}</strong></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}"></button>
            </div>
            <div class="modal-body media-modal-body media-modal-loading" id="media_management_body"></div>
            <div class="loading-wrapper">
                <div class="loader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@include('core/media::config')
<link href="{{ asset('vendor/core/core/media/css/media.css?v=' . time()) }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('vendor/core/core/media/js/integrate.js?v=' . time()) }}"></script>
