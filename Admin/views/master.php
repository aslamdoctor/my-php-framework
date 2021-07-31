<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{ meta_tags }}

  <title>{{ page_title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/admin/css/adminlte.min.css">

  {{ css_files }}


  <!-- jQuery -->
  <script src="/assets/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/admin/js/adminlte.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include __DIR__."./template-parts/navbar.php";?>
    <?php include __DIR__."./template-parts/sidebar.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      {{ view_file }}
    </div>
    <!-- /.content-wrapper -->


    <?php include __DIR__."./template-parts/footer.php";?>
  </div>
  <!-- ./wrapper -->

  
  {{ js_files }}
</body>
</html>