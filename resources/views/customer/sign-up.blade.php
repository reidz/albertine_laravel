@extends('customer.layouts.app')

@section('content')
<h2>WELCOME BACK DARLINGS</h2>
<h1>SIGN IN</h1>
<form class="form-horizontal" role="form" method="POST" action="{{ route('admin.login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="email-login" type="email" class="form-control" name="email-login" value="{{ old('email-login') }}" required autofocus placeholder="EMAIL">

            @if ($errors->has('email-login'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password-login') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="password-login" type="password" class="form-control" name="password-login" required placeholder="PASSWORD">

            @if ($errors->has('password-login'))
                <span class="help-block">
                    <strong>{{ $errors->first('password-login') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                SIGN IN
            </button>
        </div>
    </div>

    <a class="btn btn-link" href="{{ route('password.request') }}">
        FORGOT PASSWORD
    </a>
</form>



<h2>NEW TO ALBERTINE?</h2>
<h1>SIGN UP</h1>

<h3>By creating an account in our store,<br>you will be able to move through the checkout faster,<br>view and track your orders in your account and more.</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="EMAIL">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

{{--     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required placeholder="PASSWORD">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="CONFIRM PASSWORD">
        </div>
    </div> --}}

    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="FIRST NAME">

            @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
        <div class="col-md-6">
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus placeholder="LAST NAME">

            @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                CREATE ACCOUNT
            </button>
        </div>
    </div>
</form>

@endsection