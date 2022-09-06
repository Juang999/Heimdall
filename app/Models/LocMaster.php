<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocMaster extends Model
{
    protected $table = 'public.loc_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'loc_oid';
}
