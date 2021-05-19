@extends('layout.base')

@section('body')
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">

        @include('layout.navbar')

        @include('layout.sidebar')

        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            @include('layout.footer')

            @include('layout.rightSidebar')
        </div>
        <!-- ./wrapper -->
    </body>
@endsection
