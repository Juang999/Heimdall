<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoDDetail extends Model
{
    protected $table = 'public.pod_det';

    protected $keyType = 'string';

    protected $primaryKey = 'pod_oid';

    public function PoMaster()
    {
        return $this->belongsTo(PoMaster::class, 'po_oid');
    }

    public function PtMaster()
    {
        return $this->belongsTo(PtMaster::class, 'pod_pt_id', 'pt_id');
    }
}
