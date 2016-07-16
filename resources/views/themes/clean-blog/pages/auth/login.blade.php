@extends('themes.clean-blog.layouts.default')

@section("header")
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Vuedo Deluxe</h1>
                        <hr class="small">
                        <span class="subheading">A Clean Blog Theme by Start Bootstrap</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

<!-- Main Content -->
@section('content')
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
  <h2>Login</h2>
  <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
    <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
    <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
    <form action="{{ url('/login') }}" method="POST" role="form">
      {{ csrf_field() }}
        <div class="row control-group">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-group col-xs-12 floating-label-form-group controls">
              <label for="email">E-Mail Address</label>
              <input type="email" id="email" placeholder="E-mail Address *" class="form-control" name="email" value="{{ old('email') }}">
              @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
        </div>
        <div class="row control-group">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-group col-xs-12 floating-label-form-group controls">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control" name="password" placeholder="Password *">
              @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group col-xs-12">
              <input type="checkbox" name="remember"> Remember Me
            </div>
        </div>

        <div class="row">
            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-btn fa-sign-in"></i> Login
                </button>
                  <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>
        </div>

        <input hidden name="redirectTo" value="{{URL::previous()}}">
    </form>
</div>
@endsection
