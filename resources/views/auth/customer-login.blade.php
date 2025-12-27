<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Login Page</title>
</head>

<body>
    <h2>Customer Login</h2>
    @if(@session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{  route('customer.login.submit') }}">
        @csrf
        <div><label>Username:</label><br>
            <input type="text" name="username" required>
        </div>
        <div><label>Password:</label><br>
            <input type="password" name="password" required>
        </div>

        <br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="{{ route('customer.register') }}">Register here</a></p>
        <p>Admin? <a href="{{ route('admin.login') }}">Admin Login</a></p>
    </form>
</body>

</html>