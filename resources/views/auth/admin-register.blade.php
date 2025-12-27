<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Registration</title>
</head>
<body>
<h2>New Admin Registration</h2>
@if(@session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif
<form method="POST" action="{{  route('admin.register.submit') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br>
    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required><br>
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}" required><br>
    <button type="submit">Register</button>
</form>
</body>
</html>
