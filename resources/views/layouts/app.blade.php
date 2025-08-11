<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('material/img/favicon.png') }}">

  <title>NOA - Soluções em cominucação</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="{{ asset('material/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('material/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <link id="pagestyle" href="{{ asset('material/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  @include('layouts.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @includeWhen(View::exists('layouts.topbar'), 'layouts.topbar')

    <div class="container-fluid {{ ($compact ?? false) ? 'py-0' : 'py-2' }}">
      @if(!($compact ?? false) && isset($pageTitle))
      <div class="ms-1 mb-3">
      <h3 class="mb-0 h5 font-weight-bolder">{{ $pageTitle }}</h3>
      @isset($pageSubtitle) <p class="text-sm text-muted">{{ $pageSubtitle }}</p> @endisset
      </div>
    @endif

      @yield('content')
      @includeWhen(View::exists('layouts.footer'), 'layouts.footer')
    </div>
  </main>


  <script src="{{ asset('material/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('material/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('material/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('material/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('material/js/plugins/chartjs.min.js') }}"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>

  <script src="{{ asset('material/js/material-dashboard.min.js?v=3.2.0') }}"></script>
  @stack('scripts')
</body>

</html>