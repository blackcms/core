<script>
    "use strict";
    var MEDIA_MANAGEMENT_URL = {!! json_encode(MediaManagement::getUrls()) !!};
    var MEDIA_MANAGEMENT_CONFIG = {!! json_encode([
        'permissions'  => MediaManagement::getPermissions(),
        'translations' => trans('core/media::media.javascript'),
        'pagination'   => [
            'paged'                => MediaManagement::getConfig('pagination.paged'),
            'posts_per_page'       => MediaManagement::getConfig('pagination.per_page'),
            'in_process_get_media' => false,
            'has_more'             =>  true,
        ],
        'chunk'        => MediaManagement::getConfig('chunk'),
        'random_hash'  => setting('media_random_hash') ?: null,
    ]) !!}
</script>
