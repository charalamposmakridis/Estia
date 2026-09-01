<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, user-scalable=no,
          initial-scale=1.0, maximum-scale=1.0,
          minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <title>Estia</title>
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <a href="{{route('listings.index')}}" class="logo">Estia</a>
        @auth
            <div class="profile">
                <a href="{{ route('profile.edit') }}" class="profile-link">
                    <span>{{ Auth::user()->name }}</span>
                </a>
            </div>
        @endauth

        <form action="{{route('listings.index')}}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search city or title..." value="{{request('search')}}">
            <button type="submit" class="btn-search">Search</button>
        </form>

        <div class="nav-links">
            @auth
                <a href="{{route('bookings.index')}}">My Bookings</a>
                <a href="{{route('favourites.index')}}">Favourites</a>
                <a href="{{route('listings.create')}}">Create Listing</a>
                <a href="{{ route('listings.user') }}">My Listings</a>
                <a href="{{ route('bookings.owner') }}">Reservations for My Listings</a>

                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else
                <a href="{{route('login')}}">LogIn</a>
                <a href="{{route('register')}}" class="btn-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>

<div></div>

@if(session('success'))
    <div class="alert alert-message">
        {{session('success')}}
    </div>
@endif

<main class="container">
    @yield('content')
</main>

<footer>
    <p>&copy; {{date('Y')}} Estia.All rights reserved.</p>
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>
</html>
