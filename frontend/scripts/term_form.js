jQuery(function () {
    const imageInput = jQuery("#appful_term_image");
    const imageView = jQuery("#appful_term_image_view");
    const uploadButton = jQuery("#appful_term_image_upload_button");
    const removeButton = jQuery("#appful_term_image_remove_button");

    if (imageInput.val() && imageInput.val().length > 0) {
        uploadButton.hide();
        imageView.show();
        removeButton.show();
    } else {
        uploadButton.show();
        imageView.hide();
        removeButton.hide();
    }

    reset_image_input();
});

function reset_image_input() {
    jQuery(document).ajaxSuccess(function (e, request, settings) {
        const params = new URLSearchParams(settings.data);
        if (params.get("action") === "add-tag") {
            removeImage();
        }
    });
}

function chooseImage() {
    const imageInput = jQuery("#appful_term_image");
    const imageView = jQuery("#appful_term_image_view");
    const uploadButton = jQuery("#appful_term_image_upload_button");
    const removeButton = jQuery("#appful_term_image_remove_button");

    const custom_uploader = wp.media({
        title: "Add term image",
        library: {
            type: "image"
        },
        button: {
            text: "Use this image"
        },
        multiple: false
    });

    custom_uploader.on("select", function () {
        const attachment = custom_uploader.state().get("selection").first().toJSON();

        imageInput.val(attachment.id);
        imageView.attr("src", attachment.url);

        uploadButton.hide();
        removeButton.show();
        imageView.show();
    });

    custom_uploader.on("open", function () {
        const imageId = imageInput.val();
        if (imageId) {
            const attachment = wp.media.attachment(imageId);
            attachment.fetch();

            const selection = custom_uploader.state().get('selection')
            selection.add(attachment ? [attachment] : []);
        }
    });

    custom_uploader.open()
}

function removeImage() {
    const imageInput = jQuery("#appful_term_image");
    const imageView = jQuery("#appful_term_image_view");
    const uploadButton = jQuery("#appful_term_image_upload_button");
    const removeButton = jQuery("#appful_term_image_remove_button");

    uploadButton.show();
    removeButton.hide();
    imageView.hide();

    imageInput.val("");
    imageView.attr("src", "");
}
