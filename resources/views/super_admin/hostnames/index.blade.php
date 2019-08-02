@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @include('super_admin.sidebar')
        <div class="col-9">
            <h1>
                <i class="fas fa-server"></i> Hostnames Administration
            </h1>
            <hr>
            @include('alerts.session_succ_err')
            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>FQDN</th>
                            <th>Redirect To</th>
                            <th>Force HTTPS</th>
                            <th>Under maintenance</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hostnames as $hostname)
                        <tr>
                            <td>{{ $hostname->fqdn }}</td>
                            <td>{{ $hostname->redirect_to ?? 'None' }}</td>
                            <td>{{ $hostname->force_https ? 'Yes' : 'No' }}</td>
                            <td>{{ $hostname->format_under_maintenance_since ?? 'None'}}</td>
                            <td>{!! $hostname->status !!}</td>
                            <td>{{ $hostname->format_create_at }}</td>
                            <td>
                                <a href="{{ route('admin.hostname.show', $hostname) }}" class="btn btn-info btn-sm float-left"
                                    style="margin-right: 3px;">Details</a>
                                <form class="float-left" action="{{ '' }}" method="POST">
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
