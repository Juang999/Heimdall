<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TSqlOut extends Model
{
    protected $table = 'public.t_sql_out';

    protected $primaryKey = 'sql_uid';

    public $timestamps = false;

    protected $fillable = ['sql_uid', 'seq', 'sql_command', 'waktu', 'mili_second', 'status_process'];
}
