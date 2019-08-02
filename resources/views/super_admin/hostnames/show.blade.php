@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @include('super_admin.sidebar')
        <div class="col-9">
            <h1>
                <i class="fas fa-server"></i> Hostname Details
            </h1>
            <hr>
            @include('alerts.session_succ_err')
            <div class="row">
                <div class="col-6">
                    <div class="table-responsive">
                        <h4>Owners of {{ $hostname->fqdn }}</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($owners as $owner)
                                <tr>
                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $owner->email }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">contact</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <h4>Status Of Hostname</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{!! $hostname->status !!}</td>
                                    <td>
                                        @if ($hostname->banned)
                                            <form action="{{ route('admin.hostname.block', $hostname) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" id="status" value="0">
                                                <button class="btn btn-sm btn-success" type="submit">Activate</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.hostname.block', $hostname) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" id="status" value="1">
                                                <button class="btn btn-sm btn-danger" type="submit">Block</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
