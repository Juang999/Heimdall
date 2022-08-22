<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtMaster extends Model
{
    protected $table = "public.pt_mstr";

    protected $keyType = "string";

    protected $primaryKey = "pt_oid";
}
