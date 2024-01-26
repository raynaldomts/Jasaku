@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row mb-1">
            <div class="col-md-4">
                <h4>Konfirmasi Pemesanan</h4>
                <hr class="new1"/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <h5>Identitas</h5>
                <ul class="list-group list-group-display-user mb-3">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="font-bold">Nama Lengkap</span>
                            </div>
                            <div class="col-md-8">
                                <span>{{ $user->nama }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="font-bold">Alamat Email</span>
                            </div>
                            <div class="col-md-8">
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="font-bold">Nomor Telepon</span>
                            </div>
                            <div class="col-md-8">
                                <span>{{ $user->no_telp }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <span class="font-bold">Alamat Rumah</span>
                            </div>
                            <div class="col-md-8">
                                <span>{{ $user->alamat }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-6">
                <h5>Detail Pesanan</h5>
                <img src="{{ asset($jasa->gambar) }}" alt="{{ $jasa->nama }}" width="100%" class="mb-2">

                <div class="row">
                    <div class="col-md-12">
                        <h5>{{ $jasa->nama }}</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>{{ __('Oleh ') }} <span class="font-bold">{{ $jasa->getPenjual->nama }}</span></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>{{ __('Kategori ') }} <span class="font-bold">{{ $jasa->getKategori->nama }}</span></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>
                            {{ __('Sebanyak ') }} 
                            <span class="font-bold">
                                {{ $jasa->jumlah_barang }} 
                                @if ($jasa->jumlah_barang > 1)
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
                        <span>{{ $jasa->jumlah_barang }} * {{ number_format($jasa->harga) }}</span>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6 text-right font-large font-bold">
                        <span>Rp {{ number_format($jasa->harga_akhir) }}</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                {{ Form::open(['action' => 'App\Http\Controllers\OrderController@store', 'method' => 'POST']) }}
                {{ Form::hidden('id_jasa', $jasa->id) }}
                {{ Form::hidden('jumlah_barang', $jasa->jumlah_barang) }}
                {{ Form::submit('Konfirmasi', ['class' => 'btn btn-beli-keranjang'])}}
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection