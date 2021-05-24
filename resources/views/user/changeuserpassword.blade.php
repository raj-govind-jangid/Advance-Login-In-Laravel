@extends('base')

@section('title')
<title>Change User Password</title>
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
<div class="login-form">
    <form action="/updateuserpassword" method="post">
        @csrf
        <h2 class="text-center">Change Password</h2>
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter Old Password" name="oldpassword" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter New Password" name="password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter Confirm Password" name="confirmpassword" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block">Change Password</button>
        </div>
    </form>
</div>
@endsection
