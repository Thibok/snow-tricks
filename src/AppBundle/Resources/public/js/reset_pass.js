$(function () {

    const passwordMinLength = 8;
    const passwordMaxLength = 48;
    const passwordRegex = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z]).{" + passwordMinLength + ",}$");
    const emailRegex = new RegExp("^[a-z0-9._-]+@[a-z0-9._-]{2,}\\.[a-z]{2,4}$");

    const minLengthMessage = "must be at least";
    const maxLengthMessage = "must be at most";

    function validatePassword(password) {

        if (password.length < passwordMinLength) {
            $("#password_error").text("The password " + minLengthMessage + " " + passwordMinLength + " characters !");
            return false;
        }

        if (password.length > passwordMaxLength) {
            $("#password_error").text("The password " + maxLengthMessage + " " + passwordMaxLength + " characters !");
            return false;
        }

        if (!passwordRegex.test(password)) {
            $("#password_error").text("The password must contain at least one letter and one number");
            return false;
        }

        $("#password_error").text("");
        return true;
    }

    var password = $("#form_password");
    var email = $("#form_email");

    function validateEmail(email) {

        if (!emailRegex.test(email)) {
            $("#email_error").text("Please enter a valid email address !");
            return false;
        }

        $("#email_error").text("");
        return true;
    }

    function validateForm() {

        let validEmail = validateEmail(email.val());
        let validPassword = validatePassword(password.val());

        let results = [validEmail, validPassword];

        if ($.inArray(false, results) !== -1) {
            return false;
        }

        return true;
    }

    function formSubmit() {
        $("#security_form").submit();
    }

    password.on("keyup blur", function () {
        validatePassword($(this).val());
    });

    email.on("keyup blur", function () {
        validateEmail($(this).val());
    });
  
    window.formSubmit = formSubmit;

    $("#resetPassBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            grecaptcha.reset();
            grecaptcha.execute();
        }    
    });
});