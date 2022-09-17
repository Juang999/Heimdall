<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GltDetail extends Model
{
    protected $table = 'public.glt_det';

    protected $keyType = 'string';

    protected $primaryKey = 'glt_oid';

    protected $guarded = [];

    public $timestamps = false;
}
