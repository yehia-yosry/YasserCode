<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update User Profile</title>
</head>
<body>
<h2>Update Profile</h2>
<a href="{{ route('home') }}">Back to home page</a> |
<a href="{{ route('customer.login') }}">Logout</a> |

@if(@session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

@if(@session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<form method="POST" action="{{  route('customer.profile.submit') }}">
    @csrf
    @csrf
    <input type="text" name="username" value="{{ old('username',$user->Username) }}"" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="text" name="firstname" value="{{ old('firstname',$user->FirstName) }}" placeholder="First Name"><br>
    <input type="text" name="lastname" value="{{ old('lastname',$user->LastName) }}" placeholder="Last Name"><br>
    <input type="email" name="email" value="{{ old('email',$user->Email) }}" placeholder="Email"><br>
    <input type="text" name="phone" value="{{ old('phone',$user->PhoneNumber) }}" placeholder="Phone Number"><br>
    <textarea name="address" placeholder="Shipping Address">{{ old('address',$user->ShippingAddress) }}</textarea><br>
    <button type="submit">Update</button>
</form>
</body>
</html>
