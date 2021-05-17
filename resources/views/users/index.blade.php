@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users list</h3>
            </div>
            <!-- /.card-header -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{session('success')}}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{session('error')}}</div>
            @endif

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Verified</th>
                            <th style="width: 100px">Role</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-primary">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Unverified</span>
                                    @endif
                                </td>
                                <td>{{$user->role === \App\Models\User::ROLE_ADMIN ? 'Admin' : 'User'}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary"
                                                type="button"
                                                data-user="{{json_encode($user)}}"
                                                data-toggle="modal"
                                                data-target="#userEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-default"
                                                type="button"
                                                data-user="{{json_encode($user)}}"
                                                data-toggle="modal"
                                                data-target="#userEditModalAjax">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-user="{{json_encode($user)}}"
                                                data-toggle="modal"
                                                data-target="#userDeleteModal">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    @if ($users->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{$users->previousPageUrl()}}">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="{{$users->url(1)}}">1</a></li>
                    @endif

                    @if ($users->currentPage() > 3)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif
                    @if ($users->currentPage() >= 3)
                        <li class="page-item"><a class="page-link" href="{{$users->url($users->currentPage() - 1)}}">{{$users->currentPage() - 1}}</a></li>
                    @endif

                    <li class="page-item"><span class="page-link page-active">{{$users->currentPage()}}</span></li>

                    @if ($users->currentPage() <= $users->lastPage() - 2)
                        <li class="page-item"><a class="page-link" href="{{$users->url($users->currentPage() + 1)}}">{{$users->currentPage() + 1}}</a></li>
                    @endif

                    @if ($users->currentPage() < $users->lastPage() - 2)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif

                    @if ($users->currentPage() < $users->lastPage() )
                        <li class="page-item"><a class="page-link" href="{{$users->url($users->lastPage())}}">{{$users->lastPage()}}</a></li>
                        <li class="page-item"><a class="page-link" href="{{$users->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="userEditModal">
            <div class="modal-dialog">
                <form action="{{route('users.update')}}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="userEditName"></div>
                            <input type="hidden" name="id" id="userEditId" value="" />
                            <div class="form-group">
                                <label for="userEditRole">Role</label>
                                <select class="custom-select rounded-0" name="role" id="userEditRole">
                                    <option value="{{\App\Models\User::ROLE_USER}}">User</option>
                                    <option value="{{\App\Models\User::ROLE_ADMIN}}">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="userEditModalAjax">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="userEditAlert"></div>
                        <div id="userEditNameAjax"></div>
                        <input type="hidden" id="userEditIdAjax" value="" />
                        <div class="form-group">
                            <label for="userEditRoleAjax">Role</label>
                            <select class="custom-select rounded-0" id="userEditRoleAjax">
                                <option value="{{\App\Models\User::ROLE_USER}}">User</option>
                                <option value="{{\App\Models\User::ROLE_ADMIN}}">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="userEditButtonAjax">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userDeleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="userDeleteAlert"></div>
                        <input type="hidden" id="userDeleteId" value="" />
                        <p>Are you sure you want to delete: <span id="userDeleteName"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="userDeleteButton">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
@endsection