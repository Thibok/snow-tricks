$(function () {
    var nbTricks = $('.trick-container-home').length;

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
});