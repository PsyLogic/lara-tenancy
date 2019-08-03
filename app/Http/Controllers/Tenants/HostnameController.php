<?php

namespace App\Http\Controllers\Tenants;

use App\Hostname;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\_Tenant;
use App\Services\TenantService;

class HostnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return _Tenant::view('hostnames.index', ['hostnames' => Hostname::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function show(Hostname $hostname)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function edit(Hostname $hostname)
    {
        return back()->with('error', 'The update operation is not available in this version');
        return _Tenant::view('hostnames.edit', compact('hostname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hostname $hostname)
    {
        // the issue of not updating the (redirect_to, under_maintenance_since)
        // of the hostname, that we cannot go back to admin panel
        // since the \Hyn\Tenancy\Middleware\HostnameActions middleware
        //will block us if any of those attribute are filled.
        return back()->with('error', 'The update operation is not available in this version');
        return TenantService::update($request,$hostname);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hostname $hostname)
    {
    }
}
