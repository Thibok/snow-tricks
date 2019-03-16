$(function() {

    const usernameMinLength = 4;
    const usernameMaxLength = 30;
    const usernameRegex = new RegExp("^[a-z0-9_-]{" + usernameMinLength + ",}$", "i");
    const passwordMinLength = 8;
    const passwordMaxLength = 48;
    const passwordRegex = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z]).{" + passwordMinLength + ",}$");
    const emailMinLength = 7;
    const emailMaxLength = 70;
    const emailRegex = new RegExp("^[a-z0-9._-]+@[a-z0-9._-]{2,}\\.[a-z]{2,4}$");
    const nameMinLength = 2;
    const nameMaxLength = 40;
    const nameRegex = new RegExp("^[a-z]+-?[a-z]{1,}$", "i");
    const firstNameMinLength = 2;
    const firstNameMaxLength = 40;
    const firstNameRegex = new RegExp("^[a-z]+-?[a-z]{1,}$", "i");
    const allowedFileExtension = ["jpg", "jpeg", "png"];

    const minLengthMessage = "must be at least";
    const maxLengthMessage = "must be at most";

    var username = $("#appbundle_user_username");
    var password = $("#appbundle_user_password");
    var email = $("#appbundle_user_email");
    var name = $("#appbundle_user_name");
    var firstName = $("#appbundle_user_firstName");
    var image = $("#appbundle_user_image_file");

    image.hide();

    function validateUsername(username) {
        
        if (username.length < usernameMinLength) {
            $("#username_error").text("The username " + minLengthMessage + " " + usernameMinLength + " characters !");
            return false;
        }

        if (username.length > usernameMaxLength) {
            $("#username_error").text("The username " + maxLengthMessage + " " + usernameMaxLength + " characters !");
            return false;
        }

        if (!usernameRegex.test(username)) {
            $("#username_error").text("The username can contains letters, numbers, and dash (- _)");
            return false;
        }

        $("#username_error").text("");
        return true;
    }

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

    function validateEmail(email) {
        if (email.length < emailMinLength) {
            $("#email_error").text("The email " + minLengthMessage + " " + emailMinLength + " characters !");
            return false;
        }

        if (email.length > emailMaxLength) {
            $("#email_error").text("The email " + maxLengthMessage + " " + emailMaxLength + " characters !");
            return false;
        }

        if (!emailRegex.test(email)) {
            $("#email_error").text("Please enter a valid email address !");
            return false;
        }

        $("#email_error").text("");
        return true;
    }

    function validateName(name) {
        if (name.length < nameMinLength) {
            $("#name_error").text("The name " + minLengthMessage + " " + nameMinLength + " characters !");
            return false;
        }

        if (name.length > nameMaxLength) {
            $("#name_error").text("The name " + maxLengthMessage + " " + nameMaxLength + " characters !");
            return false;
        }

        if (!nameRegex.test(name)) {
            $("#name_error").text("The name can only contain letters and a dash");
            return false;
        }

        $("#name_error").text("");
        return true;
    }

    function validateFirstName(firstName) {
        if (firstName.length < firstNameMinLength) {
            $("#firstName_error").text("The first name " + minLengthMessage + " " + firstNameMinLength + " characters !");
            return false;
        }

        if (firstName.length > firstNameMaxLength) {
            $("#firstName_error").text("The first name " + maxLengthMessage + " " + firstNameMaxLength + " characters !");
            return false;
        }

        if (!firstNameRegex.test(firstName)) {
            $("#firstName_error").text("The first name can only contain letters and a dash");
            return false;
        }

        $("#firstName_error").text("");
        return true;
    }

    function validateImage(filename) {
        if (filename.length === 0) {
            $("#image_error").text("You must choose an image !");
            return false;
        }
        
        if ($.inArray(filename.split(".").pop().toLowerCase(), allowedFileExtension) === -1) {
            $("#image_error").text("Allowed extensions : jpg, jpeg, png");
            return false;
        }

        $("#image_error").text("");
        return true;
    }

    function validateForm() {

        let validUsername = validateUsername(username.val());
        let validEmail = validateEmail(email.val());
        let validPassword = validatePassword(password.val());
        let validName = validateName(name.val());
        let validFirstName = validateFirstName(firstName.val());
        let validImage = validateImage(image.val());

        let results = [validUsername, validEmail, validPassword, validName, validFirstName, validImage];

        if ($.inArray(false, results) !== -1) {
            return false;
        }

        return true;
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#preview").attr("src", e.target.result).css("width", "50px").css("height", "50px");
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add_preview").click(function ($e) {
        $e.preventDefault();
        image.trigger("click");
    });

    username.on("keyup blur", function () {
        validateUsername($(this).val());
    });

    password.on("keyup blur", function () {
        validatePassword($(this).val());
    });

    email.on("keyup blur", function () {
        validateEmail($(this).val());
    });

    name.on("keyup blur", function () {
        validateName($(this).val());
    });

    firstName.on("keyup blur", function () {
        validateFirstName($(this).val());
    });

    image.change(function () {
        validateImage($(this).val());
        readURL(this);
    });

    function formSubmit() {
        $("#security_form").submit();
    }
  
    window.formSubmit = formSubmit;

    $("#registrationBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            grecaptcha.reset();
            grecaptcha.execute();
        }
    });

    $(window).resize(function () {
        var width = this.innerWidth;

        if (width < 591) {
            $("#already_account").show();
        } else {
            $("#already_account").hide();
        }
    });

    if (window.innerWidth < 591) {
        $("#already_account").show();
    } else {
        $("#already_account").hide();
    }
});