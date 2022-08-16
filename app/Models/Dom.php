<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dom extends Model
{
    protected $table = "public.dom_mstr";

    protected $keyType = "string";

    protected $primaryKey = "dom_oid";

    public function SoShipMaster()
    {
        return $this->hasMany(SoShipMaster::class, 'soship_dom_id');
    }
}
