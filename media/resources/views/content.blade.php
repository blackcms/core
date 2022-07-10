<div class="card media-management-container">
    <div class="media-management-wrapper">
        <input type="checkbox" id="media_aside_collapse" class="fake-click-event hidden">
        <input type="checkbox" id="media_details_collapse" class="fake-click-event hidden">
        <aside class="bg-primary media-management-aside @if (MediaManagement::getConfig('sidebar_display') != 'vertical') media-management-aside-hide-desktop @endif">
            <label for="media_aside_collapse" class="collapse-sidebar">
                <i class="far fa-window-close"></i>
            </label>
            <div class="media-management-block media-management-filters">
                <div class="media-management-block-title">
                    {{ trans('core/media::media.filter') }}
                </div>
                <div class="media-management-block-content">
                    <ul class="media-management-aside-list">
                        <li>
                            <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="everything">
                                <i class="fa fa-recycle"></i> {{ trans('core/media::media.everything') }}
                            </a>
                        </li>
                        @if (array_key_exists('image', MediaManagement::getConfig('mime_types', [])))
                            <li>
                                <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="image">
                                    <i class="fa fa-file-image"></i> {{ trans('core/media::media.image') }}
                                </a>
                            </li>
                        @endif
                        @if (array_key_exists('video', MediaManagement::getConfig('mime_types', [])))
                            <li>
                                <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="video">
                                    <i class="fa fa-file-video"></i> {{ trans('core/media::media.video') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="document">
                                <i class="fa fa-file"></i> {{ trans('core/media::media.document') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="media-management-block media-management-view-in">
                <div class="media-management-block-title">
                    {{ trans('core/media::media.view_in') }}
                </div>
                <div class="media-management-block-content">
                    <ul class="media-management-aside-list">
                        <li>
                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="all_media">
                                <i class="fa fa-globe"></i> {{ trans('core/media::media.all_media') }}
                            </a>
                        </li>
                        @if (MediaManagement::hasAnyPermission(['folders.destroy', 'files.destroy']))
                            <li>
                                <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="trash">
                                    <i class="fa fa-trash"></i> {{ trans('core/media::media.trash') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="recent">
                                <i class="fa fa-clock"></i> {{ trans('core/media::media.recent') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="favorites">
                                <i class="fa fa-star"></i> {{ trans('core/media::media.favorites') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="media-management-main-wrapper">
            <header class="media-management-header">
                <div class="bg-primary media-management-top-header">
                    <div class="media-management-actions">
                        <label for="media_aside_collapse" class="btn btn-light collapse-sidebar">
                            <i class="fa fa-bars"></i>
                        </label>

                        @if (MediaManagement::hasPermission('folders.create'))
                            <button class="btn btn-light js-create-folder-action" type="button">
                                {{-- <i class="fa fa-folder"></i> --}}
                                {{ trans('core/media::media.create_folder') }}
                            </button>
                        @endif

                        @if (MediaManagement::getConfig('sidebar_display') != 'vertical')
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle js-media-management-change-filter-group js-filter-by-view-in" type="button" data-bs-toggle="dropdown">
                                        <i class="fa fa-eye"></i>
                                        {{-- {{ trans('core/media::media.view_in') }} --}}
                                        <span class="js-media-management-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="all_media">
                                                <i class="fa fa-globe"></i> {{ trans('core/media::media.all_media') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="trash">
                                                <i class="fa fa-trash"></i> {{ trans('core/media::media.trash') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="recent">
                                                <i class="fa fa-clock"></i> {{ trans('core/media::media.recent') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="view_in" data-value="favorites">
                                                <i class="fa fa-star"></i> {{ trans('core/media::media.favorites') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle js-media-management-change-filter-group js-filter-by-type" type="button" data-bs-toggle="dropdown">
                                        <i class="fa fa-filter"></i>
                                        {{-- {{ trans('core/media::media.filter') }} --}}
                                        <span class="js-media-management-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="everything">
                                                <i class="fa fa-recycle"></i> {{ trans('core/media::media.everything') }}
                                            </a>
                                        </li>
                                        @if (array_key_exists('image', MediaManagement::getConfig('mime_types', [])))
                                            <li>
                                                <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="image">
                                                    <i class="fa fa-file-image"></i> {{ trans('core/media::media.image') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (array_key_exists('video', MediaManagement::getConfig('mime_types', [])))
                                            <li>
                                                <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="video">
                                                    <i class="fa fa-file-video"></i> {{ trans('core/media::media.video') }}
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="#" class="js-media-management-change-filter" data-type="filter" data-value="document">
                                                <i class="fa fa-file"></i> {{ trans('core/media::media.document') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <button class="btn btn-light js-change-action" data-type="refresh">
                            <i class="fas fa-sync"></i>
                            {{-- {{ trans('core/media::media.refresh') }} --}}
                        </button>

                        @if (MediaManagement::hasPermission('files.create'))
                            <button class="btn btn-light js-dropzone-upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                {{-- {{ trans('core/media::media.upload') }} --}}
                            </button>

                            <button class="btn btn-light js-download-action" type="button">
                                <i class="fas fa-cloud-download-alt"></i>
                                {{-- {{ trans('core/media::media.download_link') }} --}}
                            </button>
                        @endif

                        @if (MediaManagement::hasAnyPermission(['folders.destroy', 'files.destroy']))
                            <button class="btn btn-danger js-files-action hidden" data-action="empty_trash">
                                <i class="fa fa-trash"></i> {{ trans('core/media::media.empty_trash') }}
                            </button>
                        @endif

                    </div>
                    <div class="media-management-search">
                        <form class="input-search-wrapper" action="" method="GET">
                            <input type="text" class="form-control" placeholder="{{ trans('core/media::media.search_file_and_folder') }}">
                            <button class="btn btn-link" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="media-management-bottom-header">
                    <div class="media-management-breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </div>
                    <div class="media-management-tools">
                        <div class="btn-group js-media-management-change-view-type mx-0" role="group">
                            <button class="btn btn-secondary" type="button" data-type="tiles">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="btn btn-secondary" type="button" data-type="list">
                                <i class="fa fa-th-list"></i>
                            </button>
                        </div>

                        <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown">
                                    {{ trans('core/media::media.sort') }} <i class="fa fa-sort-alpha-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="name-asc">
                                            <i class="fas fa-sort-alpha-up"></i> {{ trans('core/media::media.file_name_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="name-desc">
                                            <i class="fas fa-sort-alpha-down"></i> {{ trans('core/media::media.file_name_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('core/media::media.uploaded_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('core/media::media.uploaded_date_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="size-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('core/media::media.size_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-media-management-change-filter"
                                           data-type="sort_by"
                                           data-value="size-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('core/media::media.size_desc') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown rv-dropdown-actions disabled mx-2">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown">
                                    {{ trans('core/media::media.actions') }} &nbsp;<i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu"></ul>
                            </div>
                        </div>
                        {{-- <label for="media_details_collapse" class="btn text-primary collapse-panel">
                            <i class="fas fa-sign-out-alt"></i>
                        </label> --}}
                    </div>
                </div>
            </header>

            <main class="media-management-main">
                <div class="media-management-items"></div>
                <div class="media-management-details hidden">
                    <div class="media-management-thumbnail">
                        <i class="far fa-image"></i>
                    </div>
                    <div class="media-management-description">
                        <div class="media-management-name">
                            <p>{{ trans('core/media::media.nothing_is_selected') }}</p>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="media-management-footer hidden">
                <button type="button" class="btn btn-danger btn-lg js-insert-to-editor">{{ trans('core/media::media.insert') }}</button>
            </footer>
        </div>
        <div class="rv-upload-progress hide-the-pane">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('core/media::media.upload_progress') }}</h3>
                    <a href="javascript:void(0);" class="close-pane">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="panel-body">
                    <ul class="rv-upload-progress-table"></ul>
                </div>
            </div>
        </div>
    </div>

    <div class="rv-modals">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_folder">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fa fa-folder"></i> {{ trans('core/media::media.create_folder') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="rv-form form-add-folder">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ trans('core/media::media.folder_name') }}">
                                <button class="btn btn-light rv-btn-add-folder" type="submit">{{ trans('core/media::media.create') }}</button>
                            </div>
                        </form>
                        <div class="modal-notice"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_rename_items">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="rv-form form-rename">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('core/media::media.rename') }}
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="rename-items"></div>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('core/media::media.close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('core/media::media.save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_trash_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('core/media::media.move_to_trash') }}
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('core/media::media.confirm_trash') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('core/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('core/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('core/media::media.confirm_delete') }}
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('core/media::media.confirm_delete_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('core/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('core/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_empty_trash">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-empty-trash">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('core/media::media.empty_trash_title') }}
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('core/media::media.empty_trash_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('core/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('core/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_download_url">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" data-downloading="{{trans('core/media::media.downloading')}}" data-text="{{ trans('core/media::media.download_link') }}">
                            <i class="fas fa-cloud-download-alt"></i> {{ trans('core/media::media.download_link') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('core/media::media.close') }}">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="rv-form form-download-url">
                            <div id="download-form-wrapper">
                                <div class="form-group mb-3">
                                <textarea rows="4"
                                          name="urls"
                                          class="form-control"
                                          placeholder="http://example.com/image1.jpg&#10;http://example.com/image2.jpg&#10;http://example.com/image3.jpg&#10;..."></textarea>
                                </div>
                                {!! Form::helper(trans('core/media::media.download_explain')) !!}
                            </div>
                            <button class="btn btn-light w-100" type="submit">{{ trans('core/media::media.download_link') }}</button>
                        </form>
                        <div class="modal-notice mt-2" id="modal-notice" style="max-height: 350px;overflow: auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="hidden js-rv-clipboard-temp"></button>
</div>
<script type="text/x-custom-template" id="media_management_loading">
    <div class="loading-wrapper">
        <div class="showbox">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                            stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
    </div>
</script>

<script type="text/x-custom-template" id="rv_action_item">
    <li>
        <a href="javascript:;" class="js-files-action" data-action="__action__">
            <i class="__icon__"></i> __name__
        </a>
    </li>
</script>

<script type="text/x-custom-template" id="media_management_items_list">
    <div class="media-management-list">
        <ul>
            <li class="no-items">
                <h3>Drop files and folders here</h3>
                <p>Or use the upload button above.</p>
            </li>
            <li class="media-management-list-title up-one-level js-up-one-level" title="{{ trans('core/media::media.up_level') }}">
                <div class="custom-checkbox"></div>
                <div class="media-management-file-name">
                    <i class="fas fa-level-up-alt"></i>
                    <span>...</span>
                </div>
                <div class="media-management-file-size"></div>
                <div class="media-management-created-at"></div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="media_management_items_tiles" class="hidden">
    <div class="media-management-grid">
        <ul>
            <li class="no-items">
                <h3>__noItemTitle__</h3>
                <p>__noItemMessage__</p>
            </li>
            <li class="media-management-list-title up-one-level js-up-one-level">
                <div class="media-management-item" data-context="__type__" title="{{ trans('core/media::media.up_level') }}">
                    <div class="media-management-thumbnail">
                        <i class="fas fa-level-up-alt"></i>
                    </div>
                    <div class="media-management-description">
                        <div class="title">...</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="media_management_items_list_element">
    <li class="media-management-list-title js-media-list-title js-context-menu" data-context="__type__" title="__name__" data-id="__id__">
        <div class="custom-checkbox">
            <label>
                <input type="checkbox">
                <span></span>
            </label>
        </div>
        <div class="media-management-file-name">
            __thumb__
            <span>__name__</span>
        </div>
        <div class="media-management-file-size">__size__</div>
        <div class="media-management-created-at">__date__</div>
    </li>
</script>

<script type="text/x-custom-template" id="media_management_items_tiles_element">
    <li class="media-management-list-title js-media-list-title js-context-menu" data-context="__type__" data-id="__id__">
        <input type="checkbox" class="hidden">
        <div class="media-management-item" title="__name__">
            <span class="media-item-selected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M186.301 339.893L96 249.461l-32 30.507L186.301 402 448 140.506 416 110z"></path>
                </svg>
            </span>
            <div class="media-management-thumbnail">
                __thumb__
            </div>
            <div class="media-management-description">
                <div class="title title{{ Request::input('file_id') }}">__name__</div>
            </div>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="media_management_upload_progress_item">
    <li>
        <div class="rv-table-col">
            <span class="file-name">__fileName__</span>
            <div class="file-error"></div>
        </div>
        <div class="rv-table-col">
            <span class="file-size">__fileSize__</span>
        </div>
        <div class="rv-table-col">
            <span class="label label-__status__">__message__</span>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="media_management_breadcrumb_item">
    <li>
        <a href="#" data-folder="__folderId__" class="js-change-folder">__icon__ __name__</a>
    </li>
</script>

<script type="text/x-custom-template" id="media_management_rename_item">
    <div class="form-group mb-3">
        <div class="input-group">
            <div class="input-group-text">
                <i class="__icon__"></i>
            </div>
            <input class="form-control" placeholder="__placeholder__" value="__value__">
        </div>
    </div>
</script>
