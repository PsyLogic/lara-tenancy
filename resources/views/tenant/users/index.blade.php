@extends('tenant.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1>
                <i class="fa fa-users"></i> User Administration
                <a href="{{route('role.index')}}" class="btn btn-default pull-right">Roles</a>
                <a href="{{route('permission.index')}}" class="btn btn-default pull-right">Permissions</a></h1>
            <hr>
            @include('alerts.session_succ_err')
            <a href="{{ route('user.create') }}" class="btn btn-success">Add User</a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date/Time Added</th>
                            <th>User Roles</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                            <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>
                            {{-- Retrieve array of roles associated to a user and convert to string --}}
                            <td>
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-secondary float-left"
                                    style="margin-right: 3px;">Profile</a>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info float-left"
                                    style="margin-right: 3px;">Edit</a>
                                <form class="float-left" action="{{ route('user.destroy', $user->id) }}" method="POST">
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
