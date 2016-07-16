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
  <h2>Register</h2>
  <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
    <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
    <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
    <form role="form" method="POST" action="{{ url('/register') }}">
      {{ csrf_field() }}
        <div class="row control-group">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} form-group col-xs-12 floating-label-form-group controls">
              <label for="email">E-Mail Address</label>

                  <input id="email" placeholder="E-mail Address *" type="email" class="form-control" name="email" value="{{ old('email') }}">

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

                  <input id="password" placeholder="Password *" type="password" class="form-control" name="password">

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
            </div>
        </div>
        <div class="row control-group">
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} form-group col-xs-12 floating-label-form-group controls">
              <label for="password-confirm">Confirm Password</label>

                  <input id="password-confirm" placeholder="Password Confirmation *" type="password" class="form-control" name="password_confirmation">

                  @if ($errors->has('password_confirmation'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                  @endif
            </div>
        </div>
        <br>

        <div class="row">
            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-btn fa-user"></i> Register
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
