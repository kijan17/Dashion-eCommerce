<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashion')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>

        body {

            font-family: 'Poppins', sans-serif;

            background-color: #FCEFF5; /* Warna pink muda */

            display: flex;

            justify-content: center;

            align-items: center;

            min-height: 100vh;

            margin: 0;

        }



        .auth-container {

            background: #fff;

            padding: 40px 35px;

            border-radius: 25px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);

            max-width: 400px;

            width: 100%;

            text-align: center;

            box-sizing: border-box;

        }



        .auth-container h1 {

            color: #E91E63; /* Pink tua */

            margin-top: 0;

            margin-bottom: 5px;

            font-size: 2.5em;

            font-weight: 700;

        }



        .auth-container h2 {

            color: #fcb9dfff;

            margin-bottom: 30px;

            font-weight: 400;

            font-size: 1.2em;

        }



        .auth-container form {

            display: flex;

            flex-direction: column;

            gap: 15px; /* Jarak antar input */

        }



        .auth-container input[type="text"],

        .auth-container input[type="password"],

        .auth-container input[type="date"],

        .auth-container textarea {

            width: 100%;

            padding: 14px 20px;

            border: 1px solid #FFC1D9; /* Border pink */

            border-radius: 10px;

            box-sizing: border-box;

            font-size: 0.95em;

            font-family: 'Poppins', sans-serif;

        }

       

        /* Trik untuk placeholder pada input date */

        .auth-container input[type="date"]::placeholder { color: #999; }

        .auth-container input[type="date"] { color: #999; }

        .auth-container input[type="date"]:focus,

        .auth-container input[type="date"]:valid {

            color: #333;

        }



        .auth-container textarea {

            resize: vertical;

            min-height: 80px;

        }



        .auth-container input::placeholder,

        .auth-container textarea::placeholder {

            color: #aaa;

        }



        .auth-container button {

            width: 100%;

            padding: 14px;

            background-color: #E91E63; /* Pink tua */

            border: none;

            border-radius: 10px;

            color: white;

            font-size: 1.1em;

            font-weight: 600;

            cursor: pointer;

            margin-top: 10px;

            transition: background-color 0.3s ease;

        }



        .auth-container button:hover {

            background-color: #C2185B; /* Pink lebih gelap */

        }



        .auth-link {

            margin-top: 25px;

            font-size: 0.9em;

            color: #555;

        }



        .auth-link a {

            color: #E91E63;

            text-decoration: none;

            font-weight: 600;

        }



        /* Styling untuk Alert Error */

        .alert {

            padding: 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            text-align: left;

            font-size: 0.9em;

        }



        .alert-success {

            background-color: #d4edda;

            color: #155724;

            border: 1px solid #c3e6cb;

        }



        .alert-danger {

            background-color: #f8d7da;

            color: #721c24;

            border: 1px solid #f5c6cb;

        }



        .alert-danger ul {

            margin: 0;

            padding-left: 20px;

            list-style-position: inside;

        }

    </style>

</head>

<body>



    @yield('content')



</body>

</html>