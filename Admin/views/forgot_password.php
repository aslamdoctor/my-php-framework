<div class="login-box">
  <h1 class="text-center">Job Board <b>Media</b></h1>

  <div class="card card-outline card-primary">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <div class="global-message"></div>

      <form id="forgotPasswordForm" method="POST" action="/system-admin/forgot-password/submit">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button id="submitButton" type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-0">
        <a href="/system-admin/login">Return to Login Page</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<script>
  $(function () {
    var forgotPasswordForm = $('#forgotPasswordForm');
    var submitButton = $('#submitButton');

    forgotPasswordForm.on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: forgotPasswordForm.attr('action'),
        data: forgotPasswordForm.serialize(),
        dataType: "json",
        beforeSend: function(){
          submitButton.attr('disabled', 'true');
          $(".global-message").html('');
        },
        success: function (response) {
          console.log(response);
          forgotPasswordForm.trigger('reset');
          $(".global-message").html('<div class="alert alert-success">Your password has been reset, and will be sent to you via e-mail.</div>');
        },
        error: function (request, status, error) {         
          if(request.status==500){
            var validation_errors = '<ul class="mb-0 pl-3">';
            $.each(request.responseJSON, function (index, value) { 
              validation_errors += '<li>' + value + '</li>';
            });
            validation_errors += '</ul>';
            $('.global-message').html('<div class="alert alert-danger">' + validation_errors + '</div>');
          }
          else{
            $('.global-message').html('<div class="alert alert-danger">' + request.responseText + '</div>');
          }
        },
        complete: function(){
          submitButton.removeAttr('disabled');
        }
      });
    });
  });
</script>