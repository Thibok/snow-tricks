$(function () {
    
    const navLinksText = ["Home", "Sign in", "Sign up", "Add Trick", "Logout"];
    const navLinksIcon = ["/img/home.png", "/img/login.png", "/img/registration.png", "/img/add_trick.png", "/img/logout.png"];
    const windowWidthLimit = 591;

    function navBarScroll () {
        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").css("background-color", "#4A6C6F").css("transition-duration", "0.5s");
        } else {
            $("#mainNav").css("background-color", "");
        }
    }

    function setCopyrightText() {
        let copyright = $("#copyright");
        copyright.text("Copyright @ 2018");
    }

    function unsetCopyrightText() {
        let copyright = $("#copyright");
        copyright.text("");
    }

    function setMobileNavBar() {
        $("#logo").hide();
        $("#mainNav").removeClass("fixed-top").attr("id", "phoneNav").addClass("fixed-bottom");
        $("#home").html("<img src='" + navLinksIcon[0] + "' alt='Home'/>");
        $("#login").html("<img src='" + navLinksIcon[1] + "' alt='Sign in'/>");
        $("#registration").html("<img src='" + navLinksIcon[2] + "' alt='Sign up'/>");
        $("#addTrick").html("<img src='" + navLinksIcon[3] + "' alt='Add Trick'/>");
        $("#logout").html("<img src='" + navLinksIcon[4] + "' alt='Logout'/>");
    }

    function setNavBar () {
        $("#logo").show();
        $("#phoneNav").removeClass("fixed-bottom").attr("id", "mainNav").addClass("fixed-top");
        $("#home").text(navLinksText[0]);
        $("#login").text(navLinksText[1]);
        $("#registration").text(navLinksText[2]);
        $("#addTrick").text(navLinksText[3]);
        $("#logout").text(navLinksText[4]);
    }

    $(window).scroll(function () {
        if (this.innerWidth > windowWidthLimit) {
            navBarScroll();
        }
    });

    $(window).resize(function () {
        var width = this.innerWidth;

        if (width < windowWidthLimit) {
            unsetCopyrightText();
            setMobileNavBar();
        } else {
            setCopyrightText();
            setNavBar();
        }
    });

    $("[class^=flash-]").each(function (index) {

        var message = $(this).text();

        delayOpenDuration = index * 2500;

        if ($(this).hasClass("flash-notice")) {
            var color = "blue";
        } else {
            var color = "red";
        }

        new jBox("notice", {
            addClass: "jBox-wrapper jBox-Notice jBox-NoticeFancy jBox-Notice-color jBox-Notice-" + color,
            autoClose: 2500,
            fixed: true,
            position: { x: "left", y: "bottom" },
            offset: { x: 0, y: -20 },
            responsiveWidth: true,
            content: message,
            overlay: false,
            delayOpen: delayOpenDuration,
            closeOnClick: "box",
            onCloseComplete: function () {
              this.destroy();
            }
        }).open();
        
        $(this).remove();
    });

    if (window.innerWidth < windowWidthLimit) {
        setMobileNavBar();
        unsetCopyrightText();
    } else {
        setNavBar();
        setCopyrightText();
        navBarScroll();
    }
});