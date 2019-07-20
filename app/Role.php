<?php

namespace App;

use Spatie\Permission\Models\Role as BaseRole;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Role extends BaseRole
{
    use UsesTenantConnection;
}
