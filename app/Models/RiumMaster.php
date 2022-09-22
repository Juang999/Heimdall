<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiumMaster extends Model
{
    protected $table = 'public.rium_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'rium_oid';

    protected $guarded = [];

    public $timestamps = false;
}
