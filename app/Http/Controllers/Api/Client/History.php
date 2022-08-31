<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\PtMaster;
use Illuminate\Http\Request;
use App\Models\SoDDetail;
use App\Models\SoMaster;
use Illuminate\Support\Facades\Auth;

class History extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            if (request()->start_date && request()->end_date) {
                $histories = SoDDetail::wherre('sod_upd_by', Auth::user()->usernama)
                ->whereBetween('sod_upd_date', [request()->start_date, request()->end_date])
                ->distinct('sod_so_oid')->get();

                $histories->makeHidden([
                'sod_oid',
                'sod_dom_id',
                'sod_en_id',
                'sod_seq',
                'sod_is_additional_charge',
                'sod_si_id',
                'sod_pt_id',
                'sod_rmks',
                'sod_qty',
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
                "sod_qty_checked"
            ]);

                foreach ($histories as $history) {
                    $history->so_master = SoMaster::where('so_oid', $history->sod_so_oid)->get();

                    $history->so_master->makeHidden([
                    "so_oid",
                    "so_dom_id",
                    "so_en_id",
                    "so_add_by",
                    "so_add_date",
                    "so_upd_by",
                    "so_upd_date",
                    "so_ptnr_id_sold",
                    "so_ptnr_id_bill",
                    "so_date",
                    "so_credit_term",
                    "so_taxable",
                    "so_tax_class",
                    "so_si_id",
                    "so_type",
                    "so_sales_person",
                    "so_pi_id",
                    "so_pay_type",
                    "so_pay_method",
                    "so_ar_ac_id",
                    "so_ar_sb_id",
                    "so_ar_cc_id",
                    "so_dp",
                    "so_disc_header",
                    "so_total",
                    "so_print_count",
                    "so_payment_date",
                    "so_close_date",
                    "so_tran_id",
                    "so_trans_id",
                    "so_trans_rmks",
                    "so_current_route",
                    "so_next_route",
                    "so_dt",
                    "so_cu_id",
                    "so_total_ppn",
                    "so_total_pph",
                    "so_payment",
                    "so_exc_rate",
                    "so_tax_inc",
                    "so_cons",
                    "so_terbilang",
                    "so_bk_id",
                    "so_interval",
                    "so_ref_po_code",
                    "so_ref_po_oid",
                    "so_ppn_type",
                    "so_is_package",
                    "so_pt_id",
                    "so_price",
                    "so_manufacture",
                    "so_sales_program",
                    "so_ref_sq_oid",
                    "so_ref_sq_code",
                    "so_indent",
                    "so_project",
                    "so_shipping_charges",
                    "so_total_final",
                    "confa_accunt",
                    "so_booking",
                    "so_shipping_address",
                    "so_sq_ref_oid",
                    "so_sq_ref_code",
                    "so_va",
                    "so_psn_ref_code",
                    "so_ref_po_code_2",
                    "so_parent_oid",
                    "so_parent_code",
                    "so_ptsfr_loc_id",
                    "so_ptsfr_loc_to_id",
                    "so_ptsfr_loc_git",
                    "so_alocated",
                    "so_book_start_date",
                    "so_book_end_date",
                    "so_print_dt",
                    "so_print",
                    "so_return",
                    "sqd_invc_oid"
                ]);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'success to get data',
                    'histories' => $histories
                ], 200);
            }

            $histories = SoDDetail::where('sod_upd_by', Auth::user()->usernama)
            ->distinct('sod_so_oid')->take(5)
            ->orderBy('sod_so_oid', 'DESC')
            ->get();

            $histories->makeHidden([
                'sod_oid',
                'sod_dom_id',
                'sod_en_id',
                'sod_seq',
                'sod_is_additional_charge',
                'sod_si_id',
                'sod_pt_id',
                'sod_rmks',
                'sod_qty',
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
                "sod_qty_checked"
            ]);


            foreach ($histories as $history) {
                $history->so_master = SoMaster::where('so_oid', $history->sod_so_oid)->get();
                $history->so_master->makeHidden([
                    "so_oid",
                    "so_dom_id",
                    "so_en_id",
                    "so_add_by",
                    "so_add_date",
                    "so_upd_by",
                    "so_upd_date",
                    "so_ptnr_id_sold",
                    "so_ptnr_id_bill",
                    "so_date",
                    "so_credit_term",
                    "so_taxable",
                    "so_tax_class",
                    "so_si_id",
                    "so_type",
                    "so_sales_person",
                    "so_pi_id",
                    "so_pay_type",
                    "so_pay_method",
                    "so_ar_ac_id",
                    "so_ar_sb_id",
                    "so_ar_cc_id",
                    "so_dp",
                    "so_disc_header",
                    "so_total",
                    "so_print_count",
                    "so_payment_date",
                    "so_close_date",
                    "so_tran_id",
                    "so_trans_id",
                    "so_trans_rmks",
                    "so_current_route",
                    "so_next_route",
                    "so_dt",
                    "so_cu_id",
                    "so_total_ppn",
                    "so_total_pph",
                    "so_payment",
                    "so_exc_rate",
                    "so_tax_inc",
                    "so_cons",
                    "so_terbilang",
                    "so_bk_id",
                    "so_interval",
                    "so_ref_po_code",
                    "so_ref_po_oid",
                    "so_ppn_type",
                    "so_is_package",
                    "so_pt_id",
                    "so_price",
                    "so_manufacture",
                    "so_sales_program",
                    "so_ref_sq_oid",
                    "so_ref_sq_code",
                    "so_indent",
                    "so_project",
                    "so_shipping_charges",
                    "so_total_final",
                    "confa_accunt",
                    "so_booking",
                    "so_shipping_address",
                    "so_sq_ref_oid",
                    "so_sq_ref_code",
                    "so_va",
                    "so_psn_ref_code",
                    "so_ref_po_code_2",
                    "so_parent_oid",
                    "so_parent_code",
                    "so_ptsfr_loc_id",
                    "so_ptsfr_loc_to_id",
                    "so_ptsfr_loc_git",
                    "so_alocated",
                    "so_book_start_date",
                    "so_book_end_date",
                    "so_print_dt",
                    "so_print",
                    "so_return",
                    "sqd_invc_oid"
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'success to get histories',
                'histories' => $histories
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed to get histories',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
