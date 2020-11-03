<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
// use Closure;


class AuthController extends Controller
{


    function index(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $userModel = new User;
        $data  = $userModel->where([
            'username' => $username,
            'password' => md5($password)
        ])->get();
        if ($data == '') {
            return response()->json([
                'status' => 2,
                'msg' => 'authetikasi gagal'
            ]);
        } else {
            $f = $data->count();
            if ($f > 0) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'login berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 2,
                    'msg' => 'usernaem dan password salah'
                ]);
            }
        }
    }
}
