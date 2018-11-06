$(function () {
    
    const navLinksText = ['Home', 'Sign in', 'Sign up'];
    const navLinksIcon = ['../img/home.png', '../img/login.png', '../img/registration.png'];

    function navBarScroll () {
        if ($('#mainNav').offset().top > 100) {
            $('#mainNav').css('background-color', '#4A6C6F').css('transition-duration', '0.5s');
        } else {
            $('#mainNav').css('background-color', '');
        }
    }

    function setCopyrightText() {
        let copyright = $('#copyright');
        copyright.text('Copyright @ 2018');
    }

    function unsetCopyrightText() {
        let copyright = $('#copyright');
        copyright.text('');
    }

    function setMobileNavBar() {
        $('#logo').hide();
        $('#mainNav').removeClass('fixed-top').attr('id', 'phoneNav').addClass('fixed-bottom');
        $('#home').html('<img src="' + navLinksIcon[0] + '" alt="Home"/>');
        $('#registration').html('<img src="' + navLinksIcon[1] + '" alt="Sign in"/>');
        $('#login').html('<img src="' + navLinksIcon[2] + '" alt="Sign up"/>');
    }

    function setNavBar () {
        $('#logo').show();
        $('#phoneNav').removeClass('fixed-bottom').attr('id', 'mainNav').addClass('fixed-top');
        $('#home').text(navLinksText[0]);
        $('#registration').text(navLinksText[1]);
        $('#login').text(navLinksText[2]);
    }

    $(window).resize(function () {
        var width = $(this).width();

        if (width < 576) {
            unsetCopyrightText();
            setMobileNavBar();
        } else {
            setCopyrightText();
            setNavBar();
        }
    })
    
    if ($(window).width() < 576) {
        setMobileNavBar();
        unsetCopyrightText();
    } else {
        setNavBar();
        setCopyrightText();
    }

    $(window).scroll(function () {
        navBarScroll()
    })

    navBarScroll();
});