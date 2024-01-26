<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="{{ asset('images/logo-removed.png') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand brand-name" href="{{ route('beranda') }}">
                    {{ config('app.name', 'ShCraft') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('jasa') ? 'active' : '' }}" href="{{ route('jasa.index') }}">{{ __('Jasa') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('order') ? 'active' : '' }}" href="{{ route('order.index') }}">{{ __('Order') }}</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nama }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('role-create')
                                        <a href="{{ route('roles.index') }}" class="dropdown-item">Role</a>
                                    @endcan
                                    
                                    <a href="{{ route('users.index') }}" class="dropdown-item {{ Request::is('users') ? 'active' : '' }}">
                                        @can('user-create')
                                            User
                                        @else
                                            Profil Saya
                                        @endif
                                    </a>

                                    <a href="{{ route('keranjang.index') }}" class="dropdown-item {{ Request::is('keranjang') ? 'active' : '' }}">Keranjang Saya</a>
                                    
                                    @can('jasa-create')
                                        <a href="{{ route('jasa.user', Auth::user()->id) }}" class="dropdown-item {{ (request()->is('jasa/user*')) ? 'active' : '' }}">Jasa Saya</a>
                                    @endcan

                                    <a href="{{ route('order.penjual') }}" class="dropdown-item {{ (request()->is('order/penjual')) ? 'active' : '' }}">
                                    @can('role-create')
                                        Seluruh Order
                                    @else
                                        @can('order-penjual')
                                            Order Saya
                                        @endcan
                                    @endcan
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <div class="jumbotron" id="jumbo-footer">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-md-9 mt-2 mb-3">
                            <h3 class="font-white font-bold">Contact Us</h3>
                            <span class="font-white">+62 811 1111 1111</span>
                            <br/>
                            <span class="font-white">jasaku@gmail.com</span>
                            <br/>
                            <span class="font-white">34, PIK, Jakarta Timur, Indonesia</span>
                        </div>
                        <div class="col-md-3">
                            <h3 class="font-white font-bold mb-3">Social Media</h3>
                            <i class="fab fa-facebook icon-font-large font-white mr-3"></i>
                            <i class="fab fa-instagram icon-font-large font-white mr-3"></i>
                            <i class="fab fa-twitter-square icon-font-large font-white mr-3"></i>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </div>
</body>
</html>
