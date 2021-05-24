@extends('base')

@section('title')
<title>Change Password</title>
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
<div class="login-form">
    <form action="/changepassword" method="post">
        @csrf
        <h2 class="text-center">Change Password</h2>
        <input type="hidden" name="forgetemail" value="{{ $forgetemail }}">
        <div class="form-group">
            <label>Enter OTP</label>
            <input type="number" name="verifyotp" class="form-control" placeholder="Enter OTP"  required>
          </div>
          <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter Password"  required>
          </div>
          <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" name="confirmpassword" class="form-control" placeholder="Enter Confirm Password"  required>
          </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block">Change Password</button>
        </div>
    </form>
</div>
@endsection
