$(function() {
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

  
});