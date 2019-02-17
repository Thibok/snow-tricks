$(function () {
    const linksRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051}|youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066}|www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049}|dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068}|vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$');
    const youtubeRegex = new RegExp('^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051})$');
    const youtubeShortRegex = new RegExp('^(https\:\/\/){1}(youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066})$');
    const vimeoRegex = new RegExp('^(https\:\/\/){1}(vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$');
    const dailymotionRegex = new RegExp('^(https\:\/\/){1}(www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049})$');
    const dailymotionShortRegex = new RegExp('^(https\:\/\/){1}(dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068})$');
    const youtubeEmbedFormat = 'https://www.youtube.com/embed/';
    const dailymotionEmbedFormat = 'https://www.dailymotion.com/embed/video/';
    const vimeoEmbedFormat = 'https://player.vimeo.com/video/';
    const nextEnabledPath = '/img/next.png';
    const prevEnabledPath = '/img/prev.png';
    const nextDisableddPath = '/img/next_disabled.png';
    const prevDisabledPath = '/img/prev_disabled.png';

    function recreateVideos() {
        let videos = $('.video');

        videos.each(function () {
            let span = $(this).children('span');
            let url = span.text();

            if (linksRegex.test(url)) {
                url = convertLinkToEmbed(url);
            }

            let srcUrl = 'src="' + url + '"';
            let iframe = createVideoIframe(srcUrl);

            if (getNbOfMediaActualPage() < getMediaPerPage()) {
                $(this).addClass('reveal-media');
            } else {
                $(this).removeClass('d-inline-block');
                $(this).hide();
            }

            videosLength++;
            totalMedias++;

            $(this).css('height', '100px');
            span.replaceWith(iframe);
        });
    }

    function recreateImages() {
        let images = $('.image');

        images.each(function () {
            if (getNbOfMediaActualPage() < getMediaPerPage()) {
                $(this).addClass('reveal-media');
            } else {
                $(this).removeClass('d-inline-block');
                $(this).hide();
            }

            imagesLength++;
            totalMedias++;
        });
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

        if (window.innerWidth < 591 && seeMedia === false) {
            $('#pagination').hide();
            return;
        }
        
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

    function createVideoIframe (videoSrc) {
        let iframeVideoEl = '<iframe class="align-middle" width=100% height=100% ' + videoSrc + ' frameborder="0"></iframe>';

        return iframeVideoEl;
    }

    $('#see_media').click(function (e) {
        e.preventDefault();
        $('#see_media_container').hide();
        $('#medias_container').show();
        seeMedia = true;
        
        showPagination();
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
        if (window.innerWidth < 591) {
            $('#medias_container').hide();

            if ($('.media').length > 0) {
                $('#see_media_container').show();
                seeMedia = false;
            } else {
                $('#see_media_container').hide();
            }
        } else {
            $('#medias_container').show();
            $('#see_media_container').hide();
        }

        actualPage = 1;
        refreshPagination();
    });

    var actualPage = 1;
    var totalMedias = 0;
    var mediaPerPage = getMediaPerPage();
    var totalPages = getTotalPages();

    var imagesLength = 0;
    recreateImages();

    var videosLength = 0;
    recreateVideos();

    $('#see_media_container').hide();
    var seeMedia = false;

    showPagination();

    if(window.innerWidth < 591) {
        $('#medias_container').hide();

        if ($('.media').length > 0) {
            $('#see_media_container').show();
        } else {
            $('#see_media_container').hide();
        }
    }

    $('#loadMoreComment').click(function (e) {
        e.preventDefault();
    });
});