<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class En extends Model
{
    protected $table = "public.en_mstr";

    protected $keyType = "string";

    protected $primaryKey = "en_oid";
}
