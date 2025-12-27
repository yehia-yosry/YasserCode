<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Registration</title>
</head>
<body>
<h2>New Customer Registration</h2>
@if(@session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif
<form method="POST" action="{{  route('customer.register.submit') }}">
    @csrf
    <input type="text" name="username" value="{{ old('username') }}"" placeholder="Username" required><br>
    <input type="password" name="password" value="{{ old('password') }}" placeholder="Password" required><br>
    <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required><br>
    <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required><br>
    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required><br>
    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required><br>
    <textarea name="address" placeholder="Shipping Address" required>{{ old('address') }}</textarea><br>
    <button type="submit">Register</button>
</form>
</body>
</html>
