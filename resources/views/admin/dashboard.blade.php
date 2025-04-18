<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
        }

        .navbar a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 30px;
        }

        h1 {
            color: #444;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="{{ route('admin.meja.index') }}">Meja</a>
        <a href="{{ route('admin.menu.index') }}">Menu</a>
        <a href="{{ route('admin.transaksi.index') }}">Transaksi</a>
        <a href="{{ route('admin.user.index') }}">User</a>
    </div>

    <div class="container">
        <h1>Selamat Datang di Dashboard Admin</h1>
        <p>Pilih menu dari navigasi di atas untuk mengelola data.</p>
    </div>

</body>
</html>
