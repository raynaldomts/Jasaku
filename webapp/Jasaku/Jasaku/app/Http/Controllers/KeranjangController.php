<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::user()->id;

        // $keranjang = Keranjang::find($id_user);
        $keranjang = Keranjang::with('getKeranjangJasa')->find($id_user);
        
        return view('keranjang.index', compact('keranjang'));
        // return $keranjang;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('keranjang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_user = Auth::user()->id;

        $id_jasa = $request->input('id_jasa');

        $keranjang = Keranjang::find($id_user);

        if($keranjang->getKeranjangJasa->contains($id_jasa)){
            return redirect()->route('keranjang.index')->with('error', 'Kamu sudah menambahkan produk itu di keranjang!');
        }

        $keranjang->getKeranjangJasa()->attach($id_jasa);

        return redirect()->route('jasa.index')->with('success', 'Berhasil menambahkan ke keranjang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id_user = Auth::user()->id;

        $id_jasa = $id;

        $keranjang = Keranjang::find($id_user);

        $keranjang->getKeranjangJasa()->detach($id_jasa);

        return redirect()->route('keranjang.index')->with('success', 'Berhasil menghapus produk dari keranjang');
    }
}
