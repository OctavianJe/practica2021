@extends('layout.base')

@section('body')
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{route('dashboard')}}"><b>Admin</b> LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <form action="" method="post">
                        @csrf

                        @if ($errors->has('name'))
                            <div class="alert alert-danger">{{$errors->first('name')}}</div> @endif

                        <div class="input-group mb-3">
                            <input name="name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" placeholder="Full name" value="{{old('name')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('email'))
                            <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif

                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="Email" value="{{old('email')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('password'))
                            <div class="alert alert-danger">{{$errors->first('password')}}</div> @endif

                        <div class="input-group mb-3">
                            <input name="password" type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('password_confirmation'))
                            <div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div> @endif

                        <div class="input-group mb-3">
                            <input name="password_confirmation" type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="Retype password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('terms'))
                            <div class="alert alert-danger">{{$errors->first('terms')}}</div> @endif

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input name="terms" type="checkbox" id="agreeTerms">
                                    <label for="agreeTerms">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </div>
                    </form>

                    <div class="social-auth-links text-center">
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Sign up using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i>
                            Sign up using Google+
                        </a>
                    </div>

                    <a href="{{route('login')}}" class="text-center">I already have a membership</a>
                </div>
            </div>
        </div>
    </body>
@endsection