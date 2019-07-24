@extends('tenant.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1>
                <i class="fa fa-users"></i> Permssions Administration
                <a href="{{ route('user.index') }}" class="btn btn-default pull-right">Users</a>
                <a href="{{ route('role.index') }}" class="btn btn-default pull-right">Roles</a>
            </h1>
            <hr>
            @include('tenant.layout.alert')
            <a href="{{ route('permission.create') }}" class="btn btn-success">Add Permission</a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Permissions</th>
                            <th>Operation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>

                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-info float-left"
                                    style="margin-right: 3px;">Edit</a>
                                <form class="float-left" action="{{ route('permission.destroy', $permission->id) }}" method="POST">
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