<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiumDDetail extends Model
{
    protected $table = 'public.riumd_det';

    protected $keyType = 'string';

    protected $primaryKey = 'riumd_oid';

    protected $guarded = [];

    public $timestamps = false;
}
