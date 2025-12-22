@extends('adminlte::page')

@section('title', 'Admin Login')

@section('content')
<style>
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-box {
        width: 400px;
        margin: 80px auto;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        border: none;
    }

    .login-card-body {
        padding: 40px;
        background: #ffffff;
        text-align: center;
    }

    .login-box-msg {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: #333;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ccc;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.3);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    @media (max-width: 480px) {
        .login-box {
            width: 90%;
            margin: 50px auto;
        }
    }
</style>

<div class="login-box">
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="card">
        <div class="card-body login-card-body">
<div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="width: 120px; height: auto;">
            </div>
            <p class="login-box-msg">Admin Login</p>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="form-group mt-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">
                    Login
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
