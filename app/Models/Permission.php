<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\LogsActivity;

class Permission extends SpatiePermission
{
   use LogsActivity;
    //
}