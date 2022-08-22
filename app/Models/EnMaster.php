<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnMaster extends Model
{
    protected $table = 'public.en_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'pi_oid';
}
