<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cu extends Model
{
    protected $table = 'public.cu_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'cu_oid';
}
