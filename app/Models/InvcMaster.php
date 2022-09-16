<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvcMaster extends Model
{
    protected $table = 'public.invc_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'invc_oid';

    protected $guarded = [];

    public $timestamps = false;
}
