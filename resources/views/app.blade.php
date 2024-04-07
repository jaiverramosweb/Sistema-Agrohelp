<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- WOLKELLER 3 -->

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/assets/admin-lte/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/admin-lte/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="stylesheet" href="/assets/css/styles.css">
        
        @routes
          @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <style>
          
        </style>

    </head>

    <body id="body_id" class=" hold-transition sidebar-mini ">
      
      @inertia

      <!-- jQuery -->
      <script src="/assets/admin-lte/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="/assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="/assets/admin-lte/dist/js/adminlte.min.js"></script>

    </body>

</html>
