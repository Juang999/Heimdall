<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiMaster extends Model
{
    protected $table = 'public.pi_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'pi_oid';
}
