<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-12 d-md-flex justify-content-between align-items-center">
        <h1 class="m-0">Locations</h1>

        <a href="/system-admin/locations/create" class="btn btn-success">Create New</a>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        
        <div class="card">
          <div class="card-body">
            <div class="global-message"></div>

            <table id="rows_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Location</th>
                  <th width="200">Actions</th>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script>
  $(function () {
    // Configure datatable
    var rows_table = $("#rows_table").DataTable({
      "ajax": "/system-admin/locations/ajax_get_all",
      "processing": true,
      "serverSide": true,
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "stateSave": true,
      "paging": true,
      "lengthChange": true,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
      "columnDefs": [
        { orderable: false, targets: -1 }
      ],
      "columns": [                               
          { "data": "name"},
          { defaultContent: 
            '<button class="btn-edit btn btn-info btn-sm"><i class="fas fa-pencil-alt mr-2"></i>Edit</button>' +
            '<button class="btn-delete btn btn-danger btn-sm ml-2" data-delete-id="1"><i class="fas fa-trash mr-2"></i>Delete</button>'
          }
      ]
    });


    $("#rows_table").on("click", ".btn-edit", function () {
      var row_data = $("#rows_table").DataTable().row($(this).parents("tr")).data();
      location.href = '/system-admin/locations/update/' + row_data.ID;
    });
    
    $("#rows_table").on("click", ".btn-delete", function () {
      var row_data = $("#rows_table").DataTable().row($(this).parents("tr")).data();
      var id = row_data.ID;
      if(confirm('Are you sure you want to delete this record?')){
        $.ajax({
          type: "POST",
          url: '/system-admin/locations/delete',
          data: 'id=' + id,
          success: function (response) {
            console.log(response);
            $(".global-message").html('<div class="alert alert-success">Record deleted successfully</div>');
            setTimeout(() => {
              $('.global-message').html('');
            }, 5000);
            // refresh datatable here
            rows_table.ajax.reload();
          },
          error: function (request, status, error) {         
            $('.global-message').html('<div class="alert alert-danger">' + request.responseText + '</div>');
          },
          complete: function(){
          }
        });
      }
    });
  });
</script>