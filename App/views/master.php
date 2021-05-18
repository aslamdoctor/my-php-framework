<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{ meta_tags }}

  <title>{{ page_title }}</title>

  <link rel="stylesheet" href="/assets/dist/css/app.css" />

  {{ css_files }}

</head>
<body>
  {{ view_file }}
  
  <script src="/assets/dist/js/app.js"></script>
  
  {{ js_files }}
</body>
</html>