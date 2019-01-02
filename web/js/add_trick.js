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

    var containerVideos = $('#trickVideos');
    var videosInputs = containerVideos.children(':input');
    var videosLength = videosInputs.length;

    $('#addTrickImage').click(function (e) {
        e.preventDefault();
        addTrickImage(containerImages);

        return false;
    });

    function createInputVideoUrl () {
        var prototype = containerVideos.attr('data-prototype').replace(/__name__/g, length);
        var urlField = $(prototype);

        return urlField;
    }

    function createVideoIframe (videoSrc) {
        let iframeVideoEl = $(
            '<iframe class="align-middle" width=100% height=100% ' + videoSrc + ' frameborder="0" allow="fullscreen"></iframe>'
        );

        return iframeVideoEl;
    }

    function createVideoEl (videoSrc) {
        let videoContainerEl = $('<div id="video-container-' + length + '" class="d-inline-block mt-1 mb-5 media video"></div>');
        videoContainerEl.css('height', '100px');
        let videoIframeEl = createVideoIframe(videoSrc);
        let controlsEl = createControlsVideo();

        videoContainerEl.append(videoIframeEl);
        videoContainerEl.append(controlsEl);

        return videoContainerEl;
    }

    function createControlsVideo () {
        let controlsContainer = $('<div class="d-flex flex-row justify-content-around mt-2 border-black controls-container"></div>');
        
        let editImg = $('<img src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-video-' + length + '" class="edit-control px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-video-' + length + '" class="delete-control px-1" href="#"></a>');

        $(deleteLink).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            deleteTrickVideo(idSplit[2]);
    
            return false;
        });

        editLink.append(editImg);
        deleteLink.append(deleteImg);

        controlsContainer.append(editLink);
        controlsContainer.append(deleteLink);

        return controlsContainer;
    }

    function deleteTrickVideo(idNumber) {
        $('#video-container-' + idNumber).remove();
        $('#appbundle_trick_videos_' + idNumber +'_url').remove();
    }

    function uploadVideo() {
        let iframeVideo  = $('#iframeVideo').val();

        let regex = /src\s*=\s*"(.+?)"/;
        let src = regex.exec(iframeVideo);

        let videoEl = createVideoEl(src[0]);
        let urlField = createInputVideoUrl();

        let url = src[0].split('"');

        urlField.val(url[1]);
        urlField.hide();

        containerVideos.append(urlField);
        $('#medias_container').append(videoEl);
        length++;
    }

    var addVideoModal = new jBox('Confirm', {
        title: 'Add a video',
        content: '<label class="control-label required" for="iframeVideo">Iframe</label><textarea id="iframeVideo" required="required" class="form-control"></textarea>',
        cancelButton: 'Cancel',
        confirmButton: 'Upload',
        confirm: uploadVideo,
    });

    $('#addTrickVideo').click(function (e) {
        e.preventDefault();
        $('#iframeVideo').val('');
        addVideoModal.open();
        return false;
    });
});