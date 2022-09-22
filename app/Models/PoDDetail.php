<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoDDetail extends Model
{
    protected $table = 'public.pod_det';

    protected $keyType = 'string';

    protected $primaryKey = 'pod_oid';

    protected $guarded = [];

    public $timestamps = false;

    protected $hidden = [
        'pod_dom_id',
        'pod_em_id',
        'pod_seq',
        'pod_reqd_oid',
        'pod_si_id',
        'pod_pt_id',
        'pod_end_user',
        'pod_qty_invoice',
        'pod_um',
        'pod_cost',
        'pod_disc',
        'pod_sb_id',
        'pod_cc_id',
        'pod_pjc_id',
        'pod_neet_date',
        'pod_due_date',
        'pod_um_conv',
        'pod_qty_real',
        'pod_pt_class',
        'pod_taxable',
        'pod_tax_inc',
        'pod_tax_class',
        'pod_status',
        'pod_dt',
        'pod_qty_return',
        'pod_memo',
        'pod_desc1',
        'pod_desc2',
        'pod_qty_so',
        'pod_height',
        'pod_width',
        'pod_cost_film',
        'pod_ppn',
        'pod_pph'
    ];

    public function PoMaster()
    {
        return $this->belongsTo(PoMaster::class, 'po_oid');
    }

    public function PtMaster()
    {
        return $this->belongsTo(PtMaster::class, 'pod_pt_id', 'pt_id');
    }
}
