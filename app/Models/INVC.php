<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class INVC extends Model
{
    protected $table = 'public.invc_mstr';

    protected $keyType = 'uuid';

    protected $primaryKey = 'invc_oid';

    protected $guarded = [];

    public $timestamps = false;
}
