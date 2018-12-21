$(function () {
    const previewThumbPath = '../img/preview_trick_thumb.jpg';
    const previewLargePath = '../img/preview_trick.jpg';
    const editIconPath = '../img/edit.png';
    const deleteIconPath = '../img/delete.png';

    function addTrickImage(containerImg) {
        // Get html prototype 
        var prototype = containerImg.attr('data-prototype').replace(/__name__/g, length);
        var fileField = $(prototype);

        fileField.change(function () {
            if ($(this).val().length !== 0) {
                readURL(this);
            } else {
                loadDefaultThumbImgPreview($(this));
            }
        });

        fileField.hide();
        containerImg.append(fileField);
        createThumbImagePreview();
        length++;
        fileField.trigger('click');
    }

    function deleteTrickImage(idNumber) {
        let slider = $('#medias');
        slider.slick('slickRemove', $('#img-container-' + idNumber));
        slider.slick('refresh');
        $('#img-container-' + idNumber).remove();
        $('#appbundle_trick_images_' + idNumber +'_file').remove();
    }

    function createThumbImagePreview () {
        let previewImg = $('<img class="border-black" id="trickImg-sm-' + length + '"src="'+ previewThumbPath +'" alt="preview_mini"/>');
        previewImg.css('width', '170px').css('height', '100px');
        previewImgContainer = addControlThumbImgPreview(previewImg);

        $('#medias').slick('slickAdd', previewImgContainer);
    }

    function addControlThumbImgPreview (trickImagePreview) {
        let previewImgContainer = $('<div id="img-container-' + length + '" class="d-flex flex-column"></div>');
        let controlsContainer = $('<div class="d-flex flex-row justify-content-around py-1 mt-2 border-black"></div>')
        controlsContainer.css('background-color', 'white').css('width', '90px').css('height', '25px').css('margin-left', '80px');
        let editImg = $('<a id="edit-img-' + length + '" class="px-1 media-img" href="#"><img src="' + editIconPath + '"/></a>');
        let deleteImg = $('<a id="delete-img-' + length + '" class="px-1" href="#"><img src="' + deleteIconPath + '"/></a>');

        $(editImg).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            $('#appbundle_trick_images_' + idSplit[2] +'_file').trigger('click');
    
            return false;
        });

        $(deleteImg).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            deleteTrickImage(idSplit[2]);
    
            return false;
        });

        controlsContainer.append(editImg);
        controlsContainer.append(deleteImg);

        previewImgContainer.append(trickImagePreview);
        previewImgContainer.append(controlsContainer);

        return previewImgContainer;
    }

    function readURL(input) {

        if (input.files && input.files[0]) {
          let reader = new FileReader();

          reader.onload = function(e) {
            let idSplit = $(input).attr('id').split('_');
            $('#trickImg-sm-' + idSplit[3]).attr('src', e.target.result);
          }
      
          reader.readAsDataURL(input.files[0]);
        }
    }

    function loadDefaultThumbImgPreview (input) {
        let idSplit = input.attr('id').split('_');
        $('#trickImg-sm-' + idSplit[3]).attr('src', previewThumbPath);
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
        ]
    });

    var containerImages = $('#trickImages');
    var imagesInputs = containerImages.children(':input');
    var length = imagesInputs.length;

    $('#addTrickImage').click(function (e) {
        e.preventDefault();
        addTrickImage(containerImages);

        return false;
    });
});