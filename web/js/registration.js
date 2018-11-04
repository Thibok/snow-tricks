$(function() {
  const usernameMinLength = 4;
  const usernameMaxLength = 30;
  const usernameRegex = new RegExp("^[a-z0-9_-]{" + usernameMinLength + ",}$", 'i');
  const passwordMinLength = 8;
  const passwordMaxLength = 48;
  const passwordRegex = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z]).{" + passwordMinLength + ",}$");
  const emailMinLength = 7;
  const emailMaxLength = 70;
  const emailRegex = new RegExp("^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$");
  const nameMinLength = 2;
  const nameMaxLength = 40;
  const firstNameMinLength = 2;
  const firstNameMaxLength = 40;


  const minLengthMessage = "doit faire au minimum";
  const maxLengthMessage = "doit faire au maximum";

  function validateUsername(username) {
    
    if (username.length < usernameMinLength) {
      $('#username_error').text('Le nom d\'utilisateur ' + minLengthMessage + ' ' + usernameMinLength + ' caractères !');
      return;
    } else {
      $('#username_error').text('');
    }

    if (username.length > usernameMaxLength) {
      $('#username_error').text('Le nom d\'utilisateur ' + maxLengthMessage + ' ' + usernameMaxLength + ' caractères !');
      return;
    } else {
      $('#username_error').text('');
    }

    if (!usernameRegex.test(username)) {
      $('#username_error').text('Le nom d\'utilisateur peut être composé de lettres, chiffres et tirets (- _)');
      return;
    } else {
      $('#username_error').text('');
    }
  }

  function validatePassword(password) {

    if (password.length < passwordMinLength) {
      $('#password_error').text('Le mot de passe ' + minLengthMessage + ' ' + passwordMinLength + ' caractères !');
      return;
    } else {
      $('#password_error').text('');
    }

    if (password.length > passwordMaxLength) {
      $('#password_error').text('Le mot de passe ' + maxLengthMessage + ' ' + passwordMaxLength + ' caractères !');
      return;
    } else {
      $('#password_error').text('');
    }

    if (!passwordRegex.test(password)) {
      $('#password_error').text('Le mot de passe doit contenir au moins une lettre et un chiffre');
      return;
    } else {
      $('#password_error').text('');
    }
  }

  function validateEmail(email) {
    if (email.length < emailMinLength) {
      $('#email_error').text('L\'email ' + minLengthMessage + ' ' + emailMinLength + ' caractères !');
      return;
    } else {
      $('#email_error').text('');
    }

    if (email.length > emailMaxLength) {
      $('#email_error').text('L\'email ' + maxLengthMessage + ' ' + emailMaxLength + ' caractères !');
      return;
    } else {
      $('#email_error').text('');
    }

    if (!emailRegex.test(email)) {
      $('#email_error').text('Veuillez saisir une adresse mail valide !');
    } else {
      $('#email_error').text('');
    }
  }

  function validateName(name) {
    if (name.length < nameMinLength) {
      $('#name_error').text('Le nom ' + minLengthMessage + ' ' + nameMinLength + ' caractères !');
      return;
    } else {
      $('#name_error').text('');
    }

    if (name.length > nameMaxLength) {
      $('#name_error').text('Le nom ' + maxLengthMessage + ' ' + nameMaxLength + ' caractères !');
      return;
    } else {
      $('#name_error').text('');
    }
  }

  function validateFirstName(firstName) {
    if (firstName.length < firstNameMinLength) {
      $('#firstName_error').text('Le prénom ' + minLengthMessage + ' ' + firstNameMinLength + ' caractères !');
      return;
    } else {
      $('#firstName_error').text('');
    }

    if (username.length > firstNameMaxLength) {
      $('#firstName_error').text('Le prénom ' + maxLengthMessage + ' ' + firstNameMaxLength + ' caractères !');
      return;
    } else {
      $('#firstName_error').text('');
    }
  }

  $('input').each(function() {
    $(this).css('border', '1px solid grey');
  });
  
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#preview').attr('src', e.target.result).css('width', '100px').css('height', '100px');
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  var inputFile = $("#appbundle_user_image_file").hide();

  $('#add_preview').click(function ($e) {
    $e.preventDefault();

    $('#appbundle_user_image_file').trigger("click");
  });


  $("#appbundle_user_image_file").change(function() {
    readURL(this);
  });

  $('#appbundle_user_username').on('keyup blur', function () {
    validateUsername($(this).val());
  });

  $('#appbundle_user_password').on('keyup blur', function () {
    validatePassword($(this).val());
  });

  $('#appbundle_user_email').on('keyup blur', function () {
    validateEmail($(this).val());
  });

  $('#appbundle_user_name').on('keyup blur', function () {
    validateName($(this).val());
  });

  $('#appbundle_user_firstName').on('keyup blur', function () {
    validateFirstName($(this).val());
  });
});