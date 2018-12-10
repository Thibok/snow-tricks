$(function () {
    function formSubmit() {
        $('#security_form').submit();
      }
  
    window.formSubmit = formSubmit;

    $('#forgotPassBtn').click(function (event) {
        event.preventDefault();
        grecaptcha.reset();
        grecaptcha.execute();    
    });

    $(window).resize(function () {
        var width = $(this).width();

        if (width < 576) {
            $('#forgotPassBtn').text('Ask for reset');
        } else {
            $('#forgotPassBtn').text('Ask for reset password');
        }
    });

    if ($(window).width() < 576) {
        $('#forgotPassBtn').text('Ask for reset');
    } else {
        $('#forgotPassBtn').text('Ask for reset password');
    }
});