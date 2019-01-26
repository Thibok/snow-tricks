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
        var width = this.innerWidth;

        if (width < 591) {
            $('#register').show();
            $('#buttonSection').after($('#links'));
        } else {
            $('#register').hide();
            $('#buttonSection').before($('#links'));
        }
    });

    if (window.innerWidth < 591) {
        $('#register').show();
        $('#buttonSection').after($('#links'));
    } else {
        $('#register').hide();
        $('#buttonSection').before($('#links'));
    }
});