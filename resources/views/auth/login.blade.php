<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Dashion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #fce4ec; /* Warna pink muda */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border: none;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .brand-title {
            color: #e91e63; /* Warna pink tua */
            font-weight: bold;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #e91e63;
            border: none;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #c2185b;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }
        .register-link a {
            color: #e91e63;
            text-decoration: none;
            font-weight: bold;
        }
        /* Tombol Google */
        .btn-google {
            background-color: #4285F4;
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-google:hover {
            background-color: #357ae8;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="brand-title">Dashion</div>
        <p class="text-center text-muted mb-4">Masuk ke Akun Pembeli</p>

        <!-- Menampilkan Pesan Sukses/Error -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Menampilkan Error Validasi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Login Biasa -->
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            
            <!-- Username -->
            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>

            <!-- Password -->
            <input type="password" name="password" class="form-control" placeholder="Password" required>

            <button type="submit" class="btn btn-primary">MASUK</button>
        </form>

        <div class="text-center my-3 text-muted">ATAU</div>

        <!-- TOMBOL GOOGLE -->
        <a href="{{ route('redirect.google') }}" class="btn btn-google w-100" style="border-radius: 10px; padding: 12px; font-weight: bold;">
            <i class="fab fa-google me-2"></i> Login with Google
        </a>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register.form') }}">Daftar Sekarang</a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>