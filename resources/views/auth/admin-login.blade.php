<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login Page</title>
</head>

<body>
    <h2>Admin Login</h2>
    @if(@session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{  route('admin.login.submit') }}">
        @csrf
        <div><label>Email:</label><br>
            <input type="text" name="email" required>
        </div>
        <div><label>Password:</label><br>
            <input type="password" name="password" required>
        </div>

        <br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="{{ route('admin.register') }}">Register here</a></p>
        <p>Customer? <a href="{{ route('customer.login') }}">Customer Login</a></p>
    </form>
</body>

</html>