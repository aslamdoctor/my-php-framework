<div class="login-box">
  <h1 class="text-center">Job Board <b>Media</b></h1>
  <div class="card card-outline card-primary">
    <div class="card-header text-center h4">Master Admin Login</div>
    <div class="card-body">
      <div class="global-message"></div>

      <form id="loginForm" method="POST" action="/system-admin/login/submit">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button id="submitButton" type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-0">
        <a href="/system-admin/forgot-password">I forgot my password</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->



<script>
  $(function () {
    var loginForm = $('#loginForm');
    var submitButton = $('#submitButton');

    loginForm.on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: loginForm.attr('action'),
        data: loginForm.serialize(),
        dataType: "json",
        beforeSend: function(){
          submitButton.attr('disabled', 'true');
          $(".global-message").html('');
        },
        success: function (response) {
          console.log(response);
          $(".global-message").html('<div class="alert alert-success">Logged in. Please wait you are being redirected to dashboard.</div>');
          location.href = response.redirect_to;
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