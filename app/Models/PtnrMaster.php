<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtnrMaster extends Model
{
    protected $table = "public.ptnr_mstr";

    protected $keyType = "string";

    protected $primaryKey = "ptnr_oid";
}
