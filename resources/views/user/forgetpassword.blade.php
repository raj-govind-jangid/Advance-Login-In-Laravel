@extends('base')

@section('title')
<title>Register</title>
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
<div class="login-form">
    <form action="" method="post">
        @csrf
        <h2 class="text-center">Forget Password</h2>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email Id" name="email" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block">Forget Password</button>
        </div>
    </form>
</div>
@endsection
