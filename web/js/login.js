$(function () {
    function formSubmit() {
        $('#security_form').submit();
      }
  
    window.formSubmit = formSubmit;

    $('#loginBtn').click(function (event) {
        event.preventDefault();
        grecaptcha.reset();
        grecaptcha.execute();    
    });

    $(window).resize(function () {
        var width = $(this).width();

        if (width < 576) {
            $('#register').show();
            $('#buttonSection').after($('#links'));
        } else {
            $('#register').hide();
            $('#buttonSection').before($('#links'));
        }
    });

    if ($(window).width() < 576) {
        $('#register').show();
        $('#buttonSection').after($('#links'));
    } else {
        $('#register').hide();
        $('#buttonSection').before($('#links'));
    }
});