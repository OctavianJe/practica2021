@extends('layout.base')

@section('body')
    <body class="hold-transition login-page">
        <div class="login-box">

            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{route('dashboard')}}"><b>Admin</b> LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Reset your password.</p>
                    <form action="" method="post">
                        @csrf

                        @if ($errors->has('email'))
                            <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif

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

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Change password</button>
                            </div>
                        </div>

                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{route('login')}}">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
@endsection