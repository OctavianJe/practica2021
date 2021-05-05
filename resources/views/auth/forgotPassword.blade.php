@extends('layout.base')

@section('body')
    <body class="hold-transition login-page">
        <div class="login-box">

            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{route('dashboard')}}"><b>Admin</b> LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                    <form action="" method="post">
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{session('status')}}</div>
                        @endif

                        @if ($errors->has('email'))
                            <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif

                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="Email" value="{{old('email')}}" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Request new password</button>
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