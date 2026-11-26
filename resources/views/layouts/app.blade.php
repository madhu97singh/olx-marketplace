<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'OLX Marketplace')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f6f7;
        }

        .navbar {
            background: #002f34;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 25px;
        }

        .navbar-brand:hover {
            color: white;
        }

        .main-container {
            min-height: 80vh;
        }

        .auth-card {
            max-width: 450px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .btn-marketplace {
            background: #002f34;
            color: white;
        }

        .btn-marketplace:hover {
            background: #00474d;
            color: white;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            OLX Marketplace
        </a>

        <div class="ms-auto">

            @guest

                <a href="{{ route('login') }}"
                   class="btn btn-outline-light me-2">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="btn btn-light">
                    Register
                </a>

            @else

                <a href="{{ route('home') }}"
                class="btn btn-outline-light me-2">
                    Home
                </a>

                <a href="{{ route('listings.mine') }}"
                class="btn btn-outline-light me-2">
                    My Listings
                </a>

                <a href="{{ route('listings.create') }}"
                class="btn btn-light me-2">
                    + Sell
                </a>

                <span class="text-white me-3">
                    Hello, {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}"
                    method="POST"
                    class="d-inline">

                    @csrf

                    <button type="submit" class="btn btn-light">
                        Logout
                    </button>

                </form>

            @endguest

        </div>

    </div>
</nav>

<div class="container main-container">

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

<footer class="text-center py-3 bg-white">
    <p class="mb-0">
        © {{ date('Y') }} OLX Marketplace. All Rights Reserved.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>