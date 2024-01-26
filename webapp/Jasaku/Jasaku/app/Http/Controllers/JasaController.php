<?php

namespace App\Http\Controllers;

use App\Models\KategoriJasa;
use App\Models\Jasa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:jasa-list|jasa-create|jasa-edit|jasa-delete', ['only' => ['index','show']]);
        $this->middleware('permission:jasa-create', ['only' => ['create','store']]);
        $this->middleware('permission:jasa-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jasa-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jasa = Jasa::latestPaginatedJasa();
        return view('jasa.index')->with('jasa', $jasa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'id_kategori' => 'required',
        ]);
        
        $id_user = Auth::user()->id;

        $file = $request->file('gambar');
        $extension = $request->file('gambar')->guessExtension();
        $fileName = $request->input('nama') . '_' . date("d-m-Y_H-i-s") . '_' . $id_user . '.' . $extension;
        $fileDestination = 'uploaded/jasa';

        $file->move($fileDestination, $fileName);

        $jasa = new Jasa;
        $jasa->nama = $request->input('nama');
        $jasa->deskripsi = $request->input('deskripsi');
        $jasa->harga = $request->input('harga');
        $jasa->stok = $request->input('stok');
        $jasa->gambar = $fileDestination . '/' . $fileName;
        $jasa->id_kategori = $request->input('id_kategori'); // foreign key
        $jasa->id_penjual = $id_user; // foreign key

        $jasa->save();

        return redirect()->route('jasa.index')->with('success', 'Jasa Anda sudah ditayangkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jasa = Jasa::findKerajinanShow($id);
        
        return view('jasa.detail', compact('jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jasa = Jasa::findKerajinanEdit($id);
        
        $id_user = Auth::user()->id;

        if($jasa->getPenjual->id != $id_user){
            return redirect()->route('jasa.show', $id)->with('error', 'Kamu tidak dapat meng-edit jasa yang bukan milikmu!');
        }

        return view('jasa.edit', compact('jasa'));
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
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:10000',
            'id_kategori' => 'required',
        ]);

        $id_user = Auth::user()->id;

        if($request->file('gambar')){

            $file = $request->file('gambar');
            $extension = $request->file('gambar')->guessExtension();
            $fileName = $request->input('nama') . '_' . date("d-m-Y_H-i-s") . '_' . $id_user . '.' . $extension;
            $fileDestination = 'uploaded/jasa';

            $file->move($fileDestination, $fileName);
        }

        $jasa = Jasa::find($id);
        $jasa->nama = $request->input('nama');
        $jasa->deskripsi = $request->input('deskripsi');
        $jasa->harga = $request->input('harga');
        $jasa->stok = $request->input('stok');
        if($request->file('gambar')){
            $jasa->gambar = $fileDestination . '/' . $fileName;
        }
        $jasa->id_kategori = $request->input('id_kategori'); // foreign key
        $jasa->id_penjual = $id_user; // foreign key

        $jasa->save();
        
        return redirect()->route('jasa.index')->with('success', 'Berhasil mengedit jasa dengan nama ' . $jasa->nama);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jasa = Jasa::find($id);

        $id_user = Auth::user()->id;
        
        if($jasa->getPenjual->id != $id_user){
            return redirect()->route('jasa.show', $id)->with('error', 'Kamu tidak dapat menghapus jasa yang bukan milikmu!');
        }

        $jasa->delete();

        return redirect()->route('jasa.index')->with('success', 'Berhasil menghapus produk jasa.');
    }

    public function perKategori($id)
    {
        $kategori = KategoriJasa::perKategori($id);
        $kategori->getJasa = $kategori->getJasa()->orderBy('waktu_dibuat', 'desc')->paginate(6);
        // return $kategori;
        return view('jasa.kategori', compact('kategori'));
    }

    public function user()
    {
        $id_user = Auth::user()->id;

        $user = User::KerajinanMilikUser($id_user);
        $user->getJasaUser = $user->getJasaUser()->orderBy('waktu_dibuat', 'desc')->paginate(5);
        
        return view('jasa.user', compact('user'));
    }
    
    public function search(Request $request)
    {
        if($request->has('q')){
            $search = $request->q;

            $jasa_result = Jasa::where('nama', 'like', '%' . $search . '%')->get();
            return response()->json(['jasa' => $jasa_result]);
        }
        else{
            
        }
    }

    public function sorting($sort)
    {
        // $sort = $request->input('sort');
        if($sort == 'abjadasc'){
            $jasa = Jasa::sortBy('nama', 'ASC');
        }

        if($sort == 'abjaddesc'){
            $jasa = Jasa::sortBy('nama', 'DESC');
        }

        if($sort == 'hargaasc'){
            $jasa = Jasa::sortBy('harga', 'ASC');
        }

        if($sort == 'hargadesc'){
            $jasa = Jasa::sortBy('harga', 'DESC');
        }

        return view('jasa.index')->with('jasa', $jasa);
    }
}
