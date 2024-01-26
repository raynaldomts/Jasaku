@extends('layouts.app')

@section('content')

    <div class="container">
        @include('inc.messages')

        <div class="row mb-3">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <h4>Kategori Jasa {{ $kategori->nama }}</h4>
                <hr class="new1"/>
                <span>{{ $kategori->deskripsi }}</span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <a href="{{ route('jasa.index') }}" class="btn btn-kategori">Kembali</a>
            </div>
        </div>

        <?php
            // $paginate = "jangan";
            // if(count($kategori->getJasa) == 6){
                // $paginate = "gas";
            // }
        ?>

        {{-- {{ $paginate }} --}}

        @if (count ($kategori->getJasa) > 0)
            
            @foreach ($kategori->getJasa->chunk(3) as $chunk)

                <div class="row">
                    @foreach ($chunk as $jasa)
                    <div class="col-md-4 col-sm-12 col-xs-12" style="padding-bottom: 60px">
                    
                        <div class="card card-jasa">
                            <img class="card-img-top" src="{{ asset($jasa->gambar) }}" alt="Card image cap" height="50%">
                            <div class="card-body">
                                <span class="card-title font-semi-large font-semi-bold">{{ $jasa->nama }}</span>
                                <br/>
                                
                                <?php
                                    // if(strlen($jasa->deskripsi) > 80){
                                    //     $jasa->deskripsi=substr($jasa->deskripsi, 0, 80) . "...";
                                    // }
                                ?>
                                {{-- <p class="card-text">{{ $jasa->deskripsi }}</p> --}}
                                <div class="card-text">
                                    <p class="cut-text">{{ $jasa->deskripsi }}</p>
                                </div>
    
                                <label class="font-medium font-semi-bold">Rp{{ number_format($jasa->harga) }}</label>
    
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <a href="{{ route('jasa.show', $jasa->id) }}" class="btn btn-detail">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    @endforeach
                </div>
                
            @endforeach
            {{ $kategori->getJasa->links() }}
            
        @else
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="text-danger" style="font-weight: 600">Belum ada jasa jasa untuk kategori ini. Coba lihat jasa-jasa lainnya, ya!</span>
                </div>
            </div>

        @endif

    </div>

@endsection