<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoMaster extends Model
{
    protected $table = 'public.po_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'po_oid';

    public function PoDDetail()
    {
        return $this->hasMany(PoDDetail::class, 'pod_po_oid');
    }
}
