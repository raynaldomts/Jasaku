<?php

namespace App\Http\Controllers\API;

use App\Models\KategoriJasa;
use App\Models\Jasa;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriJasa::all();
        $user = User::all();
        if($kategori){
            return response()->json($kategori, 200);
            // return response()->json(compact($kategori,$user), 200);
        }
        else
            return response()->json('Data Not Found', 404);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = new KategoriJasa();
        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();
        
        return response()->json([
            'id' => $kategori->id,
            'nama' => $kategori->nama,
            'deskripsi' => $kategori->deskripsi,
            'message' => 'Insert data successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = KategoriJasa::find($id);
        if($kategori){
            return response()->json([
                'message' => 'Data Found!!!',
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
            ], 200);
        }
        else
            return response()->json('Data Not Found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($kategori = KategoriJasa::find($id))
        {   
            $nama = $request->nama;
            $deskripsi = $request->deskripsi;
           
            $kategori->nama = $nama;
            $kategori->deskripsi = $deskripsi;
            $kategori->save();

            return response()->json([
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
                'message' => 'Change data successfully!'
            ], 201);
        }
        else
            return response()->json('Data Not Found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($kategori = KategoriJasa::find($id))
        {
            $kategori->delete();
            return response()->json([
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
                'message' => 'Delete data successfully!'
            ], 200);
        }
        else
            return response()->json('Data Not Found', 404);
    }
}
