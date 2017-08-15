Plupload = {
    init: function () {
        var self = this;
        $('.plupload').each(function () {
            self.initPlupload($(this));
        });

    },

    initPlupload: function (elem) {
        var form = elem.closest('form');
        var params = {};
        params[yii.getCsrfParam()] = yii.getCsrfToken();

        var uploader = elem.pluploadQueue({
            // General settings
            runtimes: 'html5,gears,flash,silverlight',

            url: form.attr('action'),

            unique_names: true,

            filters: [
                {title: "Image files", extensions: "jpg,jpeg,png"}
            ],

            multipart_params: params,

            max_file_size: elem.data('max-file-size'),
            max_file_count: 20,
            chunk_size: '1mb',

            // Resize images on clientside if we can
            resize : {
                width: 200,
                height: 200,
                quality: 90,
                crop: true // crop to exact dimensions
            },

            // Rename files by clicking on their titles
            rename: true,

            // Sort files
            sortable: true,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,

            // Views to activate
            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },

            flash_swf_url: elem.data('moxie-swf'),
            silverlight_xap_url: elem.data('moxie-xap')
        });

        uploader.pluploadQueue().bind('UploadComplete', function () {
            form.submit();
        });
    }
};