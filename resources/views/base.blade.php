<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    {{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script> --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('title') | Mon agence Administration</title>
</head>
<body>
  @php
    $route = request()->route()->getName();
  @endphp
  <header>
    <nav class="navbar navbar-expand-lg bg-primary">
      <div class="container">
        <a class="navbar-brand" href="#">Commerçame</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="{{ route("admin.produit.index")}}" @class(["nav-link", "text-white", "fs-5", "active" => str_contains($route, 'produit.')]) aria-current="page">Stock</a>
            </li>
            <li class="nav-item">
              <a href="{{ route("admin.type.index")}}" @class(["nav-link", "text-white", "fs-5", "active" => str_contains($route, 'type.')]) aria-current="page">Types</a>
            </li>
            <li class="nav-item">
              <a href="{{ route("boutique.vente.index")}}" @class(["nav-link", "text-white", "fs-5", "active" => str_contains($route, 'boutique.')]) aria-current="page">Ventes</a>
            </li>
            <li class="nav-item">
              <a href="{{ route("depense.depense.index")}}" @class(["nav-link", "text-white", "fs-5", "active" => str_contains($route, 'depense.')]) aria-current="page">Dépenses</a>
            </li>
            <li class="nav-item">
              <a href="{{ route("admin.journal.index")}}" @class(["nav-link", "text-white", "fs-5", "active" => str_contains($route, 'journal.')]) aria-current="page">Journal</a>
            </li> 
            <li class="nav-item col-xm-3">
              <a href="#" @class(["nav-link", "bg-info btn link-underline-info"," px-4", "text-white", "fs-5", "active" => str_contains($route, 'contact.')]) aria-current="page">Contact</a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            {{-- Login And Registration button --}}
            <li class="nav-item">
              <a href="{{ route("login")}}" @class(["nav-link", "bg-info btn","mx-2 px-4","link-underline-info", "text-white", "fs-5", "active" => str_contains($route, 'login.')]) aria-current="page">Se connecter</a>
            </li> 
            <li class="nav-item">
              <a href="{{ route("register")}}" @class(["nav-link", "btn","mx-2 px-4", "text-white", "fs-5", "active" => str_contains($route, 'login.')]) aria-current="page">S'inscrire</a>
            </li> 
          </ul>
        </div>
      </div>
    </nav>
  </header>
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session(key: 'success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="my-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    <script>
        // new TomSelect('select');
        // new TomSelect('selectProduit');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>