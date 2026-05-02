<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
  <title>@yield('title', 'Ecommerce')</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" />
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/app-ui.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
  @stack('styles')
</head>
<body class="app-auth-page">
  <header class="app-auth-topbar">
    <a href="{{ route('front.index') }}" class="app-auth-brand">Ecommerce</a>
    <a href="{{ route('front.index') }}" class="app-auth-back">← Accueil</a>
  </header>

  <main class="app-auth-main">
    @yield('content')
  </main>

  <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  @stack('scripts')
</body>
</html>
