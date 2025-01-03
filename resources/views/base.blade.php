<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>@yield('title') | Commerçame </title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Acceuil</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          @php
              $route = request()->route()->getName();
          @endphp
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a href="{{ route('ventes.index') }}" @class(["nav-link", "active" => str_contains($route, 'cours.')]) aria-current="page">Produits</a>
              </li>
              
            </ul>
            <div class="ms-auto">
              @auth
              <ul class="navbar-nav">
                <li class="nav-item ">
                  {{-- <a href="{{ route('dashboard.index') }}" @class(["nav-link", "fw-bold"]) aria-current="page">Dashboard</a> --}}
                </li>
              </ul> 
              @elseguest
              <ul class="navbar-nav">
                <li class="nav-item ">
                  {{-- <a href="{{ route('login') }}" @class(["nav-link", "fw-bold"]) aria-current="page">Se connecter</a> --}}
                </li>
                <li class="nav-item ">
                  {{-- <a href="{{ route('register') }}" @class(["nav-link", "fw-bold"]) aria-current="page">S'inscrire</a> --}}
                </li>
              </ul> 
              @endauth
            </div>
          </div>
        </div>
    </nav>
 @yield('content')

 {{-- @include('layouts.footer'); --}}
</body>
</html>