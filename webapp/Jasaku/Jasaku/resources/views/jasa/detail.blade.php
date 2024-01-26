@extends('layouts.app')

@section('content')
    
    <div class="container">
        @include('inc.messages')

        <div class="row">
            <div class="col-md-4 mb-2 col-sm-12 col-xs-12">
                <img src="{{ asset($jasa->gambar) }}" alt="Jasa {{ $jasa->nama }}" width="100%">
            </div>
            
            <div class="col-md-6 mb-2 col-sm-12 col-xs-12">
                
                <h3 class="title-jasa mb-2">{{ $jasa->nama }}</h3>
                
                <hr class="new1">
                

                <div class="row">
                    <label class="col-md-4 harga-jasa">Rp{{ number_format($jasa->harga) }}</label>
                </div>

                <div class="row">
                    <span class="col-md-12 penjual-jasa font-medium">Pemilik jasa ini : <a href="{{ route('user.jasa', $jasa->getPenjual->id) }}" class="nama-penjual-jasa">{{ $jasa->getPenjual->nama }}</a></span>
                </div>

                <div class="row">
                    <label class="col-md-12 font-medium mb-3">Kategori jasa : {{ $jasa->getKategori->nama }}</label>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="deskripsiKerajinan" class="font-medium">Deskripsi : </label>
                        <p id="deskripsiKerajinan" class="deskripsi-jasa font-medium"> {{ $jasa->deskripsi }}</p>
                    </div>
                </div>

            </div>
            
            <div class="col-md-2 bagian-kiri-jasa">
                
                <div class="row mb-2">
                    <span class="col-md-12 font-large">Stok : {{ $jasa->stok }}</span>
                </div>

                <div class="row">
                    @if($jasa->stok > 0)
                    <div class="col-md-12">
                        {{ Form::open(['action' => ['App\Http\Controllers\KeranjangController@store'], 'method' => 'POST']) }}
                        {{ Form::hidden('id_jasa', $jasa->id) }}
                        {{ Form::submit('Beli', ['class' => 'btn btn-beli']) }}
                        {{ Form::close() }}
                    </div>
                    @else
                    <div class="col-md-12">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Stok habis">
                            <button class="btn btn-beli" style="pointer-events: none;" type="button" disabled>Beli</button>
                        </span>
                    </div>
                    @endif

                    <div class="col-md-12 mt-2">
                    @can('role-create')
                        {{ Form::open(['action' => ['App\Http\Controllers\JasaController@destroy', $jasa->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Hapus', ['class' => 'btn btn-hapus']) }}
                        {{ Form::close() }}
                    @endcan
                    </div>
                </div>
                
                {{-- <div class="row mt-3">
                    <div class="col-md-12">
                        <a href="{{ route('jasa.edit', $jasa->id) }}" class="btn btn-edit">Edit</a>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        {{ Form::open(['action' => ['App\Http\Controllers\JasaController@destroy', $jasa->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Hapus', ['class' => 'btn btn-hapus']) }}
                        {{ Form::close() }}
                    </div>
                </div> --}}
                
            </div>
        </div>
        
    </div>

@endsection