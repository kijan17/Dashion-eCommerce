<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Dashion Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f9; }
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2c3e50; /* Darker shade for contrast */
            padding-top: 20px;
            color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        #content {
            margin-left: 250px;
            padding: 20px;
        }
        .sidebar-header {
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header h4 {
            font-weight: 700;
            margin-bottom: 0;
            color: #ecf0f1;
        }
        .sidebar-menu .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar-menu .nav-link:hover {
            color: white;
            background-color: #34495e;
        }
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: #e74c3c; /* Warna utama Dashion (Pink/Merah) */
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.4);
            font-weight: 600;
        }
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
        .navbar-top {
            background-color: white;
            border-radius: 10px;
            padding: 10px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #ff80ab 0%, #e91e63 100%);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            opacity: 0.9;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="sidebar-header">
            <!-- LOGIKA JUDUL SIDEBAR DINAMIS -->
            @auth
                @if(Auth::user()->role === 'admin')
                    <h4 class="text-info">Dashion Admin</h4>
                    <p class="small text-muted mb-0">Menu Administrator</p>
                @else
                    <h4 class="text-danger">Dashion Owner</h4>
                    <p class="small text-muted mb-0">Menu Toko</p>
                @endif
            @endauth
        </div>
        
        <div class="sidebar-menu px-3">
            <ul class="nav flex-column">
                @auth
                    
                    @if(Auth::user()->role === 'admin')
                        <!-- MENU KHUSUS ADMIN -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
                            </a>
                        </li>
                       
                    @elseif(Auth::user()->role === 'owner')
                        <!-- MENU KHUSUS OWNER -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produk.index', 'kategori.index') ? 'active' : '' }}" 
                               href="{{ route('produk.index') }}">
                                <i class="fas fa-box me-2"></i> Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('hutang.index', 'hutang.riwayat') ? 'active' : '' }}" 
                               href="{{ route('hutang.index') }}">
                                <i class="fas fa-hand-holding-usd me-2"></i> Kelola Hutang
                            </a>
                        </li>
                    
                    @endif

                @endauth
            </ul>
        </div>
        
        <div class="position-absolute bottom-0 w-100 p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn logout-btn w-100 py-3">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Konten Utama -->
    <div id="content">
        <div class="navbar-top">
            @auth
                <!-- Tampilkan Role User di Header Top -->
                <h5 class="mb-0 fw-bold text-muted">Dashboard {{ ucfirst(Auth::user()->role) }}</h5>
                <span class="badge rounded-pill bg-light text-dark py-2 px-3 shadow-sm">
                    Halo, {{ Auth::user()->username }}!
                </span>
            @endauth
        </div>
        
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>