<?php

namespace App\http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller
{


    function index(Request $request)
    {
        $data = User::select(['username', 'nama', 'level'])->get();
        return response()->json(
            [
                'status' => 1,
                'data' => $data,
            ]
        );
    }


    function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|unique:[user,username]',
            'password' => 'required',
            'nama' => 'required'
        ]);
        $data = new User;
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->nama     = $request->nama;
        $data->level    = $request->level;
        $data->save();

        return response()->json([
            'status' => 1,
            'msg' => 'data berhasil disimpan'
        ], 200);
    }

    function show(Request $request)
    {
        $data = new User;
        $f = $data->find($id);
        try {
            return response()->json([
                'stat' => 1,
                'data' => $f,
                'msg' => 'detail data update '
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'stat' => 1,
                'msg' => 'gagal server tidak menanggapi '
            ], 404);
        }
    }


    function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required|unique:[user,username]',
            'password' => 'required',
            'nama' => 'required'
        ]);
        $data = new User;
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->nama     = $request->nama;
        $data->level    = $request->level;
        $data->find($id)->save();
        return response()->json([
            'status' => 1,
            'msg' => 'data berhasil update'
        ], 200);
    }

    function destroy(Request $request, $id)
    {
        $data = User::whereIn('id', $request->id);
        try {
            $data->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'data berhasil di hapus'
            ]);
        } catch (\Throwable $data) {
            //throw $th;

            return response()->json(
                ['msg' => 'server tida dapat meresponse dengan baik'],
                400
            );
        }
    }
}
