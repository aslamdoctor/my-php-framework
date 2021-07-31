<script>
  $(function () {
    var createForm = $('#createForm');
    var createButton = $('#createButton');

    createForm.on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: createForm.attr('action'),
        data: createForm.serialize(),
        dataType: "json",
        beforeSend: function(){
          createButton.attr('disabled', 'true');
          $(".global-message").html('');
          $(".validation-error").html('');
        },
        success: function (response) {
          console.log(response);
          createForm.trigger('reset');
          $(".global-message").html('<div class="alert alert-success">Record added successfully</div>');
        },
        error: function (request, status, error) {         
          if(request.status==500){
            $.each(request.responseJSON, function (index, value) { 
              createForm.find('[data-error-element="' + index + '"]').html(value);
            });
          }
          else{
            $('.global-message').html('<div class="alert alert-danger">' + request.responseText + '</div>');
          }
        },
        complete: function(){
          createButton.removeAttr('disabled');
        }
      });
    });
  });
</script>