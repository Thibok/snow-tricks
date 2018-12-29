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
        $('#img-container-' + idNumber).remove();
        $('#appbundle_trick_images_' + idNumber +'_file').remove();
    }

    function createThumbImagePreview () {
        let previewImg = $('<img class="border-black" id="trickImg-sm-' + length + '"src="'+ previewThumbPath +'" alt="preview_mini"/>');
        previewImgContainer = addControlThumbImgPreview(previewImg);
        $('#medias_container').append(previewImgContainer);
    }

    function addControlThumbImgPreview (trickImagePreview) {
        let previewImgContainer = $('<div id="img-container-' + length + '" class="d-inline-block mt-1 mb-5 media"></div>');
        let controlsContainer = $('<div class="d-flex flex-row justify-content-around mt-2 border-black controls-container"></div>');

        let editImg = $('<img class="test" src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img class="test" src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-img-' + length + '" class="edit-control px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-img-' + length + '" class="delete-control px-1" href="#"></a>');

        editLink.append(editImg);
        deleteLink.append(deleteImg);
        
        let numberOfImg = $('<span class="compteur" id="img-number-' + length + '"></span>');
        numberOfImg.text(length).css('position', 'absolute').css('top', '78px').css('right', '8px');

        $(editLink).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            $('#appbundle_trick_images_' + idSplit[2] +'_file').trigger('click');
    
            return false;
        });

        $(deleteLink).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            deleteTrickImage(idSplit[2]);
    
            return false;
        });

        controlsContainer.append(editLink);
        controlsContainer.append(deleteLink);

        previewImgContainer.append(numberOfImg);
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

    var containerImages = $('#trickImages');
    var imagesInputs = containerImages.children(':input');
    var length = imagesInputs.length;

    $('#addTrickImage').click(function (e) {
        e.preventDefault();
        addTrickImage(containerImages);

        return false;
    });
});