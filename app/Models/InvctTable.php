<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvctTable extends Model
{
    protected $table = 'public.invct_table';

    protected $keyType = 'string';

    protected $primaryKey = 'invct_oid';
}
