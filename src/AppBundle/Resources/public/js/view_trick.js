$(function () {
    const linksRegex = new RegExp("^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051}|youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066}|www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049}|dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068}|vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$");
    const youtubeRegex = new RegExp("^(https\:\/\/){1}(www\.youtube\.com\/watch\\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051})$");
    const youtubeShortRegex = new RegExp("^(https\:\/\/){1}(youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066})$");
    const vimeoRegex = new RegExp("^(https\:\/\/){1}(vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$");
    const dailymotionRegex = new RegExp("^(https\:\/\/){1}(www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049})$");
    const dailymotionShortRegex = new RegExp("^(https\:\/\/){1}(dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068})$");
    const youtubeEmbedFormat = "https://www.youtube.com/embed/";
    const dailymotionEmbedFormat = "https://www.dailymotion.com/embed/video/";
    const vimeoEmbedFormat = "https://player.vimeo.com/video/";
    const nextEnabledPath = "/img/next.png";
    const prevEnabledPath = "/img/prev.png";
    const nextDisableddPath = "/img/next_disabled.png";
    const prevDisabledPath = "/img/prev_disabled.png";
    const ajaxLoaderImgPath = "/img/ajax-loader.gif";
    const apiCommentsUrl = "/api/comments/";
    const commentMinLength = 2;
    const commentMaxLength = 500;
    const minLengthMessage = "must be at least";
    const maxLengthMessage = "must be at most";
    const commentRegex = new RegExp("[<>]");

    var imagesLength = 0;
    var videosLength = 0;
    var actualPage = 1;
    var totalMedias = 0;
    $("#see_media_container").hide();
    var seeMedia = false;

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

    function getNbOfMediaActualPage() {
        return $(".reveal-media").length;
    }

    function recreateImages() {
        let images = $(".image");

        images.each(function () {
            if (getNbOfMediaActualPage() < getMediaPerPage()) {
                $(this).addClass("reveal-media");
            } else {
                $(this).removeClass("d-inline-block");
                $(this).hide();
            }

            imagesLength++;
            totalMedias++;
        });
    }

    function recreateVideos() {
        let videos = $(".video");

        videos.each(function () {
            let span = $(this).children("span");
            let url = span.text();

            if (linksRegex.test(url)) {
                url = convertLinkToEmbed(url);
            }

            let srcUrl = "src='" + url + "'";
            let iframe = createVideoIframe(srcUrl);

            if (getNbOfMediaActualPage() < getMediaPerPage()) {
                $(this).addClass("reveal-media");
            } else {
                $(this).removeClass("d-inline-block");
                $(this).hide();
            }

            videosLength++;
            totalMedias++;

            $(this).css("height", "100px");
            span.replaceWith(iframe);
        });
    }

    function disableNext() {
        $("#next").removeAttr("href");
        $("#next img").attr("src", nextDisableddPath);
        return;
    }

    function disablePrev() {
        $("#previous").removeAttr("href");
        $("#previous img").attr("src", prevDisabledPath);
        return;
    }

    function enableNext() {
        $("#next").attr("href", "#");
        $("#next img").attr("src", nextEnabledPath);
        return;
    }

    function enablePrev() {
        $("#previous").attr("href", "#");
        $("#previous img").attr("src", prevEnabledPath);
        return;
    }

    function getTotalMedias() {
        return $(".media").length;
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

    function showPagination() {

        if (window.innerWidth < 591 && seeMedia === false) {
            $("#pagination").hide();
            return;
        }
        
        if (getTotalMedias() <= getMediaPerPage()) {
            disableNext();
            disablePrev();
            $("#pagination").hide();
            return;
        }

        if (getTotalMedias() > getMediaPerPage()) {
            $("#pagination").show();

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

    var mediaPerPage = getMediaPerPage();
    var totalPages = getTotalPages();

    recreateImages();
    recreateVideos();

    showPagination();

    function convertLinkToEmbed(link) {
        if (youtubeRegex.test(link)) {
            let videoCode = link.split("v=");
            let embedLink = youtubeEmbedFormat + videoCode[1];

            return embedLink;
        }

        if (youtubeShortRegex.test(link)) {
            let videoCode = link.split("/");
            let embedLink = youtubeEmbedFormat + videoCode[3];
            
            return embedLink;
        }

        if (dailymotionRegex.test(link)) {
            let videoCode = link.split("/");
            let embedLink = dailymotionEmbedFormat + videoCode[4];

            return embedLink;
        }

        if (dailymotionShortRegex.test(link)) {
            let videoCode = link.split("/");
            let embedLink = dailymotionEmbedFormat + videoCode[3];

            return embedLink;
        }

        if (vimeoRegex.test(link)) {
            let videoCode = link.split("/");
            let embedLink = vimeoEmbedFormat + videoCode[3];

            return embedLink;
        }
    }

    function createVideoIframe (videoSrc) {
        let iframeVideoEl = "<iframe class='align-middle' width=100% height=100% " + videoSrc + " frameborder='0'></iframe>";

        return iframeVideoEl;
    }

    function pageNext() {
        $(".reveal-media").each(function () {
            $(this).removeClass("reveal-media d-inline-block");
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
            $(".media").eq(actualPage - 1).addClass("reveal-media d-inline-block").show();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

        while(firstPos < lastPos) {
            $(".media").eq(firstPos).addClass("reveal-media d-inline-block").show();
            firstPos++;
        }

        return;      
    }

    function pagePrevious() {
        $(".reveal-media").each(function () {
            $(this).removeClass("reveal-media d-inline-block");
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
            $(".media").eq(actualPage - 1).addClass("reveal-media d-inline-block").show();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

        while(firstPos < lastPos) {
            $(".media").eq(firstPos).addClass("reveal-media d-inline-block").show();
            firstPos++;
        }

        return;
    }

    function refreshPagination() {
        $(".reveal-media").each(function () {
            $(this).removeClass("reveal-media d-inline-block");
            $(this).hide();
        })

        if (getMediaPerPage() === 1) {
            $(".media").eq(actualPage - 1).addClass("reveal-media d-inline-block").show();
            showPagination();
            return;
        }

        var lastPos = actualPage * getMediaPerPage();
        var firstPos = lastPos - getMediaPerPage();

        while(firstPos < lastPos) {
            $(".media").eq(firstPos).addClass("reveal-media d-inline-block").show();
            firstPos++;
        }

        showPagination();

        return;
    }

    function createCommentElement (imgSrc, author, content, date) {
        let commentContainer = $("<div class='comment pb-3'></div>");
        let commentImg = $("<img class='mr-2 mt-4 comment-user-img' src='/'" + imgSrc + "' alt='user image thumbnail'>")
        let commentInfosContainer = $("<div class='comment-infos'></div>");
        let commentAuthor = $("<span class='comment-user-name text-primary'>" + author + "</span>");
        let commentContent = $("<p class='comment-content mt-2'>" + content + "</p>");
        let commentDate = $("<span class='comment-add-date'>Add :" + date + "</span>");

        commentInfosContainer.append(commentAuthor);
        commentInfosContainer.append(commentContent);
        commentInfosContainer.append(commentDate);

        commentContainer.append(commentImg);
        commentContainer.append(commentInfosContainer);

        return commentContainer;
    }

    function createAjaxLoader () {
        let loadImg = $("<img id='ajaxLoader' class='mx-auto mb-4 mt-2' src='" + ajaxLoaderImgPath + "' alt='loader'/>");
        loadImg.css("width", "48px").css("height", "48px");

        return loadImg;
    }

    function createLoadMoreButton () {
        let loadMore = $("<button id='loadMoreComment' class='btn btn-primary mx-auto mb-4 mt-2'>Load More</button>");

        return loadMore;
    }

    function createJboxNotice (color, message) {
        let jBNotice = new jBox("notice", {
            addClass: "jBox-wrapper jBox-Notice jBox-NoticeFancy jBox-Notice-color jBox-Notice-" + color,
            autoClose: 2500,
            fixed: true,
            position: { x: "left", y: "bottom" },
            offset: { x: 0, y: -20 },
            responsiveWidth: true,
            content: message,
            overlay: false,
            closeOnClick: "box",
            onCloseComplete: function () {
              this.destroy();
            }
        })

        return jBNotice;
    }

    function loadMoreComment (button, e) {
        e.preventDefault();

        let trick = $("#trickRef").text();
        let commentsLength = $(".comment").length;
        let url = apiCommentsUrl + trick + "/" + commentsLength;
    
        button.replaceWith(createAjaxLoader());
    
        $.get(url, function (datas) {
            if (datas.length === 0) {
                $("#ajaxLoader").remove();
                return;
            }
            $(datas).each(function () {
                let comment = createCommentElement(this["imgSrc"], this["author"], this["content"], this["date"]);
                $("#ajaxLoader").before(comment);
            });

            let loadMoreButton = createLoadMoreButton();
            loadMoreButton.click(function (e) {
                loadMoreComment($(this), e);
            });
    
            $("#ajaxLoader").replaceWith(loadMoreButton);
        }).fail(function () {
            $("#ajaxLoader").remove();
            let message = "An error as occured";

            let jBNotice = createJboxNotice("red", message);
            jBNotice.open();
        });
    }

    function validateComment (comment) {
        if (comment.length < commentMinLength) {
            $("#comment_error").text("Comment " + minLengthMessage + " " + commentMinLength + " characters !");
            return false;
        }

        if (comment.length > commentMaxLength) {
            $("#comment_error").text("Comment " + maxLengthMessage + " " + commentMaxLength + " characters !");
            return false;
        }

        if (commentRegex.test(comment)) {
            $("#comment_error").text("Comment can\"t contain < or >");
            return false;
        }

        $("#comment_error").text("");
        return true;
    }

    function validateForm() {
        
        if (!validateComment(commentField.val())) {
            return false;
        }
     
        return true;
    }

    function formSubmit() {
        $("#commentForm").submit();
    }

    $("#see_media").click(function (e) {
        e.preventDefault();
        $("#see_media_container").hide();
        $("#medias_container").show();
        seeMedia = true;
        
        showPagination();
        return false;
    });

    $("#next").click(function (e) {
        e.preventDefault();

        if (canNext()) {
            pageNext();

            return false;
        }

        return false;
    });

    function goToDeleteTrickPage() {
        let url = $("#deleteTrick").attr("href");
        $(location).attr("href", url);
    }

    $("#previous").click(function (e) {
        e.preventDefault();

        if (canPrev()) {
            pagePrevious();

            return false;
        }

        return false;
    });

    $(window).resize(function () {
        if (window.innerWidth < 591) {
            $("#medias_container").hide();

            if ($(".media").length > 0) {
                $("#see_media_container").show();
                seeMedia = false;
            } else {
                $("#see_media_container").hide();
            }
        } else {
            $("#medias_container").show();
            $("#see_media_container").hide();
        }

        actualPage = 1;
        refreshPagination();
    });

    if(window.innerWidth < 591) {
        $("#medias_container").hide();

        if ($(".media").length > 0) {
            $("#see_media_container").show();
        } else {
            $("#see_media_container").hide();
        }
    }

    $("#loadMoreComment").click(function (e) {
        loadMoreComment($(this), e);
    });

    window.formSubmit = formSubmit;

    var commentField = $("#appbundle_comment_content");

    commentField.on("keyup blur", function () {
        validateComment($(this).val());
    });

    $("#leaveCommentBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            grecaptcha.reset();
            grecaptcha.execute();
        }
    });

    var deleteTrickModal = new jBox("Confirm", {
        cancelButton: "Cancel",
        confirmButton: "Delete",
        content: "Are you sure you want to do that ?",
        confirm: goToDeleteTrickPage,
    });

    if ($(".comment").length === 0) {
        let noComments = $("<span id='noComments'>No Comments</span>");
        $("#loadMoreComment").replaceWith(noComments);
    }

    $("#deleteTrick").click(function (e) {
        e.preventDefault();
        deleteTrickModal.open();
    });
});