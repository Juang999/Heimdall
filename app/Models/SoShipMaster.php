<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoShipMaster extends Model
{
    protected $table = 'public.soship_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'soship_oid';

    public function SoShipDDetail()
    {
        return $this->hasMany(SoShipDDetail::class, 'soshipd_soship_oid');
    }

    public function Dom()
    {
        return $this->belongsTo(Dom::class, 'dom_id');
    }

    // public function So()
    // {
    //     return $this->belongsTo(So::class, 'so_oid');
    // }
}
