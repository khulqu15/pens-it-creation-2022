<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <!-- Navbar start -->
  <nav class="navbar navbar-expand-lg bg-sealight">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('img/himit-fest-logo.png') }}" alt="Logo Himit Fest" width="50">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-semibold">
          <li class="nav-item">
            <a class="nav-link active" href="#" style="color: #126686">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Timeline</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Partner</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar end -->

  <!-- Home section start -->
  <section id="home" class="bg-sealight">
    <div class="text-center container">
      <div class="py-5">
        <h1>HIMIT</h1>
        <h1>FEST 2022</h1>
      </div>
    </div>
  </section>
  <!-- Home section end -->
</body>

</html>