@extends('layouts.app')

@section('content')

    <div class="container">
        @include('inc.messages')
        <div class="row mb-1 d-flex justify-content-between">
            <div class="col-md-4">
                <h4>Keranjang Saya</h4>
                <hr class="new1"/>
            </div>
            {{-- <div class="col-md-2 mb-3 text-right">
                <a href="{{ route('order.index') }}" class="btn btn-beli-keranjang">Order</a>
            </div> --}}
        </div>

        @if (count($keranjang->getKeranjangJasa) > 0)
            
            @foreach ($keranjang->getKeranjangJasa as $jasa)
                <span class="list-group-item list-group-item-action flex-column align-items-start mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset($jasa->gambar) }}" alt="{{ $jasa->nama }}" width="100%" class="mb-1 mt-1">

                            {{ Form::open(['action' => 'App\Http\Controllers\OrderController@confirm', 'method' => 'POST', 'class' => 'pull-right']) }}
                            {{ Form::hidden('id_jasa', $jasa->id) }}
                            <select name="jumlah_barang" id="" class="form-control" style="color: orange; font-weight:600" onchange='if(this.value != 0) { this.form.submit(); }'>
                                <option selected disabled value="0">-Ingin Order? Pilih Jumlah Jasa-</option>
                                @for($i = 1; $i <= $jasa->stok; $i++)
                                    <option value="{{ $i }}" class="font-black">{{ $i }}</option>
                                @endfor
                            </select>
                            {{ Form::close() }}
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="container title-list-laporan-group">
                                <div class="kiri">
                                    <a href="{{ route('jasa.show', $jasa->id) }}">
                                        <h4>{{ $jasa->nama }}</h4>
                                    </a>
                                </div>
                                <div class="kanan">
                                    {{ Form::open(['action' => ['App\Http\Controllers\KeranjangController@destroy', $jasa->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Hapus', ['class' => 'btn btn-hapus', 'onclick' => 'return confirm("Konfirmasi penghapusan?");']) }}
                                    {{ Form::close() }}
                                </div>
                                </div>
                            </div>
                            <span class="font-medium font-semi-bold">Rp{{ number_format($jasa->harga) }}</span>
                            <br/>
                            <p class="font-medium">Tersisa {{ $jasa->stok }} barang</p>

                            <?php
                                if(strlen($jasa->deskripsi) > 200){
                                    $jasa->deskripsi=substr($jasa->deskripsi, 0, 200) . "...";
                                }
                            ?>
                            <span class="font-semi-medium">Deskripsi Jasa:</span>
                            <p class="font-medium">{{ $jasa->deskripsi }}</p>
                        </div>
                    </div>
                </span>
            @endforeach
        @else

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="font-medium" style="font-weight: 600">Kamu belum menambahkan apapun di keranjang kamu. Ayo, <a href="{{ route('jasa.index') }}">belanja sekarang.</a></span>
                </div>
            </div>

        @endif

    </div>
    
@endsection