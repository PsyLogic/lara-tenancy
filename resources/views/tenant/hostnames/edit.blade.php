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
            <div class="card">
                <div class="card-header text-center">
                    <h5>Edit Hostname <b>{{ $hostname->fqdn }}</b></h5>
                </div>
                <div class="card-body">
                    <form action="{{route('hostname.update',$hostname)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Redirect To') }}</label>
                            <div class="col-md-6">
                                <input id="redirect_to" type="text" class="form-control @error('redirect_to') is-invalid @enderror" name="redirect_to" value="{{ old('redirect_to') ?? $hostname->redirect_to }}"  autocomplete="redirect_to" autofocus>
                                @error('redirect_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Force HTTPS') }}</label>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="no" name="force_https" class="custom-control-input" value="0" {{ $hostname->force_https ? '' : 'checked' }}>
                                    <label class="custom-control-label" for="no">No</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="yes" name="force_https" class="custom-control-input" value="1" {{ $hostname->force_https ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="yes">Yes</label>
                                </div>

                                @error('force_https')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Maintenance ?') }}</label>
                            <div class="col-md-6">
                                <input id="under_maintenance_since" type="date" class="form-control @error('under_maintenance_since') is-invalid @enderror" name="under_maintenance_since" value="{{ old('under_maintenance_since') ?? $hostname->under_maintenance_since->format('Y-m-d') }}" >
                                @error('under_maintenance_since')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
