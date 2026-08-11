<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashion - Fashion Store')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff0f5; color: #444; }
        
        /* Navbar Style */
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 15px 0; }
        .navbar-brand { font-family: 'Pacifico', cursive; color: #e91e63 !important; font-size: 1.8rem; }
        .nav-link { color: #555 !important; font-weight: 500; margin: 0 10px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #e91e63 !important; }
        
        /* Tombol Auth */
        .btn-auth { background: #e91e63; color: white !important; border-radius: 50px; padding: 8px 25px; font-weight: 600; transition: 0.3s; border: none; }
        .btn-auth:hover { background: #c2185b; transform: translateY(-2px); }

        /* Footer Style */
        footer { background-color: #fff; padding: 40px 0; margin-top: 50px; border-top: 5px solid #fce4ec; }

        /* FLOATING WHATSAPP BUTTON STYLE */
        .floating-whatsapp {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            background-color: #25D366; /* Warna WhatsApp */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .floating-whatsapp:hover {
            background-color: #128C7E;
            transform: scale(1.1);
        }
        .floating-whatsapp i {
            color: white;
            font-size: 30px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Dashion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- MENU 1: HOME -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    
                    <!-- MENU 2: PRODUK -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.produk') ? 'active' : '' }}" href="{{ route('pembeli.produk') }}">Produk</a>
                    </li>

                    @auth
                        @if(Auth::user()->role == 'pembeli')
                            <!-- MENU 3: KERANJANG (Hanya Pembeli) -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('keranjang.index') ? 'active' : '' }}" href="{{ route('keranjang.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i> Keranjang
                                </a>
                            </li>

                            <!-- MENU 4: RIWAYAT TRANSAKSI (Hanya Pembeli) -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('transaksi.history') ? 'active' : '' }}" href="{{ route('transaksi.history') }}">
                                    <i class="fas fa-history me-1"></i> Riwayat
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        <!-- DROPDOWN USER -->
                        <div class="dropdown">
                            <a class="btn btn-auth dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i> {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2" style="border-radius: 15px;">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item py-2 text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- TOMBOL LOGIN/DAFTAR -->
                        <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill px-4 fw-bold" style="border: 2px solid #e91e63; color: #e91e63;">Masuk</a>
                        <a href="{{ route('register.form') }}" class="btn btn-auth">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT UTAMA -->
    <div class="main-content" style="min-height: 80vh;">
        @yield('content')
    </div>

    <!-- FLOATING WHATSAPP BUTTON (BARU) -->
    <!-- Logika: User akan dialihkan ke WA Owner dengan pesan default -->
    <a href="https://wa.me/6282136510006?text=Halo%20Owner%20Dashion,%20saya%20tertarik%20dengan%20produk%20Anda." 
       target="_blank" 
       class="floating-whatsapp"
       title="Hubungi Owner via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <h4 style="font-family: 'Pacifico', cursive; color: #e91e63;">Dashion</h4>
            <p class="text-muted small mt-2">Belanja Fashion Wanita Terlengkap & Termurah.</p>
            <p class="text-muted small">&copy; 2025 Dashion. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>