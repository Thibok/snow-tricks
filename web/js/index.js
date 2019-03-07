$(function () {
    const ajaxLoaderImgPath = '/img/ajax-loader.gif';
    const apiTricksUrl = '/api/tricks/';
    const trickViewUrl = '/tricks/details/';
    const apiTrickDeleteUrl = 'api/trick/'
    const trickPrevThumbImg = '/img/preview_trick_thumb.jpg';
    const editImgPath = '/img/edit.png';
    const deleteImgPath = '/img/delete.png';
    const arrowUpImgPath = '/img/arrow_up.png';

    function createAjaxLoader () {
        let loadImg = $('<div id="ajaxLoader" class="w-100 text-center"><img class="mb-2 mt-2" src="' + ajaxLoaderImgPath + '" alt="loader"/></div>');
        loadImg.css('width', '48px').css('height', '48px');

        return loadImg;
    }

    function getTricks () {
        tricksLoading = true;

        let url = apiTricksUrl + nbTricks;

        $('#tricksBlock').append(createAjaxLoader());

        $.get(url, function (datas) {
            if (datas.length === 0) {
                $('#ajaxLoader').remove();
                canLoadMoreTricks = false;
                return;
            }

            $('#ajaxLoader').remove();

            $(datas).each(function () {
                let trick = createTrickElement(this['imgSrc'], this['name'], this['slug']);
                $('#tricksBlock').append(trick);
                nbTricks++;
            });

            if (window.innerWidth > 991 && arrowUpExist == false && nbTricks > 15) {
                $('#tricksBlock').append(createArrowUp());
            }

            tricksLoading = false;
        });
    }

    function createTrickElement(imgSrc, name, slug) {
        let trickViewPath = trickViewUrl + slug;
        let trickEditPath = trickViewUrl + slug + '/update';
        let trickDeletePath = apiTrickDeleteUrl + slug + '/delete';

        let trickContainer = $('<div class="mb-5 trick-container-home"></div>');
        let trickCard = $('<div class="card h-100 trick-card-home"></div>');
        let imgLink = $('<a></a>');
        imgLink.attr('href', trickViewPath);
        let trickImg = $('<img class="card-img-top trick-img-prev-home" alt="trick image"/>');
        imgLink.append(trickImg);

        if (imgSrc == null) {
            trickImg.attr('src', trickPrevThumbImg);
        } else {
            trickImg.attr('src', imgSrc);
        }

        let trickInfosContainer = $('<div class="d-flex justify-content-between pt-2"></div>');
        let trickNameContainer = $('<h4 class="card-title trick-name-home pt-1 pl-2 w-100"></h4>');
        let trickNameLink = $('<a class="text-white"></a>');
        trickNameLink.attr('href', trickViewPath);
        trickNameLink.text(name);
        trickNameContainer.append(trickNameLink);

        trickInfosContainer.append(trickNameContainer);

        if ($('#logout').length == 1) {
            let controlsContainer = $('<div class="trick-controls text-right mr-3"></div>');

            let editLink = $(' <a class="mr-3 control-trick-home"></a>');
            editLink.attr('href', trickEditPath);
            let editImg = $('<img alt="edit icon"/>');
            editImg.attr('src', editImgPath);
            editLink.append(editImg);
            
            let deleteLink = $('<a class="control-trick-home"></a>')
            deleteLink.attr('href', trickDeletePath);
            let deleteImg = $('<img alt="edit icon"/>');
            deleteImg.attr('src', deleteImgPath);
            deleteLink.append(deleteImg);

            controlsContainer.append(editLink);
            controlsContainer.append(deleteLink);

            trickInfosContainer.append(controlsContainer);
        }

        trickCard.append(imgLink);
        trickCard.append(trickInfosContainer);
        trickContainer.append(trickCard);

        return trickContainer;
    }

    function createArrowUp () {
        let arrowUpLink = $('<a id="arrowUp" href="#"></a>');

        arrowUpLink.css('position', 'fixed').css('bottom', '95px');

        if (window.innerWidth >= 1000 && window.innerWidth <= 1350) {
            arrowUpLink.css('right', '2px');
        } else {
            arrowUpLink.css('right', '4px');
        }

        let arrowUpImg = $('<img alt="arrow up image"/>');
        arrowUpImg.attr('src', arrowUpImgPath);

        arrowUpLink.click(function (e) {
            e.preventDefault();

            let speed = 500;
            let scrollPos = $('#imgBanner').height() - 90;

            $('html, body').animate( { scrollTop: scrollPos, speed });
        });

        arrowUpLink.append(arrowUpImg);
        arrowUpExist = true;

        return arrowUpLink;
    }

    var nbTricks = $('.trick-container-home').length;
    var tricksLoading = false;
    var canLoadMoreTricks = true;
    var arrowUpExist = false;

    $('#arrowDown').click(function(event) {
        event.preventDefault();
        let speed = 500;
        let result = $('#imgBanner').height();

        if (nbTricks == 0) {
            result = result / 8;
        }

        if (nbTricks > 0 && nbTricks <= 5) {
            result = result / 2 - $('#mainNav').height() - 100;
        }

        if (nbTricks > 5 && nbTricks <= 10) {
            result = result / 2 + 80;
        }

        if (nbTricks > 10) {
            result = result - 90;
        }

        if (window.innerWidth < 1581 && nbTricks > 10) {
            result = result - 110;
        }

        if (window.innerWidth < 1420 && nbTricks > 0 && nbTricks <= 5) {
            result = result - 40;
        }

        if (window.innerWidth < 1420 && nbTricks > 5 && nbTricks <= 10) {
            result = result - 80;
        }

        if (window.innerWidth < 1201 && nbTricks >= 5 && nbTricks <= 10) {
            result = result + 230;
        }

        if (window.innerWidth < 1001 && nbTricks >= 4 && nbTricks <= 6) {
            result = result + 20;
        }

        if (window.innerWidth < 1001 && nbTricks > 6) {
            result = result + 60;
        }

        if (window.innerWidth < 771 && nbTricks >= 4 && nbTricks <= 6) {
            result = 0;
        }

        if (window.innerWidth < 771 && nbTricks > 6) {
            result = result / 2 - 70;
        }

        if (window.innerWidth < 701 && nbTricks >= 5) {
            result =  $('#imgBanner').height() - 70;
        }

        if (window.innerWidth < 701 && nbTricks >= 3 && nbTricks <= 4) {
            result =  result + 60;
        }

        if (window.innerWidth < 591 && nbTricks >= 3 && nbTricks < 5) {
            result =  0;
        }

        if (window.innerWidth < 591 && nbTricks >= 5) {
            result =  result - 40;
        }

        if (window.innerWidth < 501 && nbTricks >= 3) {
            result =  $('#imgBanner').height() + 2;
        }

        if (window.innerWidth < 501 && nbTricks == 2) {
            result =  $('#imgBanner').height() / 2 - 50;
        }

        if (window.innerWidth < 431 && nbTricks == 2) {
            result =  result - 50;
        }

        if (window.innerWidth < 401 && nbTricks == 3) {
            result =  result / 2 + 50;
        }

        $('html, body').animate( { scrollTop: result, speed });
    });

    if (nbTricks == 0) {
        let noTricks = $('<span id="noTricks">No Tricks</span>');
        $('#tricksBlock').append(noTricks);
    }

    $(window).scroll(function () {
        let scrollPos = $(this).scrollTop() + $(this).height();

        if (scrollPos == $(document).height()) {
            if (tricksLoading == false && canLoadMoreTricks == true) {
                getTricks();
            }
        }

        if (arrowUpExist == false) {
            return;
        }

        let scrollCap = $('#imgBanner').height() - 90;

        if (this.innerWidth >= 992) {
            if ($(this).scrollTop() > scrollCap) {
                $('#arrowUp').show();
                return;
            }
    
            $('#arrowUp').hide();
        } else {
            $('#arrowUp').hide();
        }

        return;
    });  

    $(window).resize(function () {

        let scrollCap = $('#imgBanner').height() - 90;

        if (this.innerWidth > 991 && arrowUpExist == false && nbTricks > 15 && $(this).scrollTop() > scrollCap) {
            $('#tricksBlock').append(createArrowUp());
        } else {
            if (arrowUpExist == true) {
                if (this.innerWidth >= 1000 && this.innerWidth <= 1350) {
                    $('#arrowUp').css('right', '2px');
                } else {
                    $('#arrowUp').css('right', '4px');
                }

                if (this.innerWidth < 992) {
                    $('#arrowUp').hide();
                    return;
                }

                if ($(this).scrollTop() > scrollCap) {
                    $('#arrowUp').show();
                }
            }
        }

        return;
    });
});