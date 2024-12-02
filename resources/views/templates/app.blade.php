<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='csrf-token' content="{{csrf_token()}}">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @stack('style')
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/wk.png')}}">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Apotek</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('welcome') ? 'active' : ''}}" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        {{-- pemanggilan route pada href:
                        1.menggunakan path 
                        2.menggunakan name -> {{ route('landing-page') }} --}}
                        <a class="nav-link {{ Route::is('landing-page') ? 'active' : ''}}" href="{{ route('landing-page') }}">Landing</a>
                    </li>
                    @if (Auth::user()->role=='admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('medicines') ? 'active' : ''}}" href="{{ route('medicines') }}">Data Obat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('users') ? 'active' : ''}}" href="{{ route('users') }}">akun</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('orders.admin') }}" class="nav-link">Data Pembelian</a>
                    </li>
                    @endif
                    @if (Auth::user()->role=='kasir')
                    <li class="nav-item">
                        <a href="{{ route('orders') }}" class="nav-link">Pembelian</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout')}}">Logout</a>
                    </li>
                </ul>
                @if (Route::is ('medicines'))
                   <form class="d-flex" role="search" action="{{ route('medicines') }}" method="GET">
                @else 
                 <form class="d-flex" role="search" action="{{ route('users') }}" method="GET">
                @endif
                    {{-- mengaktifkan form di laravel :
                        1 di <form> ada action dan method
                            GET digunakan ketika form berfungsi buat search
                            POST buat nambah / ngapus data
                        2 ada button type submit 
                        3 di <input> harus ada name
                        4 @csrf
                        5 action --}}
                    <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="search_obat">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            @endif

        </div>
    </nav>
    <!-- Wadah untuk menampung konten yang berbeda ditiap halaman -->
    @yield('content-dinamis')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @stack('script')
</body>

</html>