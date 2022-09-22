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

    protected $hidden = [
        'sod_dom_id',
        'sod_en_id',
        'sod_add_by',
        'sod_add_date',
        'sod_seq',
        'sod_is_additional_charge',
        'sod_si_id',
        'sod_pt_id',
        'sod_rmks',
        'sod_qty_allocated',
        'sod_qty_picked',
        'sod_qty_shipment',
        'sod_qty_pending_inv',
        'sod_qty_invoice',
        'sod_um',
        'sod_cost',
        'sod_price',
        'sod_disc',
        'sod_sales_ac_id',
        "sod_sales_sb_id",
        "sod_sales_cc_id",
        "sod_disc_ac_id",
        "sod_um_conv",
        "sod_qty_real",
        "sod_taxable",
        "sod_tax_inc",
        "sod_tax_class",
        "sod_status",
        "sod_dt",
        "sod_payment",
        "sod_dp",
        "sod_sales_unit",
        "sod_loc_id",
        "sod_serial",
        "sod_qty_return",
        "sod_ppn_type",
        "sod_pod_oid",
        "sod_qty_ir",
        "sod_invc_oid",
        "sod_invc_loc_id",
        "sod_ppn",
        "sod_pph",
        "sod_sales_unit_total",
        "sod_sqd_oid",
        "sod_commision",
        "sod_commision_total",
        "sod_wo_status",
        "sod_sod_parent_oid",
        "sod_qty_child",
        "sod_so_sq_ref_oid",
        "sod_qty_open",
        "sod_qty_booked",
        "sq_invc_oid",
        "sod_invc_qty",
        "sqd_invc_oid",
        "sod_part",
    ];

    public function SoMaster()
    {
        return $this->belongsTo(SoMaster::class, 'so_oid');
    }

    public function PtMaster()
    {
        return $this->belongsTo(PtMaster::class, 'sod_pt_id', 'pt_id');
    }
}
