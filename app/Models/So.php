<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class So extends Model
{
    protected $table = 'public.so_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'so_oid';

    // public function SoShipMaster()
    // {
    //     return $this->hasMany(SoShipMaster::class, 'soship_so_oid');
    // }
}
