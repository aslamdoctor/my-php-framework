<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Locations</h1>
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
          <form id="createForm" method="POST" action="/system-admin/locations/create/save">
            <div class="card-body">
              <div class="global-message"></div>

              <div class="form-group">
                <label for="name">Location Name</label>
                <input type="text" class="form-control" name="name" placeholder="">
                <span class="validation-error  text-danger" data-error-element="name"></span>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <div class="d-flex justify-content-end">
                <a href="/system-admin/locations/" class="btn btn-default mr-3">Back</a>
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