import { RecentItems } from "../Config/MediaConfig";
import { Helpers } from "../Helpers/Helpers";
import { MessageService } from "./MessageService";
import { ActionsService } from "./ActionsService";
import { ContextMenuService } from "./ContextMenuService";
import { MediaList } from "../Views/MediaList";
import { MediaDetails } from "../Views/MediaDetails";

export class MediaService {
    constructor() {
        this.MediaList = new MediaList();
        this.MediaDetails = new MediaDetails();
        this.breadcrumbTemplate = $("#media_management_breadcrumb_item").html();
    }

    getMedia(reload = false, is_popup = false, load_more_file = false) {
        if (typeof MEDIA_MANAGEMENT_CONFIG.pagination != "undefined") {
            if (MEDIA_MANAGEMENT_CONFIG.pagination.in_process_get_media) {
                return;
            }

            MEDIA_MANAGEMENT_CONFIG.pagination.in_process_get_media = true;
        }

        let _self = this;

        _self.getFileDetails({
            icon: "far fa-image",
            nothing_selected: "",
        });

        let params = Helpers.getRequestParams();

        if (params.view_in === "recent") {
            params.recent_items = RecentItems;
        }

        if (is_popup === true) {
            params.is_popup = true;
        } else {
            params.is_popup = undefined;
        }

        params.onSelectFiles = undefined;

        if (
            typeof params.search != "undefined" &&
            params.search != "" &&
            typeof params.selected_file_id != "undefined"
        ) {
            params.selected_file_id = undefined;
        }

        params.load_more_file = load_more_file;
        if (typeof MEDIA_MANAGEMENT_CONFIG.pagination != "undefined") {
            params.paged = MEDIA_MANAGEMENT_CONFIG.pagination.paged;
            params.posts_per_page =
                MEDIA_MANAGEMENT_CONFIG.pagination.posts_per_page;
        }
        $.ajax({
            url: MEDIA_MANAGEMENT_URL.get_media,
            type: "GET",
            data: params,
            dataType: "json",
            beforeSend: () => {
                Helpers.showAjaxLoading();
            },
            success: (res) => {
                _self.MediaList.renderData(res.data, reload, load_more_file);
                _self.renderBreadcrumbs(res.data.breadcrumbs);
                MediaService.refreshFilter();
                ActionsService.renderActions();

                if (typeof MEDIA_MANAGEMENT_CONFIG.pagination != "undefined") {
                    if (
                        typeof MEDIA_MANAGEMENT_CONFIG.pagination.paged !=
                        "undefined"
                    ) {
                        MEDIA_MANAGEMENT_CONFIG.pagination.paged += 1;
                    }

                    if (
                        typeof MEDIA_MANAGEMENT_CONFIG.pagination
                            .in_process_get_media != "undefined"
                    ) {
                        MEDIA_MANAGEMENT_CONFIG.pagination.in_process_get_media = false;
                    }

                    if (
                        typeof MEDIA_MANAGEMENT_CONFIG.pagination
                            .posts_per_page != "undefined" &&
                        res.data.files.length + res.data.folders.length <
                            MEDIA_MANAGEMENT_CONFIG.pagination.posts_per_page &&
                        typeof MEDIA_MANAGEMENT_CONFIG.pagination.has_more !=
                            "undefined"
                    ) {
                        MEDIA_MANAGEMENT_CONFIG.pagination.has_more = false;
                    }
                }
            },
            complete: () => {
                Helpers.hideAjaxLoading();
            },
            error: (data) => {
                MessageService.handleError(data);
            },
        });
    }

    getFileDetails(data) {
        this.MediaDetails.renderData(data);
    }

    renderBreadcrumbs(breadcrumbItems) {
        let _self = this;
        let $breadcrumbContainer = $(
            ".media-management-breadcrumb .breadcrumb"
        );
        $breadcrumbContainer.find("li").remove();

        _.each(breadcrumbItems, (value) => {
            let template = _self.breadcrumbTemplate;
            template = template
                .replace(/__name__/gi, value.name || "")
                .replace(
                    /__icon__/gi,
                    value.icon ? '<i class="' + value.icon + '"></i>' : ""
                )
                .replace(/__folderId__/gi, value.id || 0);
            $breadcrumbContainer.append($(template));
        });
        $(".media-management-container").attr(
            "data-breadcrumb-count",
            _.size(breadcrumbItems)
        );
    }

    static refreshFilter() {
        let $mediaManagementContainer = $(".media-management-container");
        let viewIn = Helpers.getRequestParams().view_in;
        if (viewIn !== "all_media" && !Helpers.getRequestParams().folder_id) {
            $(
                '.media-management-actions .btn:not([data-type="refresh"]):not(label)'
            ).addClass("disabled");
            $mediaManagementContainer.attr("data-allow-upload", "false");
        } else {
            $(
                '.media-management-actions .btn:not([data-type="refresh"]):not(label)'
            ).removeClass("disabled");
            $mediaManagementContainer.attr("data-allow-upload", "true");
        }

        $(
            ".media-management-actions .btn.js-media-management-change-filter-group"
        ).removeClass("disabled");

        let $empty_trash_btn = $(
            '.media-management-actions .btn[data-action="empty_trash"]'
        );
        if (viewIn === "trash") {
            $empty_trash_btn.removeClass("hidden").removeClass("disabled");
            if (!_.size(Helpers.getItems())) {
                $empty_trash_btn.addClass("hidden").addClass("disabled");
            }
        } else {
            $empty_trash_btn.addClass("hidden");
        }

        ContextMenuService.destroyContext();
        ContextMenuService.initContext();

        $mediaManagementContainer.attr("data-view-in", viewIn);
    }
}
