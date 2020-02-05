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
  @yield('head')
</head>

<body class="sidebar-mini">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- Navbar -->
      @include('layouts._partials.navbar.navbar')

      <!-- Sidebar -->
      @include('layouts._partials.sidebar.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @hasSection ('page-header')
            <div class="section-header">
              @yield('page-header')
            </div>
          @endif

          <div class="section-body">
            @include('layouts._partials.flash-messages')
            @yield('content')
          </div>
        </section>
      </div>

      <!-- Footer -->
      <footer class="main-footer">
        <div class="footer-left">
          <span>Copyright &copy; Corp {{ date('Y') }}</span>
        </div>
      </footer>

    </div>
  </div>

  <!-- Logout Modal-->
  @include('layouts._partials.logout_modal')

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