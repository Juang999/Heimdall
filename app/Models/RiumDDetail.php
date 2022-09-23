<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiumDDetail extends Model
{
    protected $table = 'public.riumd_det';

    protected $keyType = 'string';

    protected $primaryKey = 'riumd_oid';

    protected $guarded = [];

    public $timestamps = false;

    public function RiumMaster()
    {
        return $this->belongsTo(RiumMaster::class, 'rium_oid', 'riumd_rium_oid');
    }

    public function PtMaster()
    {
        return $this->belongsTo(PtMaster::class, 'riumd_pt_id', 'pt_id');
    }
}
