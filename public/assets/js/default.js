(function($) {
    //alert(0);
    // Datepicker
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy"
    });
})(jQuery);

// Categories
(function($) {
    $('button[data-action="category-remove"]').click(function() {
        var category_id = $(this).attr('data-id');
        bootbox.confirm("Are you sure you want to remove selected category?", function (result) {
            if(result) {
                $.getJSON(settings.base_href + '/categories/json/remove/' + category_id, {}, function () {
                    window.location.href = settings.base_href + '/categories';
                });
            }
        });
    });

})(jQuery);

// Photo/Create
(function($) {
    $('#page-photos-create input[type="file"]').fileupload({
        dataType: 'json',
        add: function(e, data) {
            var max = 5000000;
            var fileSize = data.originalFiles[0].size;

            if(fileSize > max) {
                bootbox.alert('Sorry but selected file is too big!');
            } else {
                data.submit();
            }
        },
        done: function (e, data) {
            if (data.result.status === 'ok') {
                $('#page-photos-create .image').addClass('has-image');
                $('#page-photos-create .image-preview').html('<img src="' + settings.base_href + '/upload/temporary/' + data.result.filename + '" alt="">');
                $('#page-photos-create input[name="temporary-image"]').val(data.result.filename);

                // Exif data
                $('#page-photos-create input[name="exif_make"]').val(data.result.exif.make);
                $('#page-photos-create input[name="exif_model"]').val(data.result.exif.model);
                $('#page-photos-create input[name="exif_aperture"]').val(data.result.exif.aperture);
                $('#page-photos-create input[name="exif_iso"]').val(data.result.exif.iso);
                $('#page-photos-create input[name="exif_speed"]').val(data.result.exif.speed);


                if(data.result.exif.coords) {
                    $('#page-photos-create input[name="exif_lat"]').val(data.result.exif.coords.latitude);
                    $('#page-photos-create input[name="exif_lng"]').val(data.result.exif.coords.longitude);
                } else {
                    $('#page-photos-create input[name="exif_lat"]').val('');
                    $('#page-photos-create input[name="exif_lng"]').val('');
                }
            }
        }
    });
})(jQuery);

// Photo/Edit
(function($) {
    var page = $('#page-photos-edit');
    page.find('input[type="file"]').fileupload({
        dataType: 'json',
        type: 'post',
        add: function(e, data) {
            var max = 5000000;
            var fileSize = data.originalFiles[0].size;

            if(fileSize > max) {
                bootbox.alert('Sorry but selected file is too big!');
            } else {
                data.submit();
            }
        },
        done: function (e, data) {
            if (data.result.status === 'ok') {
                page.find('.image').addClass('has-image');
                page.find('.image-preview').html('<img src="' + settings.base_href + '/upload/temporary/' + data.result.filename + '" alt="">');
                page.find('input[name="temporary-image"]').val(data.result.filename);

                // Exif data
                page.find('input[name="exif_make"]').val(data.result.exif.make);
                page.find('input[name="exif_model"]').val(data.result.exif.model);
                page.find('input[name="exif_aperture"]').val(data.result.exif.aperture);
                page.find('input[name="exif_iso"]').val(data.result.exif.iso);
                page.find('input[name="exif_speed"]').val(data.result.exif.speed);

                if(data.result.exif.coords) {
                    page.find('input[name="exif_lat"]').val(data.result.exif.coords.latitude);
                    page.find('input[name="exif_lng"]').val(data.result.exif.coords.longitude);
                } else {
                    page.find('input[name="exif_lat"]').val('');
                    page.find('input[name="exif_lng"]').val('');
                }
            }
        }
    });
})(jQuery);

// Photos/Categories
(function($) {
    function checkForExistingItems()
    {
        if(!$('#page-photos-category .photo-container').length) {
            $('#page-photos-category .category-empty').removeClass('d-none');
        }
    }

    $('#page-photos-category a[data-action="remove"]').click(function(){
        var $photoContainer = $(this).closest('.photo-container');
        var photo_id = $(this).parent().attr('data-id');

        $.getJSON(settings.base_href + '/photos/json/remove/' + photo_id,function(response){
            if(response.status === 'ok') {
                $photoContainer.fadeOut(200, function(){
                   $(this).remove();
                    checkForExistingItems();
                });
            }
        });

        return false;
    });
})(jQuery);
