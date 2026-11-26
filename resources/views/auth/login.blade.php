@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="auth-card">

    <h3 class="text-center mb-4">Login to Your Account</h3>

    <form action="{{ route('login.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>

            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="Enter your email">

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Enter password">

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>
                <input type="checkbox" name="remember" value="1">
                Remember Me
            </label>
        </div>

        <button type="submit"
                class="btn btn-marketplace w-100">
            Login
        </button>

    </form>

    <p class="text-center mt-3">
        Don't have an account?

        <a href="{{ route('register') }}">Register here</a>
    </p>

</div>

@endsection