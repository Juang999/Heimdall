<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class INVH extends Model
{
    protected $table = 'public.invh_mstr';

    protected $keyType = 'uuid';

    protected $primaryKey = 'invh_oid';
}
