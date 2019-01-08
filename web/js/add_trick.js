$(function () {
    const previewThumbPath = '/img/preview_trick_thumb.jpg';
    const previewLargePath = '/img/preview_trick.jpg';
    const editIconPath = '/img/edit.png';
    const deleteIconPath = '/img/delete.png';
    const nextEnabledPath = '/img/next.png';
    const prevEnabledPath = '/img/prev.png';
    const nextDisableddPath = '/img/next_disabled.png';
    const prevDisabledPath = '/img/prev_disabled.png';
    const iframeRegex = new RegExp('^<iframe .*><\/iframe>$');
    const videoUrlSrcRegex = /src\s*=\s*"(.+?)"/;
    const videoUrlRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/embed\/[a-zA-Z0-9\?\=\&_-]{1,2053}|'
    + 'www\.dailymotion\.com\/embed\/video\/[a-zA-Z0-9\?\=\&_-]{1,2043}|player\.vimeo\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2052})$');
    const videoUrlMaxLength = 2083;
    const minLengthMessage = "must be at least";
    const maxLengthMessage = "must be at most";

    function readURL(input) {
        if (input.files && input.files[0]) {
          let reader = new FileReader();

          reader.onload = function(e) {
            let idSplit = $(input).attr('id').split('_');
            $('#trick-img-thumb-' + idSplit[3]).attr('src', e.target.result);
          }
      
          reader.readAsDataURL(input.files[0]);
        }
    }

    function loadDefaultThumbImgPreview (input) {
        let idSplit = input.attr('id').split('_');
        $('#trick-img-thumb-' + idSplit[3]).attr('src', previewThumbPath);
    }

    function createImageEl() {
        var previewImgContainer = $('<div id="img-container-' + imagesLength + '" class="d-inline-block mt-1 mb-5 media"></div>');
        var previewImg = $('<img class="border-black" id="trick-img-thumb-' + imagesLength + '"src="'+ previewThumbPath +'" alt="preview_mini"/>');

        var controlsEl = createControlsImage();

        previewImgContainer.append(previewImg);
        previewImgContainer.append(controlsEl);

        return previewImgContainer;
    }

    function createControlsImage() {
        let controlsContainer = $('<div class="d-flex justify-content-around mt-2 border-black controls-container"></div>');

        let editImg = $('<img src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-img-' + imagesLength + '" class="edit-control" href="#"></a>');
        let deleteLink = $('<a id="delete-img-' + imagesLength + '" class="delete-control" href="#"></a>');

        editLink.append(editImg);
        deleteLink.append(deleteImg);
        
        let numberOfImg = $('<span class="compteur" id="img-number-' + imagesLength + '"></span>');
        numberOfImg.css('margin-top', '2px');
        numberOfImg.text(imagesLength + 1);

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
            totalMedias--;

            refreshPagination();

            if (getNbOfMediaActualPage() === 0) {
                if (canPrev()) {
                    pagePrevious();
                }
            }
    
            return false;
        });

        controlsContainer.append(numberOfImg);
        controlsContainer.append(editLink);
        controlsContainer.append(deleteLink);

        return controlsContainer;
    }

    function createInputImageFile() {
        let prototype = containerImages.attr('data-prototype').replace(/__name__/g, imagesLength);
        let fileField = $(prototype);

        fileField.change(function () {
            if ($(this).val().length !== 0) {
                readURL(this);
            } else {
                loadDefaultThumbImgPreview($(this));
            }
        });

        return fileField;
    }

    function uploadImage() {
        // Get html prototype 
        let inputFile = createInputImageFile();
        inputFile.hide();
        containerImages.append(inputFile);

        let imagePreview = createImageEl();

        if (getNbOfMediaActualPage() < getMediaPerPage()) {
            imagePreview.addClass('reveal-media');
        } else {
            imagePreview.removeClass('d-inline-block');
            imagePreview.hide();
        }        

        $('#medias_container').append(imagePreview);
        
        imagesLength++;
        totalMedias++;

        showPagination();

        inputFile.trigger('click');
    }

    function deleteTrickImage(imageId) {
        $('#img-container-' + imageId).remove();
        $('#appbundle_trick_images_' + imageId +'_file').remove();
    }

    function createInputVideoUrl() {
        let prototype = containerVideos.attr('data-prototype').replace(/__name__/g, videosLength);
        let urlField = $(prototype);

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
        let videoContainerEl = $('<div id="video-container-' + videosLength + '" class="d-inline-block mt-1 mb-5 media video"></div>');
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

        let modalEditContainer = $('<div class="modalContainer"></div>');
        let modalEditTitle = '<h6 id="editModalTitle">Edit video - ' + videoId + '</h6>';
        let labelModalEditUrl = $('<label class="control-label required" for="iframeEditVideo">Iframe</label>');
        let textareaModalEditUrl = $('<textarea id="iframeEditVideo" required="required" class="form-control"></textarea>');
        textareaModalEditUrl.val(iframeEl);
        let errorModalEditUrl = $('<span class="invalid-feedback d-block" id="iframe_edit_error"></span>');

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
        let modalContainer = $('<div class="modalContainer"></div>');
        let labelModalUrl = $('<label class="control-label required" for="iframeVideo">Iframe</label>');
        let textareaModalUrl = $('<textarea id="iframeVideo" required="required" class="form-control"></textarea>')
        let errorModalUrl = $('<span class="invalid-feedback d-block" id="iframe_error"></span>');

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

        let editLink = $('<a id="edit-video-' + videosLength + '" class="edit-control px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-video-' + videosLength + '" class="delete-control px-1" href="#"></a>');

        let numberOfVideos = $('<span class="compteur px-1" id="img-number-' + videosLength + '"></span>');
        numberOfVideos.css('margin-top', '2px');
        numberOfVideos.text(videosLength + 1);

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
            totalMedias--;

            refreshPagination();

            if (getNbOfMediaActualPage() === 0) {
                if (canPrev()) {
                    pagePrevious();
                }
            }
    
            return false;
        });

        editLink.append(editImg);
        deleteLink.append(deleteImg);

        controlsContainer.append(numberOfVideos);
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

        if (getNbOfMediaActualPage() < getMediaPerPage()) {
            videoEl.addClass('reveal-media');
        } else {
            videoEl.removeClass('d-inline-block');
            videoEl.hide();
        }   

        containerVideos.append(urlField);
        $('#medias_container').append(videoEl);

        urlField.change();
        videosLength++;
        totalMedias++;

        showPagination();
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

    function getTotalMedias() {
        return $('.media').length;
    }

    function getMediaPerPage() {
        if (window.innerWidth < 1609 && window.innerWidth > 1299 || window.innerWidth < 992  && window.innerWidth > 944) {
            return 4;
        }

        if (window.innerWidth < 1300 && window.innerWidth > 1154 || window.innerWidth < 945  && window.innerWidth > 815) {
            return 3;
        }

        if (window.innerWidth < 1155 && window.innerWidth > 991 || window.innerWidth < 816  && window.innerWidth > 590) {
            return 2;
        }

        if (window.innerWidth < 591){
            return 1;
        }

        return 5;
    }

    function getTotalPages() {
        var totalPages = Math.ceil(totalMedias / mediaPerPage);

        if (totalPages === 0) {
            return 1;
        }

        return totalPages;
    }

    function showPagination() {
        if (getTotalMedias() <= getMediaPerPage()) {
            disableNext();
            disablePrev();
            $('#pagination').hide();
            return;
        }

        if (getTotalMedias() > getMediaPerPage()) {
            $('#pagination').show();

            if (canNext()) {
                enableNext();
            } else {
                disableNext();
            }

            if (canPrev()) {
                enablePrev();
            } else {
                disablePrev();
            }

            return;
        }
    }

    function canPrev() {
        if (actualPage > 1) {
            return true;
        }

        return false;
    }

    function canNext() {
        if (actualPage < getTotalPages()) {
            return true;
        }

        return false;
    }

    function pageNext() {
        $('.reveal-media').each(function () {
            $(this).removeClass('reveal-media d-inline-block');
            $(this).hide();
        })

        actualPage++;

        if (!canNext()) {
            disableNext();
        } else {
            enableNext();
        }

        if (!canPrev()) {
            disablePrev();
        } else {
            enablePrev();
        }

        if (mediaPerPage === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            return;
        }

        var lastPos = actualPage * mediaPerPage;
        var firstPos = lastPos - mediaPerPage;

        while(firstPos < lastPos) {
            $('.media').eq(firstPos).addClass('reveal-media d-inline-block').show();
            firstPos++;
        }

        return;      
    }

    function pagePrevious() {
        $('.reveal-media').each(function () {
            $(this).removeClass('reveal-media d-inline-block');
            $(this).hide();
        })

        actualPage--;

        if (!canNext()) {
            disableNext();
        } else {
            enableNext();
        }

        if (!canPrev()) {
            disablePrev();
        } else {
            enablePrev();
        }

        if (mediaPerPage === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            return;
        }

        var lastPos = actualPage * mediaPerPage;
        var firstPos = lastPos - mediaPerPage;

        while(firstPos < lastPos) {
            $('.media').eq(firstPos).addClass('reveal-media d-inline-block').show();
            firstPos++;
        }

        return;
    }

    function refreshPagination() {
        $('.reveal-media').each(function () {
            $(this).removeClass('reveal-media d-inline-block');
            $(this).hide();
        })

        if (mediaPerPage === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            return;
        }

        var lastPos = actualPage * mediaPerPage;
        var firstPos = lastPos - mediaPerPage;

        while(firstPos < lastPos) {
            $('.media').eq(firstPos).addClass('reveal-media d-inline-block').show();
            firstPos++;
        }

        showPagination();

        return;
    }

    function disableNext() {
        $('#next').removeAttr('href');
        $('#next img').attr('src', nextDisableddPath);
        return;
    }

    function disablePrev() {
        $('#previous').removeAttr('href');
        $('#previous img').attr('src', prevDisabledPath);
        return;
    }

    function enableNext() {
        $('#next').attr('href', '#');
        $('#next img').attr('src', nextEnabledPath);
        return;
    }

    function enablePrev() {
        $('#previous').attr('href', '#');
        $('#previous img').attr('src', prevEnabledPath);
        return;
    }

    function getNbOfMediaActualPage() {
        return $('.reveal-media').length;
    }

    $('#addTrickImage').click(function (e) {
        e.preventDefault();
        uploadImage();

        return false;
    });

    $('#addTrickVideo').click(function (e) {
        e.preventDefault();
        clearModal()
        addVideoModal.open();
        return false;
    });

    $('#next').click(function (e) {
        e.preventDefault();

        if (canNext()) {
            pageNext();

            return false;
        }

        return false;
    });

    $('#previous').click(function (e) {
        e.preventDefault();

        if (canPrev()) {
            pagePrevious();

            return false;
        }

        return false;
    });

    var actualPage = 1;
    var totalMedias = getTotalMedias();
    var mediaPerPage = getMediaPerPage();
    var totalPages = getTotalPages();

    showPagination();

    var containerImages = $('#trickImages');
    var imagesInputs = containerImages.children(':input');
    var imagesLength= imagesInputs.length;

    var containerVideos = $('#trickVideos');
    var videosInputs = containerVideos.children(':input');
    var videosLength = videosInputs.length;

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
});