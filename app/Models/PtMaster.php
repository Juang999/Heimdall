<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtMaster extends Model
{
    protected $table = "public.pt_mstr";

    protected $keyType = "string";

    protected $primaryKey = "pt_oid";

    public function SoDDetail()
    {
        return $this->hasMany(SoDDetail::class, 'sod_pt_id', 'pt_id');
    }

    public function PoDDetail()
    {
        return $this->hasMany(PoDDetail::class, 'pt_id', 'pod_pt_id');
    }
}
