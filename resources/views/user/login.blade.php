@extends('base')

@section('title')
<title>Login</title>
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
<div class="login-form">
    <form action="" method="post">
        @csrf
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" name="email" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
            <a href="/forgetpassword" class="float-right">Forgot Password?</a>
        </div>
    </form>
    <p class="text-center"><a href="/register">Create an Account</a></p>
</div>
@endsection
