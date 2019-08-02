<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Hostname;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hyn\Tenancy\Database\Connection;
use App\User;

class HostnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('super_admin.hostnames.index', ['hostnames' => Hostname::all()]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function show(Hostname $hostname)
    {
        // Get Website of the specified hostname
        $website = $hostname->website()->first();

        // Get Congif connection of the specified website
        $config = app(Connection::class)->generateConfigurationArray($website);

        // Set Tenant Connection Configuration
        config(['database.connections.tenant' => $config]);
        
        // Get All the owners of the Hostname
        $owners = User::role('owner')->get();

        return view('super_admin.hostnames.show', compact('owners','hostname'));
    }


    /**
     * Block the specified resource.
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Hostname  $hostname
     * @return \Illuminate\Http\Response
     */
    public function block(Request $request, Hostname $hostname)
    {
        // Block the Hostname
        $hostname->banned = (bool) $request->status;
        $hostname->save();

        /**
         * TODO:
         * Send Email Notification to the owners 
         * */ 

        return redirect()->route('admin.hostname.show', [$hostname])->with('success', 'Status of Hostname is changed successfully');
    }

}
