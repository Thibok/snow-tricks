$(function () {
    const previewThumbPath = '/img/preview_trick_thumb.jpg';
    const previewLargePath = '/img/preview_trick.jpg';
    const editIconPath = '/img/edit.png';
    const deleteIconPath = '/img/delete.png';
    const nextEnabledPath = '/img/next.png';
    const prevEnabledPath = '/img/prev.png';
    const nextDisableddPath = '/img/next_disabled.png';
    const prevDisabledPath = '/img/prev_disabled.png';
    const youtubeEmbedFormat = 'https://www.youtube.com/embed/';
    const dailymotionEmbedFormat = 'https://www.dailymotion.com/embed/video/';
    const vimeoEmbedFormat = 'https://player.vimeo.com/video/';
    const iframeRegex = new RegExp('^<iframe .*><\/iframe>$');
    const videoUrlSrcRegex = /src\s*=\s*"(.+?)"/;
    const urlRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/embed\/[a-zA-Z0-9\?\=\&_-]{1,2053}|www\.dailymotion\.com\/embed\/video\/[a-zA-Z0-9\?\=\&_-]{1,2043}|player\.vimeo\.com\/video\/[a-zA-Z0-9\?\=\#\&_-]{1,2052}|youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066}|www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051}|www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049}|dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068}|vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$');
    const urlEmbedRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/embed\/[a-zA-Z0-9\?\=\&_-]{1,2053}|'
    + 'www\.dailymotion\.com\/embed\/video\/[a-zA-Z0-9\?\=\&_-]{1,2043}|player\.vimeo\.com\/video\/[a-zA-Z0-9\?\=\#\&_-]{1,2052})$');
    const linksRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051}|youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066}|www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049}|dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068}|vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$');
    const youtubeRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051})$');
    const youtubeShortRegex = new RegExp('^(https\:\/\/){1}(youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066})$');
    const vimeoRegex = new RegExp('^(https\:\/\/){1}(vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$');
    const dailymotionRegex = new RegExp('^(https\:\/\/){1}(www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049})$');
    const dailymotionShortRegex = new RegExp('^(https\:\/\/){1}(dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068})$');
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
        var previewImgContainer = $('<div id="img-container-' + imagesLength + '" class="d-inline-block mt-1 mb-5 media image"></div>');
        var previewImg = $('<img class="border-black media-img" id="trick-img-thumb-' + imagesLength + '"src="'+ previewThumbPath +'" alt="preview_mini"/>');

        var controlsEl = createControlsImage();

        previewImgContainer.append(previewImg);
        previewImgContainer.append(controlsEl);

        return previewImgContainer;
    }

    function createControlsImage() {
        let controlsContainer = $('<div class="d-flex justify-content-around mt-2 border-black controls-container"></div>');

        let editImg = $('<img src="' + editIconPath + '"/>').css('height', '16px').css('width', '16px');
        let deleteImg = $('<img src="' + deleteIconPath + '"/>').css('height', '16px').css('width', '16px');

        let editLink = $('<a id="edit-img-' + imagesLength + '" class="edit-control-img" href="#"></a>');
        let deleteLink = $('<a id="delete-img-' + imagesLength + '" class="delete-control-img" href="#"></a>');

        editLink.append(editImg);
        deleteLink.append(deleteImg);
        
        let numberOfImg = $('<span class="counter-img" id="img-number-' + imagesLength + '"></span>');
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

            refreshImages();
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

        if (videosLength === 0) {
            $('#medias_container').append(imagePreview);
        } else {
            $('.video').eq(0).before(imagePreview);
        }
        
        imagesLength++;
        totalMedias++;

        refreshPagination();

        inputFile.trigger('click');
    }

    function recreateImages() {
        var fileInputs = containerImages.children(':input');
        var fileInputsLength = fileInputs.length;

        if (fileInputsLength === 0) {
            return;
        }

        fileInputs.hide();

        while(imagesLength < fileInputsLength) {
            let fileInputId = 'appbundle_trick_images_' + imagesLength + '_file';
            let fileInputName = 'appbundle_trick[images][' + imagesLength + '][file]';
            
            let fileInput = fileInputs.eq(imagesLength).attr('id', fileInputId).attr('name', fileInputName);

            fileInput.change(function () {
                if ($(this).val().length !== 0) {
                    readURL(this);
                } else {
                    loadDefaultThumbImgPreview($(this));
                }
            });

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
        }

        return;
    }

    function refreshImages() {
        let inputsFile = containerImages.children(':input');
        let inputsFileLength = inputsFile.length;

        if (inputsFileLength === 0) {
            imagesLength  = 0;
            return;
        }

        imagesLength = 0;

        while(imagesLength < inputsFileLength) {
            let mediaId = 'img-container-' + imagesLength;
            let mediaImgId = 'trick-img-thumb-' + imagesLength;
            let counterId = 'img-number-' + imagesLength;
            let editControlId = 'edit-img-' + imagesLength;
            let deleteControlId = 'delete-img-' + imagesLength;
            let inputId = 'appbundle_trick_images_' + imagesLength + '_file';
            let inputName = 'appbundle_trick[images][' + imagesLength + '][file]';

            $('.image').eq(imagesLength).attr('id', mediaId);
            $('.media-img').eq(imagesLength).attr('id', mediaImgId);
            $('.counter-img').eq(imagesLength).attr('id', counterId).text(imagesLength + 1);
            $('.edit-control-img').eq(imagesLength).attr('id', editControlId);
            $('.delete-control-img').eq(imagesLength).attr('id', deleteControlId);
            inputsFile.eq(imagesLength).attr('id', inputId).attr('name', inputName);

            imagesLength++;
        }

        return;
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
            validateUrl($(this).val(), Number(idSplit[3]) + 1);
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

    function createAddVideoIframeModalContent() {
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

        let editLink = $('<a id="edit-video-' + videosLength + '" class="edit-control-video px-1" href="#"></a>');
        let deleteLink = $('<a id="delete-video-' + videosLength + '" class="delete-control-video px-1" href="#"></a>');

        let numberOfVideos = $('<span class="counter-video px-1" id="video-number-' + videosLength + '"></span>');
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

            refreshVideos();
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

        if (!validateEmbedUrl(url[1], errorTarget)) {
            return false;
        }

        errorTarget.text('');
        return true;
    }

    function validateEmbedUrl(url, errorTarget) {
        if (url.length === 0) {
            let errorMsg = 'Url of the video can not be empty !';

            errorTarget.text(errorMsg);
            return false;
        }

        if (url.length > videoUrlMaxLength) {
            let errorMsg = 'Url of the video ' + maxLengthMessage + ' ' + videoUrlMaxLength + ' characters !'

            errorTarget.text(errorMsg);
            return false;
        }

        if (!urlEmbedRegex.test(url)) {
            let errorMsg = 'The integration tag must come from Youtube, Dailymotion or Vimeo';

            errorTarget.text(errorMsg);
            return false;
        }

        $(errorTarget).text('');
        return true;
    }

    function validateLink(link, errorTarget) {
        if (link.length === 0) {
            let errorMsg = 'You must enter a link !';

            errorTarget.text(errorMsg);
            return false;
        }

        if (link.length > videoUrlMaxLength) {
            let errorMsg = 'The link ' + maxLengthMessage + ' ' + videoUrlMaxLength + ' characters !'

            errorTarget.text(errorMsg);
            return false;
        }

        if (!linksRegex.test(link)) {
            let errorMsg = 'The link must come from Youtube, Dailymotion or Vimeo';

            errorTarget.text(errorMsg);
            return false;
        }

        errorTarget.text('');
        return true;
    }

    function validateUrl(url, videoId) {
        if (url.length === 0) {
            let errorMsg = 'Url of the video can not be empty !';
            errorMsg = 'Video ' + videoId + ' : ' + errorMsg;
            

            $('#media_error').text(errorMsg);
            return false;
        }

        if (url.length > videoUrlMaxLength) {
            let errorMsg = 'Url of the video ' + maxLengthMessage + ' ' + videoUrlMaxLength + ' characters !'
            errorMsg = 'Video ' + videoId + ' : ' + errorMsg;

            $('#media_error').text(errorMsg);
            return false;
        }

        if (!urlRegex.test(url)) {
            let errorMsg = 'The video must come from Youtube, Dailymotion or Vimeo';
            errorMsg = 'Video ' + videoId + ' : ' + errorMsg;

            $('#media_error').text(errorMsg);
            return false;
        }

        $('#media_error').text('');
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

        refreshPagination();
    }

    function uploadVideoLink() {
        let linkVideo  = $('#linkVideo').val();

        if (!validateLink(linkVideo, $('#link_error'))) {
            return false;
        }

        let embedLink = convertLinkToEmbed(linkVideo);

        let src = 'src="' + embedLink + '"';

        let videoEl = createVideoEl(src);
        let urlField = createInputVideoUrl();

        urlField.val(linkVideo);
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

        refreshPagination();
    }

    function convertLinkToEmbed(link) {
        if (youtubeRegex.test(link)) {
            let videoCode = link.split('v=');
            let embedLink = youtubeEmbedFormat + videoCode[1];

            return embedLink;
        }

        if (youtubeShortRegex.test(link)) {
            let videoCode = link.split('/');
            let embedLink = youtubeEmbedFormat + videoCode[3];
            
            return embedLink;
        }

        if (dailymotionRegex.test(link)) {
            let videoCode = link.split('/');
            let embedLink = dailymotionEmbedFormat + videoCode[4];

            return embedLink;
        }

        if (dailymotionShortRegex.test(link)) {
            let videoCode = link.split('/');
            let embedLink = dailymotionEmbedFormat + videoCode[3];

            return embedLink;
        }

        if (vimeoRegex.test(link)) {
            let videoCode = link.split('/');
            let embedLink = vimeoEmbedFormat + videoCode[3];

            return embedLink;
        }
    }

    function recreateVideos() {
        let videosInputs = containerVideos.children(':input');
        let videosInputsLength = videosInputs.length;

        videosInputs.hide();

        if (videosInputsLength === 0) {
            return;
        }

        while (videosLength < videosInputsLength) {
            let videoInputId = 'appbundle_trick_videos_' + videosLength + '_url';
            let videoInputName = 'appbundle_trick[videos][' + videosLength + '][url]';

            let videoInput = videosInputs.eq(videosLength);
            videoInput.attr('id', videoInputId).attr('name', videoInputName);

            let srcVideo = 'src="' + videoInput.val() + '"';

            let videoEl = createVideoEl(srcVideo);

            if (getNbOfMediaActualPage() < getMediaPerPage()) {
                videoEl.addClass('reveal-media');
            } else {
                videoEl.removeClass('d-inline-block');
                videoEl.hide();
            }

            $('#medias_container').append(videoEl);

            videosLength++;
            totalMedias++;
        }
    }

    function refreshVideos() {
        let inputsUrl = containerVideos.children(':input');
        let inputsUrlLength = inputsUrl.length;

        if (inputsUrlLength === 0) {
            videosLength  = 0;
            return;
        }

        videosLength = 0;

        while(videosLength < inputsUrlLength) {
            let mediaId = 'video-container-' + videosLength;
            let counterId = 'video-number-' + videosLength;
            let editControlId = 'edit-video-' + videosLength;
            let deleteControlId = 'delete-video-' + videosLength;
            let inputId = 'appbundle_trick_videos_' + videosLength + '_url';
            let inputName = 'appbundle_trick[videos][' + videosLength + '][url]';

            $('.video').eq(videosLength).attr('id', mediaId);
            $('.counter-video').eq(videosLength).attr('id', counterId).text(videosLength + 1);
            $('.edit-control-video').eq(videosLength).attr('id', editControlId);
            $('.delete-control-video').eq(videosLength).attr('id', deleteControlId);
            inputsUrl.eq(videosLength).attr('id', inputId).attr('name', inputName);

            videosLength++;
        }

        return;
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

    function createAddVideoModalContent() {
        let addVideoContainer = $('<ul></ul>');
        let videoIframeLi = $('<li></li>').css('list-style-type', 'none');
        let videoLinkLi = $('<li></li>').css('list-style-type', 'none');
        let videoIframeLink = $('<a href="#">Add video with embed tag</a>');
        let videoLink = $('<a href="#">Add video with link</a>');

        videoIframeLink.click(function (e) {
            e.preventDefault();
            addVideoModal.close();
            addVideoIframeModal.open();
        });

        videoLink.click(function (e) {
            e.preventDefault();
            addVideoModal.close();
            addVideoLinkModal.open();
        });

        videoIframeLi.append(videoIframeLink);
        videoLinkLi.append(videoLink);

        addVideoContainer.append(videoIframeLi);
        addVideoContainer.append(videoLinkLi);

        return addVideoContainer;
    }

    function createAddVideoLinkModalContent() {
        let modalContainer = $('<div class="modalContainer"></div>');
        let labelModalUrl = $('<label class="control-label required" for="linkVideo">Link</label>');
        let textareaModalUrl = $('<textarea id="linkVideo" required="required" class="form-control"></textarea>')
        let errorModalUrl = $('<span class="invalid-feedback d-block" id="link_error"></span>');

        textareaModalUrl.on('keyup blur', function () {
            validateLink($(this).val(), $('#link_error'));
        });

        modalContainer.append(labelModalUrl);
        modalContainer.append(textareaModalUrl);
        modalContainer.append(errorModalUrl);

        return modalContainer;
    }

    function clearModal() {
        $('#iframeVideo').val('');
        $('#linkVideo').val('');
        $('#iframe_error').text('');
        $('#link_error').text('');
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
        var totalPages = Math.ceil(totalMedias / getMediaPerPage());

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

        if (getMediaPerPage() === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

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

        if (getMediaPerPage() === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

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

        if (getMediaPerPage() === 1) {
            $('.media').eq(actualPage - 1).addClass('reveal-media d-inline-block').show();
            showPagination();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

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

    $(window).resize(function () {
        refreshPagination();
    });

    var actualPage = 1;
    var totalMedias = 0;
    var mediaPerPage = getMediaPerPage();
    var totalPages = getTotalPages();

    var containerImages = $('#trickImages');

    var imagesLength = 0;
    recreateImages();

    var containerVideos = $('#trickVideos');

    var videosLength = 0;
    recreateVideos();

    showPagination();

    var addVideoIframeModalContent = createAddVideoIframeModalContent();
    var addVideoModalContent = createAddVideoModalContent();
    var addVideoLinkModalContent = createAddVideoLinkModalContent();

    var addVideoIframeModal = new jBox('Confirm', {
        title: 'Add a video',
        content: addVideoIframeModalContent,
        cancelButton: 'Cancel',
        confirmButton: 'Upload',
        confirm: uploadVideo,
        cancel: clearModal,
    });

    var addVideoLinkModal = new jBox('Confirm', {
        title: 'Add a video',
        content: addVideoLinkModalContent,
        cancelButton: 'Cancel',
        confirmButton: 'Upload',
        confirm: uploadVideoLink,
        cancel: clearModal,
    });

    var addVideoModal = new jBox('Modal', {
        title: 'Add a video',
        content: addVideoModalContent,
    });

    var editVideoModal = new jBox('Confirm', {
        cancelButton: 'Cancel',
        confirmButton: 'Edit',
        confirm: editVideo,
    });
});