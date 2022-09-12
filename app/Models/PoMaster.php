<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoMaster extends Model
{
    protected $table = 'public.po_mstr';

    protected $keyType = 'uuid';

    protected $primaryKey = 'po_oid';

    protected $guarded = [];

    public $timestamps = false;

    public function PoDDetail()
    {
        return $this->hasMany(PoDDetail::class, 'pod_po_oid');
    }
}
