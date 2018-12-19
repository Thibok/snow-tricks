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
        var idSplit = fileField.attr('id').split('_');

        fileField.hide();
        containerImg.append(fileField);
        createTrickImagePreview();
        length++;
        fileField.trigger('click');
    }

    $('#medias').slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 5,
        variableWidth: true,
        responsive: [
            {
              breakpoint: 1900,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
              }
            },
            {
              breakpoint: 1555,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3
              }
            },
            {
                breakpoint: 1210,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                }
            },
            {
              breakpoint: 510,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
    });

    function createTrickImagePreview () {
        var previewImg = $('<img class="border-black" id="trickImg-sm-' + length + '"src="../img/preview_trick_thumb.jpg" alt="preview_mini"/>');
        previewImg.css('width', '170px').css('height', '100px');
        previewImgContainer = addControlImg(previewImg);

        $('#medias').slick('slickAdd', previewImgContainer);
    }

    function addControlImg (trickImagePreview) {
        var previewImgContainer = $('<div class="d-flex flex-column"></div>');
        var controlsContainer = $('<div class="d-flex flex-row justify-content-around py-1 mt-2 border-black"></div>')
        controlsContainer.css('background-color', 'white').css('width', '90px').css('height', '25px').css('margin-left', '80px');
        var editImg = $('<img class="px-2" src="../img/edit.png"/>');
        var deleteImg = $('<img class="px-2" src="../img/delete.png"/>');

        controlsContainer.append(editImg);
        controlsContainer.append(deleteImg);

        previewImgContainer.append(trickImagePreview);
        previewImgContainer.append(controlsContainer);

        return previewImgContainer;
    }

    $('input[type=file]').click(function () {

    })

    $('#addTrickImage').click(function (e) {
        e.preventDefault()
        addTrickImage(containerImages);

        return false;
    });
    
});