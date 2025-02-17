<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
        .hero {
            background: url('https://source.unsplash.com/1600x600/?hospital') no-repeat center center;
            background-size: cover;
            height: 400px;
        }
        .profile-picture {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Rumah Sakit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('dktr') }}">CRUD Doktor</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('ruangan') }}">CRUD Ruangan</a>
                            </li>
                        @endif
                    @endauth
                    <li class="nav-item dropdown">
                        @auth
                            <!-- Dropdown Profil & Logout -->
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_picture)
    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="profile-picture me-2" alt="Foto Profil">
@else
    <img src="{{ asset('images/default-profile.png') }}" class="profile-picture me-2" alt="Foto Default">
@endif

                            </a>    
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('actionLogout') }}" method="GET">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <!-- Jika belum login, tampilkan tombol login -->
                            <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mt-5 main-content">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="fw-bold">Selamat Datang di Rumah Sakit</h1>
                <p class="lead">Kami siap memberikan pelayanan kesehatan terbaik untuk Anda dan keluarga.</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('img/home.jpg') }}" alt="Rumah Sakit" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        &copy; 2025 Rumah Sakit. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
