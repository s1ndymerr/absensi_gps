<!DOCTYPE html>
<html>
<head>
    <title>Login Siswa</title>
</head>
<body>
    <h2>Login Siswa</h2>

    <form action="{{ route('siswa.login.post') }}" method="POST">
        @csrf

        <!-- Identifier bisa NIS atau username -->
        <input type="text" name="identifier" placeholder="Masukkan NIS atau Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
