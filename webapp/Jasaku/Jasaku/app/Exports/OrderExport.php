<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $order = Order::whereHas('getJasa', function($query){
        //     $query->where('id_penjual', '=', Auth::user()->id);
        // })->get();

        $order = Order::getOrderPenjualExcel();
        return $order;
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->getJasa->nama,
            $order->jumlah_barang,
            $order->total_harga,
            $order->status,
            $order->waktu_dibuat,
        ];
    }

    public function headings(): array
    {
        return ["ID Order", "Nama Barang", "Jumlah Barang", "Total Harga", "Status", "Waktu Pemesanan"];
    }
}
