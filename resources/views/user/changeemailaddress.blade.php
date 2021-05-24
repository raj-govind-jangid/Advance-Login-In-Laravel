@extends('base')

@section('title')
<title>Verify Email Address</title>
<link rel="stylesheet" href="{{ asset('css/form.css') }}">

@endsection

@section('content')
<div class="login-form">
    <form action="/changeemailaddress" method="post">
        @csrf
        <h2 class="text-center">Verify Email Address</h2>
        <input type="hidden" name="oldemail" value="{{ $oldemail }}">
        <input type="hidden" name="newemail" value="{{ $newemail }}">
        <div class="form-group">
            <input type="number" class="form-control" placeholder="Enter Verifycode" name="verifyotp" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter Password" name="password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block">Verify</button>
        </div>
    </form>
</div>
@endsection
