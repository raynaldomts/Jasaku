@extends('layouts.app')

@section('content')

    <div class="container">
        @include('inc.messages')

        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <h4>Jasa {{ $user->nama }}</h4>
                <hr class="new1"/>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <a href="{{ route('jasa.create') }}" class="btn btn-tambah">Tambah</a>
            </div>
        </div>

        @if (count ($user->getJasaUser) > 0)
        <div class="list-group">

            @foreach ($user->getJasaUser as $jasa)
                
                <a href="{{ route('jasa.edit', $jasa->id) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-2 list-jasa-user">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset($jasa->gambar) }}" alt="" width="100%" class="mb-1 mt-1">
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="container title-list-laporan-group">
                                <div class="kiri">
                                    <h4>{{ $jasa->nama }}</h4>
                                </div>
                                <div class="kanan">
                                    {{ Form::open(['action' => ['App\Http\Controllers\JasaController@destroy', $jasa->id], 'method' => 'POST', 'class' => 'pull-right']) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::submit('Hapus', ['class' => 'btn btn-hapus', 'onclick' => 'return confirm("Konfirmasi penghapusan?");']) }}
                                    {{ Form::close() }}
                                </div>
                                </div>
                            </div>
                            <span class="font-medium font-semi-bold">Rp{{ number_format($jasa->harga) }}</span>
                            <br/>

                            <?php
                                if(strlen($jasa->deskripsi) > 200){
                                    $jasa->deskripsi=substr($jasa->deskripsi, 0, 200) . "...";
                                }
                            ?>
                            <span class="font-semi-medium">Deskripsi Jasa:</span>
                            <p class="font-medium">{{ $jasa->deskripsi }}</p>
                        </div>
                    </div>
                </a>
            
            @endforeach
            
            {{ $user->getJasaUser->links() }}
        </div>

        @else
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="text-danger font-medium" style="font-weight: 600">Kamu belum menawarkan jasa apapun. Ayo, <a href="{{ route('jasa.create') }}">tambahkan sekarang.</a></span>
                </div>
            </div>

        @endif

    </div>
    
@endsection