<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="description" content="Base Laravel Application">
  <meta name="author" content="Lucas Luan Pontarolo">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Title -->
  <title>{{ config('app.name') }}@hasSection ('title') - @yield('title')@endif</title>

  <!-- Favicon icon -->
  <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">

  <!-- Main css -->
  <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">

  <!-- Page Specific Head -->
  @yield('header')
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand mt-0">{{ config('app.name') }}</div>
          </div>
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            @yield('content')
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Core JS -->
  <script src="{{ mix('assets/js/manifest.js') }}"></script>
  <script src="{{ mix('assets/js/vendor.js') }}"></script>
  <script src="{{ mix('assets/js/app.js') }}"></script>

  <!-- JS Libraies -->
  @stack('page_libraries_scripts')

  <!-- Page Specific JS File -->
  @stack('page_specific_scripts')
</body>

</html>