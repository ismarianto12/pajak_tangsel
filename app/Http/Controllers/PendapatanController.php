<?php

namespace App\http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Hashing\BcryptHasher;
use App\Models\PendapatanModel;

use Illuminate\Support\Carbon;

class PendapatanController extends Controller
{
    function pad_today(Request $request)
    {
        // $c_sampai = date("Y-m-d");
        // $harini   = date('Y-m-d');
        // $date     = strtotime("1 day", strtotime($c_sampai));
        // $sampai   = date("Y-m-d", $date);

        $id_usaha = 1;
        $dari   = Carbon::now()->format('Y-m-d');
        $sampai = date('Y-m-d', strtotime("1 day", strtotime($dari)));

        $par = [
            'id_usaha' => $id_usaha,
            'dari' => $dari,
            'sampai' => $sampai
        ];
        $data  = PendapatanModel::pendapatan($par);
        return response()->json([
            'data' => $data
        ]);
    }
}
