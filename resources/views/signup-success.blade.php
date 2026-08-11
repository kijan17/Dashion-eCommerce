<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #fce4ec;
        }
        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-weight: 400;
            font-size: 2.2rem;
            color: #d81b60 !important;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }
        .nav-link {
            color: #d81b60 !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ff80ab !important;
        }
        .hero-section {
            background-color: #fffafc;
            color: #d81b60;
            padding: 50px 0;
            text-align: center;
            border-bottom: 5px solid #f8bbd0;
        }
        .hero-section h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
        }
        .hero-section p.lead {
            font-family: 'Quicksand', sans-serif;
            font-size: 1.25rem;
        }
        .card {
            margin-top: 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            border: none;
            overflow: hidden;
            background-color: #fffafa;
        }
        .card-body {
            color: #6a1b9a;
        }
        .card-title {
            font-family: 'Pacifico', cursive;
            color: #d81b60;
            font-weight: 400;
            font-size: 1.6rem;
        }
        .btn-dashion-primary {
            background-color: #d81b60;
            border-color: #d81b60;
            color: white;
            border-radius: 50px;
            font-family: 'Quicksand', sans-serif;
            padding: 10px 25px;
            font-size: 1.1rem;
        }
        .btn-dashion-primary:hover {
            background-color: #ad1457;
            border-color: #ad1457;
            color: white;
        }
        .btn-success {
            background-color: #d81b60;
            border-color: #d81b60;
        }
        .btn-success:hover {
            background-color: #ad1457;
            border-color: #ad1457;
        }
        .btn-warning {
            background-color: #f06292;
            border-color: #f06292;
        }
        .btn-warning:hover {
            background-color: #ec407a;
            border-color: #ec407a;
        }
        .footer {
            margin-top: 80px;
            padding: 30px 0;
            background-color: #ffdce5;
            text-align: center;
            border-top: 1px solid #f8bbd0;
        }
        .footer p {
            margin: 0;
            font-size: 0.95rem;
            color: #d81b60;
            font-family: 'Quicksand', sans-serif;
        }
        .hero-section .btn {
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Dashion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Koleksi Terbaru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Aksesori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1>Welcome {{$name}}</h1>
            <p class="lead">Berikut info sign up yang dilakukan:</p>
            <a href="#" class="btn btn-dashion-primary btn-lg mt-3">{{$email}}</a>
            <a href="#" class="btn btn-dashion-primary btn-lg mt-3">{{$password}}</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Dashion. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
