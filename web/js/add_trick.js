$(function () {
    const previewThumbPath = '/img/preview_trick_thumb.jpg';
    const previewLargePath = '/img/preview_trick.jpg';
    const editIconPath = '/img/edit.png';
    const deleteIconPath = '/img/delete.png';
    const iframeRegex = new RegExp('^<iframe .*><\/iframe>$');
    const videoUrlSrcRegex = /src\s*=\s*"(.+?)"/;
    const videoUrlRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/embed\/[a-zA-Z0-9\?\=\&_-]{1,2053}|www\.dailymotion\.com\/embed\/video\/[a-zA-Z0-9\?\=\&_-]{1,2043}|player\.vimeo\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2052})$');
    const videoUrlMaxLength = 2083;
    const minLengthMessage = "must be at least";
    const maxLengthMessage = "must be at most";

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

        let editImg = $('<img src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-img-' + length + '" class="edit-control px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-img-' + length + '" class="delete-control px-1" href="#"></a>');

        editLink.append(editImg);
        deleteLink.append(deleteImg);
        
        let numberOfImg = $('<span class="compteur px-1" id="img-number-' + length + '"></span>');
        numberOfImg.css('margin-top', '2px');
        numberOfImg.text(length);

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

        controlsContainer.append(numberOfImg);
        controlsContainer.append(editLink);
        controlsContainer.append(deleteLink);

       
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

        urlField.change(function () {
            let idSplit = $(this).attr('id').split('_');
            validateVideoUrl($(this).val(), $('#media_error'), idSplit[3]);
        });

        return urlField;
    }

    function createVideoIframe (videoSrc) {
        let iframeVideoEl = '<iframe class="align-middle" width=100% height=100% ' + videoSrc + ' frameborder="0" allow="fullscreen"></iframe>';

        return iframeVideoEl;
    }

    function createVideoEl (videoSrc) {
        let videoContainerEl = $('<div id="video-container-' + length + '" class="d-inline-block mt-1 mb-5 media video"></div>');
        videoContainerEl.css('height', '100px');
        let videoIframeEl = createVideoIframe(videoSrc);
        let controlsEl = createControlsVideo();

        videoContainerEl.append($(videoIframeEl));
        videoContainerEl.append(controlsEl);

        return videoContainerEl;
    }

    function createEditVideoModal(videoId) {
        let url = $('#appbundle_trick_videos_' + videoId +'_url').val();
        let src = 'src="' + url + '"';
        let iframeEl = createVideoIframe(src);

        var modalEditContainer = $('<div class="modalContainer"></div>');
        var modalEditTitle = '<h6 id="editModalTitle">Edit video - ' + videoId + '</h6>';
        var labelModalEditUrl = $('<label class="control-label required" for="iframeEditVideo">Iframe</label>');
        var textareaModalEditUrl = $('<textarea id="iframeEditVideo" required="required" class="form-control"></textarea>');
        textareaModalEditUrl.val(iframeEl);
        var errorModalEditUrl = $('<span class="invalid-feedback d-block" id="iframe_edit_error"></span>');

        textareaModalEditUrl.on('keyup blur', function () {
            validateIframe($(this).val(), $('#iframe_edit_error'));
        });

        modalEditContainer.append(labelModalEditUrl);
        modalEditContainer.append(textareaModalEditUrl);
        modalEditContainer.append(errorModalEditUrl);

        editVideoModal.setTitle(modalEditTitle);
        editVideoModal.setContent(modalEditContainer);

        return editVideoModal;
    }

    function createAddVideoModalContent() {
        var modalContainer = $('<div class="modalContainer"></div>');
        var labelModalUrl = $('<label class="control-label required" for="iframeVideo">Iframe</label>');
        var textareaModalUrl = $('<textarea id="iframeVideo" required="required" class="form-control"></textarea>')
        var errorModalUrl = $('<span class="invalid-feedback d-block" id="iframe_error"></span>');

        textareaModalUrl.on('keyup blur', function () {
            validateIframe($(this).val(), $('#iframe_error'));
        });

        modalContainer.append(labelModalUrl);
        modalContainer.append(textareaModalUrl);
        modalContainer.append(errorModalUrl);

        return modalContainer;
    }

    function createControlsVideo () {
        let controlsContainer = $('<div class="d-flex flex-row justify-content-around mt-2 border-black controls-container"></div>');
        
        let editImg = $('<img src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-video-' + length + '" class="edit-control px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-video-' + length + '" class="delete-control px-1" href="#"></a>');

        $(editLink).click(function (e) {
            e.preventDefault();
            let idSplit = $(this).attr('id').split('-');
            let editModal = createEditVideoModal(idSplit[2]);
            editModal.open();
        });

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

    function validateIframe(iframe, errorTarget) {
        if (!iframeRegex.test(iframe)) {
            errorTarget.text('Please enter a valid iframe tag');
            return false;
        }

        let src = videoUrlSrcRegex.exec(iframe);

        if (src === null) {
            errorTarget.text('The iframe tag must contain a valid src link');
            return false;
        }

        let url = src[0].split('"');

        if (!validateVideoUrl(url[1], errorTarget, null)) {
            return false;
        }

        errorTarget.text('');
        return true;
    }

    function validateVideoUrl(url, errorTarget, videoId) {
        if (url.length === 0) {
            let errorMsg = 'Url of the video can not be empty !';

            if (videoId !== null) {
                errorMsg = 'Video ' + videoId + ' : ' + errorMsg;
            }

            errorTarget.text(errorMsg);
            return false;
        }

        if (url.length > videoUrlMaxLength) {
            let errorMsg = 'Url of the video ' + maxLengthMessage + ' ' + videoUrlMaxLength + ' characters !'

            if (videoId !== null) {
                errorMsg = 'Video ' + videoId + ' : ' + errorMsg;
            }

            errorTarget.text(errorMsg);
            return false;
        }

        if (!videoUrlRegex.test(url)) {
            let errorMsg = 'The integration tag must come from Youtube, Dailymotion or Vimeo';

            if (videoId !== null) {
                errorMsg = 'Video ' + videoId + ' : ' + errorMsg;
            }

            errorTarget.text(errorMsg);
            return false;
        }

        $(errorTarget).text('');
        return true;
    }

    function uploadVideo() {
        let iframeVideo  = $('#iframeVideo').val();

        if (!validateIframe(iframeVideo, $('#iframe_error'))) {
            return false;
        }

        let src = videoUrlSrcRegex.exec(iframeVideo);

        let videoEl = createVideoEl(src[0]);
        let urlField = createInputVideoUrl();

        let url = src[0].split('"');

        urlField.val(url[1]);
        urlField.hide();

        containerVideos.append(urlField);
        $('#medias_container').append(videoEl);

        urlField.change();
        length++;
    }

    function editVideo() {
        let iframeVideo  = $('#iframeEditVideo').val();
        let titleSplit = $('#editModalTitle').text().split(' ');

        if (!validateIframe(iframeVideo, $('#iframe_edit_error'))) {
            return false;
        }

        let src = videoUrlSrcRegex.exec(iframeVideo);
        let url = src[0].split('"');

        let videoIframePreview = $('#video-container-' + titleSplit[3] + ' iframe');
        videoIframePreview.attr('src', url[1]);

        let videoUrlInput = $('#appbundle_trick_videos_' + titleSplit[3] + '_url');
        videoUrlInput.val(url[1]);

        videoUrlInput.change();
    }

    function clearModal() {
        $('#iframeVideo').val('');
        $('#iframe_error').text('');
    }

    var addVideoModalContent = createAddVideoModalContent();

    var addVideoModal = new jBox('Confirm', {
        title: 'Add a video',
        content: addVideoModalContent,
        cancelButton: 'Cancel',
        confirmButton: 'Upload',
        confirm: uploadVideo,
        cancel: clearModal,
    });

    var editVideoModal = new jBox('Confirm', {
        cancelButton: 'Cancel',
        confirmButton: 'Edit',
        confirm: editVideo,
    });

    $('#addTrickVideo').click(function (e) {
        e.preventDefault();
        clearModal()
        addVideoModal.open();
        return false;
    });
});