<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomMaster extends Model
{
    protected $table = 'public.dom_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'pi_oid';
}
