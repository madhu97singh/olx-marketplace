@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="auth-card">

    <h3 class="text-center mb-4">Create Your Account</h3>

    <form action="{{ route('register.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Full Name</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Enter your name">

            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

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
            <label class="form-label">Confirm Password</label>

            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm password">
        </div>

        <button type="submit"
                class="btn btn-marketplace w-100">
            Register
        </button>

    </form>

    <p class="text-center mt-3">
        Already have an account?

        <a href="{{ route('login') }}">Login here</a>
    </p>

</div>

@endsection