import { Helpers } from "./App/Helpers/Helpers";
import { MediaConfig } from "./App/Config/MediaConfig";
import { ContextMenuService } from "./App/Services/ContextMenuService";

export class EditorService {
    static editorSelectFile(selectedFiles) {
        let is_ckeditor =
            Helpers.getUrlParam("CKEditor") ||
            Helpers.getUrlParam("CKEditorFuncNum");

        if (window.opener && is_ckeditor) {
            let firstItem = _.first(selectedFiles);

            window.opener.CKEDITOR.tools.callFunction(
                Helpers.getUrlParam("CKEditorFuncNum"),
                firstItem.full_url
            );

            if (window.opener) {
                window.close();
            }
        } else {
            // No WYSIWYG editor found, use custom method.
        }
    }
}

class mediaManagement {
    constructor(selector, options) {
        window.mediaManagement = window.mediaManagement || {};

        let $body = $("body");

        let defaultOptions = {
            multiple: true,
            type: "*",
            onSelectFiles: (files, $el) => {},
        };

        options = $.extend(true, defaultOptions, options);

        let clickCallback = (event) => {
            event.preventDefault();
            let $current = $(event.currentTarget);

            $("#media_management_modal").modal("show");

            window.mediaManagement.options = options;
            window.mediaManagement.options.open_in = "modal";

            window.mediaManagement.$el = $current;

            MediaConfig.request_params.filter = "everything";
            Helpers.storeConfig();

            let elementOptions =
                window.mediaManagement.$el.data("media-management");
            if (
                typeof elementOptions !== "undefined" &&
                elementOptions.length > 0
            ) {
                elementOptions = elementOptions[0];
                window.mediaManagement.options = $.extend(
                    true,
                    window.mediaManagement.options,
                    elementOptions || {}
                );
                if (typeof elementOptions.selected_file_id !== "undefined") {
                    window.mediaManagement.options.is_popup = true;
                } else if (
                    typeof window.mediaManagement.options.is_popup !==
                    "undefined"
                ) {
                    window.mediaManagement.options.is_popup = undefined;
                }
            }

            if (
                $("#media_management_body .media-management-container")
                    .length === 0
            ) {
                $("#media_management_body").load(
                    MEDIA_MANAGEMENT_URL.popup,
                    (data) => {
                        if (data.error) {
                            alert(data.message);
                        }

                        $("#media_management_body")
                            .removeClass("media-modal-loading")
                            .closest(".modal-content")
                            .removeClass("bb-loading");
                        $(document)
                            .find(
                                ".media-management-container .js-change-action[data-type=refresh]"
                            )
                            .trigger("click");

                        if (
                            Helpers.getRequestParams().filter !== "everything"
                        ) {
                            $(
                                ".media-management-actions .btn.js-media-management-change-filter-group.js-filter-by-type"
                            ).hide();
                        }

                        ContextMenuService.destroyContext();
                        ContextMenuService.initContext();
                    }
                );
            } else {
                $(document)
                    .find(
                        ".media-management-container .js-change-action[data-type=refresh]"
                    )
                    .trigger("click");
            }
        };

        if (typeof selector === "string") {
            $body.off("click", selector).on("click", selector, clickCallback);
        } else {
            selector.off("click").on("click", clickCallback);
        }
    }
}

window.MediaManagementStandAlone = mediaManagement;

$(".js-insert-to-editor")
    .off("click")
    .on("click", function (event) {
        event.preventDefault();
        let selectedFiles = Helpers.getSelectedFiles();
        if (_.size(selectedFiles) > 0) {
            EditorService.editorSelectFile(selectedFiles);
        }
    });

$.fn.mediaManagement = function (options) {
    let $selector = $(this);

    MediaConfig.request_params.filter = "everything";
    $(document)
        .find(".js-insert-to-editor")
        .prop("disabled", MediaConfig.request_params.view_in === "trash");
    Helpers.storeConfig();

    new mediaManagement($selector, options);
};
