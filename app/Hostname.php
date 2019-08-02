<?php

namespace App;

use Hyn\Tenancy\Models\Hostname as BaseHostname;

class Hostname extends BaseHostname
{

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function getStatusAttribute(){
        return $this->banned ? '<span class="badge badge-danger">Banned</span>' 
            : '<span class="badge badge-success">Active</span>';
    }

    public function getFormatCreateAtAttribute(){
        return $this->created_at->format('Y-m-d');
    }
    public function getFormatUnderMaintenanceSinceAttribute(){
        return $this->created_at->format('Y-m-d');
    }
}
