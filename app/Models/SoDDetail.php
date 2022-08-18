<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoDDetail extends Model
{
    protected $table = 'public.sod_det';

    protected $keyType = 'string';

    protected $primaryKey = 'sod_oid';

    public function SoMaster()
    {
        return $this->belongsTo(SoMaster::class, 'so_oid');
    }
}
