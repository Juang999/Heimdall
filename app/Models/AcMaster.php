<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcMaster extends Model
{
    protected $table = 'public.ac_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'ac_oid';
}
