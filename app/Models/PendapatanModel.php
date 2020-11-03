<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PendapatanModel extends Model
{

    protected $connection = 'pgsql';
    protected $table  = 'pad_sspd';
    protected $guarded  = [];
    public $incrementing = false;


    public static function pendapatan($par)
    {

        $params = [
            'cu.usaha_id' => $par['id_usaha']
        ];
        return DB::Select(\DB::raw("sum((sp.dasar * sp.tarif)- sp.kompensasi - sp.setoran + sp.kenaikan + sp.lain2) as jumlah"))
            ->from('pad_sspd as ps')
            ->join('pad_payment as pp', function ($join) {
                $join->on('ps.id', '=', 'pp.sspd_id');
            })
            ->join('pad_spt as sp', function ($join) {
                $join->on('ps.spt_id', '=', 'sp.id');
            })
            ->join('pad_spt_type as st', function ($join) {
                $join->on('sp.type_id', '=', 'st.id');
            })
            ->join('pad_customer as pc', function ($join) {
                $join->on('sp.customer_id', '=', 'pc.id');
            })
            ->join('pad_customer_usaha as cu', function ($join) {
                $join->on('sp.customer_usaha_id', '=', 'cu.id');
            })
            ->join('pad_usaha as pu', function ($join) {
                $join->on('cu.usaha_id', '=', 'pu.id');
            })
            ->join('pad_kohir as k', function ($join) {
                $join->on('sp.id', '=', 'k.spt_id');
            })
            ->join('tblkecamatan as kec', function ($join) {
                $join->on('kec.id', '=', 'pc.kecamatan_id');
            })
            ->join('tblkelurahan as kel', function ($join) {
                $join->on('kel.id', '=', 'pc.kelurahan_id');
            })
            ->where('ps.tahun', '>', 2010)
            ->where('ps.jml_bayar', '>', 0)
            ->where($params)
            ->whereBetween('ps.sspdtgl', [$par['dari'], $par['sampai']])
            ->get();
    }
}
