<?php

namespace App;

use Hyn\Tenancy\Models\Hostname as BaseHostname;

class Hostname extends BaseHostname
{

    public function getStatusAttribute(){
        return $this->banned ? '<span class="badge badge-primary">Banned</span>' 
            : '<span class="badge badge-success">Active</span>';
    }
}
