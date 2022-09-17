<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvhMaster extends Model
{
    protected $table = 'public.invh_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'invh_oid';

    protected $guarded = [];

    public $timestamps = false;
}
