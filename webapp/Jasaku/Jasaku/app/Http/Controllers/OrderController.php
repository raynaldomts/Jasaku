<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Jasa;
use App\Models\Keranjang;
use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:order-list|jasa-create|jasa-edit|jasa-delete', ['only' => ['index','show']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        $this->middleware('permission:order-penjual', ['only' => ['penjual']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::user()->id;
        // $order = Order::where('id_pengguna', $id_user)->get();
        $order = Order::with('getJasa')->latest()->where('id_pengguna', $id_user)->get();
        
        return view('order.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'id_jasa' => 'required',
            'jumlah_barang' => 'required',
        ]);

        $user = Auth::user();        
        $jasa = Jasa::find($request->input('id_jasa'));

        $order = new Order;

        $order->jumlah_barang = $request->input('jumlah_barang');
        $order->total_harga = $order->jumlah_barang * $jasa->harga;
        $order->status = 'Menunggu Pembayaran';
        $order->id_pengguna = $user->id;
        $order->id_jasa = $jasa->id ;

        $order->save();

        $jasa->stok -= $order->jumlah_barang;
        $jasa->save();
        
        return redirect()->route('order.index')->with('success', 'Berhasil membuat pesanan. Segera lakukan pembayaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['getJasa', 'getPengguna'])->find($id);
        $order->getJasa->getUser = Jasa::with(['getPenjual', 'getKategori'])->find($order->getJasa->id);

        // return $order->getJasa->getUser->getPenjual->nama;
        return view('order.detail', compact('order'));
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
        $this->validate($request, [
            'status' => 'required|string',
        ]);

        $order = Order::find($id);
        $order->status = $request->input('status');

        $order->save();

        return redirect()->route('order.show', $id)->with('succss', 'Status berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirm(Request $request)
    {
        $id_jasa = $request->input('id_jasa');
        
        $jasa = Jasa::with('getKategori', 'getPenjual')->find($id_jasa);
        $jasa->jumlah_barang = $request->input('jumlah_barang');
        $jasa->harga_akhir = $jasa->harga * $jasa->jumlah_barang;

        $user = Auth::user();
        
        return view('order.confirm', compact(['jasa', 'user']));
    }

    public function pdf($id)
    {
        $user = Auth::user();
        $order = Order::with('getJasa')->find($id);
        $order->getJasa->getUser = Jasa::with(['getPenjual', 'getKategori'])->find($order->getJasa->id);
        
        $pdf = PDF::loadView("order.pdf", compact(['order', 'user']));
        return $pdf->download("Order_$user->nama-id_order_$order->id-$order->waktu_dibuat.pdf");
    }

    public function export_excel()
    {
        $user = Auth::user();
        $date = date('d-M-Y');
        $fileName = "Order_$user->nama-Tgl-$date";
        return Excel::download(new OrderExport, $fileName . ".xlsx");
    }

    public function penjual()
    {
        $order = Order::with(['getJasa', 'getPengguna'])->latest()->paginate(5);

        if(Auth::user()->hasRole('Penjual')){
            $user = Auth::user();

            $order->getJasa = Jasa::with('getKategori')->where('id_penjual', $user->id)->get();
            
            $orders = Order::getOrderKonsumen($user->id);
        }

        if(Auth::user()->hasRole('Admin')){
            $order->getJasa = Jasa::with('getKategori')->get();
            $orders = Order::getOrderAdmin();
        }

        if(Auth::user()->hasRole('Konsumen')){
            return redirect()->route('order.index');
        }

        // $months = Order::select(DB::raw("Month(orders.waktu_dibuat) as month"))
        //     ->whereYear('orders.waktu_dibuat',date('Y'))
        //     ->groupBy(DB::raw("Month(orders.waktu_dibuat)"))
        //     ->pluck('month');

        if( !(count($order->getJasa) > 0) ){
            return view('order.penjual', compact('order'));
        }
        
        $months = Order::getMonth();
        for($i = 0; $i < count($months); $i++){
            $months[$i] -= 1;
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month] = $orders[$index];
        }

        return view('order.penjual', compact(['order', 'datas']));
    }
}
