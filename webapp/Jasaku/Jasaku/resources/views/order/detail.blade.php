@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row mb-3 d-flex">
            <div class="col-md-4">
                <h4>Order-{{ $order->id }}-{{ $order->waktu_dibuat }}</h4>
                <hr class="new1"/>
                <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-edit">Cetak Bukti Pembelian</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h5>Status Pesanan</h5>
                <ul class="list-group list-group-display-user mb-3">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <span class="font-semi-bold">Tanggal Pemesanan</span>
                            </div>
                            <div class="col-md-4">
                                <span>{{ date('d-M-Y', strtotime($order->waktu_dibuat)) }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                <span class="font-semi-bold">Status Pembayaran</span>
                            </div>
                            <div class="col-md-4">
                                <span>
                                    @if ($order->status == "Menunggu Pembayaran")
                                        <label class="badge badge-warning">{{ $order->status }}</label>
                                    @endif

                                    @if ($order->status == "Transaksi Gagal")
                                        <label class="badge badge-danger">{{ $order->status }}</label>
                                    @endif

                                    @if ($order->status == "Sudah Membayar")
                                        <label class="badge badge-primary">{{ $order->status }}</label>
                                    @endif

                                    @if ($order->status == "Dikirim")
                                        <label class="badge badge-info">{{ $order->status }}</label>
                                    @endif

                                    @if ($order->status == "Selesai")
                                        <label class="badge badge-success">{{ $order->status }}</label>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </li>
                    @if ($order->status == "Menunggu Pembayaran")
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                @can('jasa-create')
                                <span>Dana akan dikirimkan ke nomor rekening</span>

                                @else
                                <span>Segera Lakukan Pembayaran ke Rekening</span>

                                @endcan
                            </div>
                            <div class="col-md-4">
                                <span class="font-bold">{{ $order->getJasa->getUser->getPenjual->no_rek }}</span>
                            </div>
                        </div>
                    </li>
                    @endif
                    @can('jasa-create')
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8">
                                Ubah Status Order
                            </div>

                            <div class="col-md-4">
                                <form method="POST" action="{{ route('order.update', $order->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <select class="form-select form-select-sm" name="status" onchange='if(this.value != 0) { this.form.submit(); }'>
                                         <option value='0' disabled selected>Status</option>
                                         <option value="Transaksi Gagal">Transaksi Gagal</option>
                                         <option value='Sudah Membayar'>Sudah Membayar</option>
                                         <option value='Dikirim'>Dikirim</option>
                                         <option value='Selesai'>Selesai</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endcan
                </ul>
                <div class="text-center mb-5">
                    @can('jasa-create')
                    <a href="https://wa.me/{{ $order->getPengguna->no_telp }}" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> Hubungi Pembeli</a>

                    @else
                    <a href="https://wa.me/{{ $order->getJasa->getUser->getPenjual->no_telp }}" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> Hubungi Penjual</a>

                    @endcan
                </div>
            </div>

            <div class="col-md-6">
                <h5>Detail Kerajinan dipesan</h5>
                <img src="{{ asset($order->getJasa->gambar) }}" alt="{{ $order->getJasa->nama }}" width="100%" class="mb-2">

                <div class="row">
                    <div class="col-md-12">
                        <h5>{{ $order->getJasa->nama }}</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @can('jasa-create')
                        <label>{{ __('Dipesan Oleh ') }} <span class="font-bold">{{ $order->getPengguna->nama }}</span></label>

                        @else
                        <label>{{ __('Oleh ') }} <span class="font-bold">{{ $order->getJasa->getUser->getPenjual->nama }}</span></label>

                        @endcan
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>{{ __('Kategori ') }} <span class="font-bold">{{ $order->getJasa->getUser->getKategori->nama }}</span></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>
                            {{ __('Sebanyak ') }} 
                            <span class="font-bold">
                                {{ $order->jumlah_barang }} 
                                @if ($order->jumlah_barang > 1)
                                    pcs
                                @else
                                    pc
                                @endif
                            </span>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr class="new1" style="margin-top: -5px; margin-bottom: -5px"/>
                    </div>
                </div>

                <div class="row" style="margin-bottom: -10px">
                    <div class="col-md-6 font-large">
                        <label>{{ __('Total ') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 font-large">
                        <span>{{ $order->jumlah_barang }} * {{ number_format($order->getJasa->harga) }}</span>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6 text-right font-large font-bold">
                        <span>Rp {{ number_format($order->total_harga) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection