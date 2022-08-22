<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoDDetail extends Model
{
    protected $table = 'public.sod_det';

    protected $keyType = 'string';

    protected $primaryKey = 'sod_oid';

    protected $fillable = ['sod_upd_by', 'sod_upd_date', 'sod_qty_checked'];

    public $timestamps = false;

    public function SoMaster()
    {
        return $this->belongsTo(SoMaster::class, 'so_oid');
    }
}
