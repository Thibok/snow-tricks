$(function () {
    var containerImages = $('#trickImages');
    var imagesInputs = containerImages.children(':input');
    var length = imagesInputs.length;

    imagesInputs.each(function () {
        $('#test').after($(this).next('span'));
    });

    function addTrickImage(containerImg) {
        var prototype = containerImg.attr('data-prototype').replace(/__name__/g, length);
        var fileField = $(prototype);
        var numberOfField = fileField.attr('id').split('_');

        fileField.hide();
        containerImg.append(fileField);
        length++;
        $('#addMedia').addClass('mt-3');
        createTrickImagePreview(numberOfField[3]);
        fileField.trigger('click');
    }

    function createTrickImagePreview (numberOfField) {
        var previewImg = $('<img class="card-img-top px-2" src="../img/preview_trick_thumb.png" alt="preview_mini"/>');
        previewImg.css('width', '200px').css('height', '100px');
        $('#medias').slick('slickAdd', previewImg);
    }

    $('#medias').slick({
        infinite: false,
        arrows: true,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
            {
              breakpoint: 1300,
              settings: {
                slidesToShow: 4
              }
            },
        ]
    });

    $('input[type=file]').click(function () {

    })

    $('#addTrickImage').click(function (e) {
        e.preventDefault()
        addTrickImage(containerImages);

        return false;
    });
    
});