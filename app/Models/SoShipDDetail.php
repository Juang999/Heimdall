<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoShipDDetail extends Model
{
    protected $table = 'public.soshipd_det';

    protected $keyType = "string";

    protected $primaryKey = "soshipd_oid";

    public function SoShipMaster()
    {
        return $this->belongsTo(SoShipMaster::class, 'soship_oid');
    }

}
