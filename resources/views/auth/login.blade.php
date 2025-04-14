<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Kamu bisa menambahkan CSS atau framework seperti TailwindCSS jika diinginkan -->
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto;">
        <h1>Login</h1>
        
        <!-- Tampilkan error jika ada -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div style="margin-bottom: 10px;">
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" required style="width: 100%;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required style="width: 100%;">
            </div>

            <button type="submit" style="padding: 8px 12px;">Login</button>
        </form>
    </div>
</body>
</html>
