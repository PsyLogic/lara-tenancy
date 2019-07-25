@extends('tenant.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1>
                <i class="fa fa-users"></i> Role Administration
                <a href="{{ route('user.index') }}" class="btn btn-default pull-right">Users</a>
                <a href="{{ route('permission.index') }}" class="btn btn-default pull-right">Permissions</a>
            </h1>
            <hr>
            @include('alerts.session_succ_err')
            <a href="{{ route('role.create') }}" class="btn btn-success">Add Role</a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Operation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($roles as $role)
                        <tr>

                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permissions()->pluck('name')->implode(' ') }}</td>
                            <td>
                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-info float-left"
                                    style="margin-right: 3px;">Edit</a>
                                <form class="float-left" action="{{ route('role.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit"> Detele </button>
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