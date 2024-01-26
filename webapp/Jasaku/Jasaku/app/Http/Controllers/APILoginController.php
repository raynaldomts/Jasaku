<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class APIUserController extends Controller
{


    public function postLogin(Request $request){


        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            $data = [
                'code' => 404,
                'message' => 'Data yang diberikan tidak valid!'
            ];
            return json_encode($data, JSON_PRETTY_PRINT);
        }


        $data_user = DB::table('users')->where('email', $request->email)->first();
        if(!$data_user || $data_user->password != $request->password){
            $data = [
                'code' => 404,
                'message' => 'Akun tidak ditemukan!'
            ];
            return json_encode($data, JSON_PRETTY_PRINT);
        }


        $data = [
            'nama' => $data_user->name,
            'email' => $data_user->email,
            'alamat' => $data_user->alamat,
            'no_telepon' => $data_user->no_telepon,
            'foto' => $data_user->foto,

            'code' => 200,
            'message' => 'Berhasil!'
        ];

        return json_encode($data, JSON_PRETTY_PRINT);
    }


}