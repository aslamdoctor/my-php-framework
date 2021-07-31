<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Admins</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-6 col-lg-8">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Update</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="updateForm" method="POST" action="/system-admin/admins/update/save">
            <input type="hidden" name="id" value="<?php echo $admin['ID'];?>">
            <div class="card-body">
              <div class="global-message"></div>

              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="" value="<?php echo $admin['first_name'];?>">
                <span class="validation-error text-danger" data-error-element="first_name"></span>
              </div>

              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="" value="<?php echo $admin['last_name'];?>">
                <span class="validation-error text-danger" data-error-element="last_name"></span>
              </div>


              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="" value="<?php echo $admin['email'];?>" <?php echo ($admin['type']=='superadmin') ? 'readonly' : '';?>>
                <span class="validation-error text-danger" data-error-element="email"></span>
              </div>

              <?php if( (\Core\Session::get('user')['type']=='superadmin') || ($admin['type']!='superadmin' && \Core\Session::get('user')['type']=='admin') ):?>

              <div class="form-group">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="change_password_switch" name="change_password_switch" value="1">
                  <label class="form-check-label" for="change_password_switch">Change Password</label>
                </div>
              </div>

              <div class="password-fields-wrapper d-none">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="">
                  <span class="validation-error  text-danger" data-error-element="password"></span>
                </div>

                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" class="form-control" name="confirm_password" placeholder="">
                  <span class="validation-error  text-danger" data-error-element="confirm_password"></span>
                </div>
              </div>
              <?php endif;?>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <div class="d-flex justify-content-end">
                <a href="/system-admin/admins/" class="btn btn-default mr-3">Back</a>
                <button id="updateButton" type="submit" class="btn btn-success btn-submit">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?php include __DIR__."./../template-parts/update_form_js.php";?>