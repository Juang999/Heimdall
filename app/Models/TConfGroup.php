<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TConfGroup extends Model
{
    protected $table = 'public.tconfgroup';

    protected $primaryKey = 'groupid';

    public function User()
    {
        return $this->hasMany(User::class, 'groupid');
    }
}
