<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoMaster extends Model
{
    protected $table = 'public.so_mstr';

    protected $keyType = 'string';

    protected $primaryKey = 'so_oid';

    public function SoDDetail()
    {
        return $this->hasMany(SoDDetail::class, 'sod_so_oid');
    }

    public function Dom()
    {
        return $this->belongsTo(Dom::class);
    }
}
