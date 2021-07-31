<script>
  $(function () {
    var updateForm = $('#updateForm');
    var updateButton = $('#updateButton');

    updateForm.on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: updateForm.attr('action'),
        data: updateForm.serialize(),
        dataType: "json",
        beforeSend: function(){
          updateButton.attr('disabled', 'true');
          $(".global-message").html('');
          $(".validation-error").html('');
        },
        success: function (response) {
          console.log(response);
          $(".global-message").html('<div class="alert alert-success">Record updated successfully</div>');
        },
        error: function (request, status, error) {         
          if(request.status==500){
            $.each(request.responseJSON, function (index, value) { 
              updateForm.find('[data-error-element="' + index + '"]').html(value);
            });
          }
          else{
            $('.global-message').html('<div class="alert alert-danger">' + request.responseText + '</div>');
          }
        },
        complete: function(){
          updateButton.removeAttr('disabled');
        }
      });
    });

    // Toggle change password wrapper
    $('#change_password_switch').on('change', function (e) {
      if($(this).prop('checked') == true){
        $('.password-fields-wrapper').removeClass('d-none');
      }
      else{
        $('.password-fields-wrapper').addClass('d-none');
      }
    });
  });
</script>