@extends('layouts.app')
@section('content')
<div class="container-fluid">
        <div class="row justify-content-center">
        @include('super_admin.sidebar')
        <div class="col-9">
            <h1>
                <i class="fa fa-users"></i> User Administration
            </h1>
            <hr>
            @include('alerts.session_succ_err')
            <a href="{{ route('admin.user.create') }}" class="btn btn-success">New Admin</a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->formated_created_at }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-info float-left" style="margin-right: 3px;">Edit</a>
                                <form onsubmit="return confirm('Are you sure ?');" class="float-left" action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"> Detele </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
