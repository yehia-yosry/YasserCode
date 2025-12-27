@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="post" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-2">
            <label>First Name</label>
            <input type="text" name="FirstName" value="{{ old('FirstName', $customer->FirstName ?? '') }}" class="form-control">
        </div>
        <div class="mb-2">
            <label>Last Name</label>
            <input type="text" name="LastName" value="{{ old('LastName', $customer->LastName ?? '') }}" class="form-control">
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="Email" value="{{ old('Email', $customer->Email ?? '') }}" class="form-control">
        </div>
        <div class="mb-2">
            <label>Phone</label>
            <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $customer->PhoneNumber ?? '') }}" class="form-control">
        </div>
        <div class="mb-2">
            <label>Shipping Address</label>
            <textarea name="ShippingAddress" class="form-control">{{ old('ShippingAddress', $customer->ShippingAddress ?? '') }}</textarea>
        </div>

        <hr>

        <div class="mb-2">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="Password" class="form-control">
        </div>
        <div class="mb-2">
            <label>Confirm Password</label>
            <input type="password" name="Password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">Save</button>
    </form>

@endsection
