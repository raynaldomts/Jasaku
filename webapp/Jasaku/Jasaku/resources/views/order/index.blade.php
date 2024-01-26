@extends('layouts.app')

@section('content')
    
    <div class="container">
        @include('inc.messages')
        
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <h4>Order</h4>
                <hr class="new1" style="margin-bottom:5px; margin-top: -2px;"/>
            </div>
        </div>
        @can('jasa-create')
        <div class="row mb-3">
            <div class="col-md-6">
                <span>Halaman ini menampilkan jasa yang kamu pesan</span>
            </div>
        </div>
        @endcan

        @if (count($order) > 0)
            <div class="list-group mt-3">

                @foreach ($order as $o)

                    <a href="{{ route('order.show', $o->id) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-2 list-order-user">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="container title-list-laporan-group">
                                        <div class="kiri">
                                            <h4>Order-{{ $o->id }}-{{ $o->waktu_dibuat }}</h4>
                                            <span>Dipesan tanggal {{ date('d-M-Y', strtotime($o->waktu_dibuat)) }}</span>
                                            <br>
                                            <span>Status Order: 
                                                @if ($o->status == "Menunggu Pembayaran")
                                                    <label class="badge badge-warning">{{ $o->status }}</label>
                                                @endif

                                                @if ($o->status == "Transaksi Gagal")
                                                    <label class="badge badge-danger">{{ $o->status }}</label>
                                                @endif

                                                @if ($o->status == "Sudah Membayar")
                                                    <label class="badge badge-primary">{{ $o->status }}</label>
                                                @endif

                                                @if ($o->status == "Dikirim")
                                                    <label class="badge badge-info">{{ $o->status }}</label>
                                                @endif

                                                @if ($o->status == "Selesai")
                                                    <label class="badge badge-success">{{ $o->status }}</label>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="kanan text-right">
                                            <h5>{{ $o->getJasa->nama }}</h5>
                                            <span>Rp {{ number_format($o->total_harga) }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </a>

                @endforeach

            </div>
        @else
        
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <span class="font-medium" style="font-weight: 600">Kamu belum memesan jasa apapun. Ayo, <a href="{{ route('jasa.index') }}">cari</a> jasa favorit kamu sekarang!</span>
            </div>
        </div>

        @endif

    </div>

@endsection