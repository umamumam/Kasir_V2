<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir App</title>
    <!-- Menggunakan Bootstrap CDN untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Styling tambahan untuk header dan navbar */
        .navbar {
            background-color: #3498db;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
            margin-left: 30px;
            font-size: 24px;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-size: 16px;
            padding: 12px 18px;
            margin-right: 30px;
            transition: color 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
            background-color: #2980b9;
            border-radius: 5px;
        }

        .container {
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 40px;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .content-header {
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
            font-size: 28px;
            letter-spacing: 1px;
        }

        /* Animasi untuk alert */
        .alert-success {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Styling untuk tombol close alert */
        .btn-close {
            background-color: #3498db;
            border-radius: 50%;
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
            background-color: #2980b9;
        }

        /* Efek Hover untuk Navbar */
        .navbar-toggler-icon {
            background-color: #ffffff;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 20px;
            }

            .navbar-nav .nav-link {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Menggunakan container-fluid untuk navbar agar memenuhi seluruh lebar layar -->
    <nav class="navbar navbar-expand-lg navbar-light w-100">
        <a class="navbar-brand" href="{{ url('/transaksi') }}">Kasir App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if(Auth::check()) <!-- Cek jika pengguna sudah login -->
                    @if(Auth::user()->role == 'admin')
                        <!-- Menu untuk Admin -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Manajemen User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('menus.index') }}">Manajemen Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('penerimaan.index') }}">Penerimaan Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('produk.index') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logs.index') }}">Log Riwayat</a>
                        </li>
                    @elseif(Auth::user()->role == 'kasir')
                        <!-- Menu untuk Kasir -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transaksi.index') }}">Transaksi</a>
                        </li>
                    @endif
                    <!-- Tombol Logout -->
                    <li class="nav-item">
                        <form action="{{ url('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- Jika pengguna belum login -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
    

    <div class="container mt-4">
        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Menampilkan konten halaman yang dinamis -->
        @yield('content')

    </div>
</body>
</html>
