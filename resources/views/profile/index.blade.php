<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Profil Saya</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="text-center mb-3">
                            <label class="form-label d-block">Foto Profil</label>
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/150' }}" 
                                alt="Profile Picture" 
                                class="img-thumbnail profile-picture">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" class="form-control" value="{{ $user->nohp ?? '-' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="2" disabled>{{ $user->alamat ?? '-' }}</textarea>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Ganti Foto Profil</label>
                                <input type="file" class="form-control" name="profile_picture" accept="image/*">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Update Foto
                                </button>
                                <a class="btn btn-danger" href="{{ route('home') }}">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
