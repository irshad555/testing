@extends('layouts.app')
@section('title','login')
@section('top_scripts')
@endsection
@section('style')
<style>
    .login-box {
        margin: 140px auto;
    }
</style>
@endsection
@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <div class="card-body">
             <form method="POST" action="{{url('/login') }}">
                        @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control"  name="email" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
            <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.html" class="text-center">Register a new membership</a>
            </p>
        </div>
    </div>
</div>


@endsection
@section('bottom_scripts')
@endsection