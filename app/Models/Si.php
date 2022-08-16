<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Si extends Model
{
    protected $table = 'public.si_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'si_oid';
}
