@extends('tenant.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
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
                            <td>{{ $hostname->format_create_at }}</td>
                            <td>
                                <a href="{{ route('tenant.hostname.edit', $hostname) }}" class="btn btn-info btn-sm float-left">Edit</a>
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
