<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Segoe+UI&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.blade.css') }}">
    @yield('css')
    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/ride.png') }}">
</head>

<body>
    <nav data-baseweb="header-navigation" role="navigation" class="navbar-uber">
        <div class="d-flex align-items-center w-100 justify-content-between">
            @php
                $user = session('user');
            @endphp
            <ul>
                @if (!$user || $user['role'] === 'client')
                    <li>
                        <a data-baseweb="link" href="{{ url('./') }}" target="_self">
                            <img src="/img/UberLogo.png" alt="Uber Logo" class="logo-image">
                        </a>
                    </li>
                @else
                    <li>
                        <img src="/img/UberLogo.png" alt="Uber Logo" class="logo-image">
                    </li>
                @endif
            </ul>
            <ul class="ul-links">
                @if ($user && $user['role'] === 'coursier')
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Accéder aux courses"
                            href="{{ route('coursier.courses.index') }}" target="_self" class="header-links">Courses</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les détails d'entretien"
                            href="{{ route('coursier.entretien') }}" target="_self" class="header-links">Entretiens
                            Uber</a>
                    </li>
                    <li>
                        <a href="{{ route('conducteurs.demandes', $user['id']) }}" class="header-links">Demandes
                            d'aménagement(s)</a>
                    </li>
                @endif

                @if ($user && $user['role'] === 'rh')
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les entretiens en attente"
                            href="{{ route('entretiens.index') }}" target="_self" class="header-links">Entretiens en
                            Attente</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les entretiens planifiés"
                            href="{{ route('entretiens.plannifies') }}" target="_self"
                            class="header-links">Planifiés</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les entretiens terminés"
                            href="{{ route('entretiens.termines') }}" target="_self" class="header-links">Terminés</a>
                    </li>
                @endif

                @if ($user && $user['role'] === 'logistique')
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Ajouter un véhicule"
                            href="{{ route('logistique.coursiers.select') }}" target="_self"
                            class="header-links">Ajouter Véhicule</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les véhicules disponibles"
                            href="{{ route('logistique.vehicules') }}" target="_self"
                            class="header-links">Véhicules</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Gérer les modifications"
                            href="{{ route('logistique.modifications') }}" target="_self"
                            class="header-links">Aménagements</a>
                    </li>
                @endif

                @if ($user && $user['role'] === 'facturation')
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Voir les courses d'un coursier"
                            href="{{ url('/Uber/facturation') }}" target="_self" class="header-links">Facturation</a>
                    </li>
                @endif

                @if (!$user || $user['role'] === 'client')
                    <li class="pr-1">
                        <a href="{{ url('./') }}" class="header-links">Réserver un Uber</a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="En savoir plus sur Uber&nbsp;Eats"
                            href="{{ url('/UberEats') }}" target="_self" class="header-links">Uber&nbsp;Eats
                        </a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="En savoir plus sur Uber&nbsp;Velo"
                            href="{{ url('/UberVelo') }}" target="_self" class="header-links">Uber&nbsp;Velo
                        </a>
                    </li>
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Besoin d'aide" href="{{ url('/Uber/guide') }}"
                            target="_self"class="header-links">Besoin&nbsp;d'aide&nbsp;?
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="d-flex align-items-center">
                @if ($user)
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Accéder à votre compte" href="{{ url('/mon-compte') }}"
                            class="a-login">Mon Compte</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="a-register" type="submit">Se déconnecter</button>
                        </form>
                    </li>
                @else
                    <li class="pr-1">
                        <a data-baseweb="button" aria-label="Se connecter à votre compte"
                            href="{{ url('/interface-connexion') }}" class="a-login">Connexion</a>
                    </li>
                    <li>
                        <a data-baseweb="button" aria-label="Créer un compte"
                            href="{{ url('/interface-inscription') }}" class="a-register">Inscription</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>


    <div class="container">

        @yield('content')
    </div>

    @yield('js')
</body>

</html>