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
            <h3 class="card-title">Create</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="createForm" method="POST" action="/system-admin/admins/create/save">
            <div class="card-body">
              <div class="global-message"></div>

              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="">
                <span class="validation-error  text-danger" data-error-element="first_name"></span>
              </div>

              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="">
                <span class="validation-error  text-danger" data-error-element="last_name"></span>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="">
                <span class="validation-error  text-danger" data-error-element="email"></span>
              </div>

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
            <!-- /.card-body -->

            <div class="card-footer">
              <div class="d-flex justify-content-end">
                <a href="/system-admin/admins/" class="btn btn-default mr-3">Back</a>
                <button id="createButton" type="submit" class="btn btn-success btn-submit">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?php include __DIR__."./../template-parts/create_form_js.php";?>