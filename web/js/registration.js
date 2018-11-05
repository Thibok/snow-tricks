$(function() {

    const usernameMinLength = 4;
    const usernameMaxLength = 30;
    const usernameRegex = new RegExp('^[a-z0-9_-]{' + usernameMinLength + ',}$', 'i');
    const passwordMinLength = 8;
    const passwordMaxLength = 48;
    const passwordRegex = new RegExp('^(?=.*[0-9])(?=.*[a-zA-Z]).{' + passwordMinLength + ',}$');
    const emailMinLength = 7;
    const emailMaxLength = 70;
    const emailRegex = new RegExp('^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$')
    const nameMinLength = 2;
    const nameMaxLength = 40;
    const nameRegex = new RegExp('^[a-z]+-?[a-z]{1,}$', 'i');
    const firstNameMinLength = 2;
    const firstNameMaxLength = 40;
    const firstNameRegex = new RegExp('^[a-z]+-?[a-z]{1,}$', 'i');
    const allowedFileExtension = ['jpg', 'jpeg', 'png'];

    const minLengthMessage = "doit faire au minimum";
    const maxLengthMessage = "doit faire au maximum";

    function validateUsername(username) {
        
        if (username.length < usernameMinLength) {
        $('#username_error').text('Le nom d\'utilisateur ' + minLengthMessage + ' ' + usernameMinLength + ' caractères !');
        return false;
        }

        if (username.length > usernameMaxLength) {
        $('#username_error').text('Le nom d\'utilisateur ' + maxLengthMessage + ' ' + usernameMaxLength + ' caractères !');
        return false;
        }

        if (!usernameRegex.test(username)) {
        $('#username_error').text('Le nom d\'utilisateur peut être composé de lettres, chiffres et tirets (- _)');
        return false;
        }

        $('#username_error').text('');
        return true;
    }

    function validatePassword(password) {

        if (password.length < passwordMinLength) {
        $('#password_error').text('Le mot de passe ' + minLengthMessage + ' ' + passwordMinLength + ' caractères !');
        return false;
        }

        if (password.length > passwordMaxLength) {
        $('#password_error').text('Le mot de passe ' + maxLengthMessage + ' ' + passwordMaxLength + ' caractères !');
        return false;
        }

        if (!passwordRegex.test(password)) {
        $('#password_error').text('Le mot de passe doit contenir au moins une lettre et un chiffre');
        return false;
        }

        $('#password_error').text('');
        return true;
    }

    function validateEmail(email) {
        if (email.length < emailMinLength) {
        $('#email_error').text('L\'email ' + minLengthMessage + ' ' + emailMinLength + ' caractères !');
        return false;
        }

        if (email.length > emailMaxLength) {
        $('#email_error').text('L\'email ' + maxLengthMessage + ' ' + emailMaxLength + ' caractères !');
        return false;
        }

        if (!emailRegex.test(email)) {
        $('#email_error').text('Le nom ne peut contenir que des lettres et un tiret');
        return false;
        }

        $('#email_error').text('');
        return true;
    }

    function validateName(name) {
        if (name.length < nameMinLength) {
        $('#name_error').text('Le nom ' + minLengthMessage + ' ' + nameMinLength + ' caractères !');
        return false;
        }

        if (name.length > nameMaxLength) {
        $('#name_error').text('Le nom ' + maxLengthMessage + ' ' + nameMaxLength + ' caractères !');
        return false;
        }

        if (!nameRegex.test(name)) {
        $('#name_error').text('Le nom ne peut contenir que des lettres et un tiret');
        return false;
        }

        $('#name_error').text('');
        return true;
    }

    function validateFirstName(firstName) {
        if (firstName.length < firstNameMinLength) {
        $('#firstName_error').text('Le prénom ' + minLengthMessage + ' ' + firstNameMinLength + ' caractères !');
        return false;
        }

        if (firstName.length > firstNameMaxLength) {
        $('#firstName_error').text('Le prénom ' + maxLengthMessage + ' ' + firstNameMaxLength + ' caractères !');
        return false;
        }

        if (!firstNameRegex.test(firstName)) {
        $('#firstName_error').text('Le prénom ne peut contenir que des lettres et un tiret');
        return false;
        }

        $('#firstName_error').text('');
        return true;
    }

    function validateImage(filename) {
        if ($.inArray(filename.split('.').pop().toLowerCase(), allowedFileExtension) == -1) {
        $('#image_error').text('Extensions autorisées : jpg, jpeg, png');
        return false;
        }

        $('#image_error').text('');
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
            $('#preview').attr('src', e.target.result).css('width', '50px').css('height', '50px');
        }

        reader.readAsDataURL(input.files[0]);
        }
    }

    var username = $('#appbundle_user_username');
    var password = $('#appbundle_user_password');
    var email = $('#appbundle_user_email');
    var name = $('#appbundle_user_name');
    var firstName = $('#appbundle_user_firstName');
    var image = $('#appbundle_user_image_file');

    $('input').each(function() {
        $(this).css('border', '1px solid grey');
    });

    image.hide();

    $('#add_preview').click(function ($e) {
        $e.preventDefault();

        image.trigger("click");
    });

    username.on('keyup blur', function () {
        validateUsername($(this).val());
    });

    password.on('keyup blur', function () {
        validatePassword($(this).val());
    });

    email.on('keyup blur', function () {
        validateEmail($(this).val());
    });

    name.on('keyup blur', function () {
        validateName($(this).val());
    });

    firstName.on('keyup blur', function () {
        validateFirstName($(this).val());
    });

    image.change(function () {
        validateImage($(this).val());
        readURL(this);
    })

    $('#registration_form').submit(function () {
        if (!validateForm()) {
        return false;
        }
    });
});