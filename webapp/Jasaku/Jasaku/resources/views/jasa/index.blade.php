@extends('layouts.app')

@section('content')
    
    <div class="container">
        @include('inc.messages')    


        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <h4>Jasa</h4>
                <hr class="new1"/>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-3 mb-3">
                <input type="text" name="keyword_search" id="keyword" class="form-control search-keyword" placeholder="Cari jasa...">
                <div class="list-group list-group-flush search-result ">
                    
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2 col-sm-12 col-xs-12 mb-1">
                <a href="{{ route('jasa.kategori', 1) }}" class="btn btn-kategori">Jasa Service Elektronik</a>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12 mb-1">
                <a href="{{ route('jasa.kategori', 2) }}" class="btn btn-kategori">Jasa Print dan Fotocopy</a>
            </div>
            <div class="col-md-1 col-sm-12 col-xs-12 mb-1">
                <a href="{{ route('jasa.kategori', 3) }}" class="btn btn-kategori">Jasa Kecantikan</a>
            </div>
            <div class="col-md-4 mb-3"></div>
            <div class="col-md-3 text-right">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ __('Urutkan Berdasarkan') }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="{{ route('jasa.sorting', 'abjadasc') }}" class="dropdown-item">Nama (A-Z)</a>
                    <a href="{{ route('jasa.sorting', 'abjaddesc') }}" class="dropdown-item">Nama (Z-A)</a>
                    <a href="{{ route('jasa.sorting', 'hargaasc') }}" class="dropdown-item">Harga (Terendah-Tertinggi)</a>
                    <a href="{{ route('jasa.sorting', 'hargadesc') }}" class="dropdown-item">Harga (Tertinggi-Terendah)</a>
                </div>

            </div>
        </div>

        @if(count($jasa) > 0)

        @foreach($jasa->chunk(3) as $chunk)        
            
            <div class="row">
                @foreach($chunk as $jasa)
                <div class="col-md-4 col-sm-12 col-xs-12" style="padding-bottom: 60px">
                    
                    <div class="card card-jasa">
                        <img class="card-img-top" src="{{ asset($jasa->gambar) }}" alt="Card image cap" height="50%">
                        <div class="card-body">
                            <span class="card-title font-semi-large font-semi-bold">{{ $jasa->nama }}</span>
                            <br/>
                            <span>Bahan {{ $jasa->getKategori->nama }}</span>
                            
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
        {{ $jasa->paginate(6)->links() }}

        @else
            <div class="row">
                <div class="col-md-6">
                    <b>Waduh, belum ada produk jasa yang ditawarkan oleh para penjual.</b>
                    <p>Tetap ditunggu, ya!</p>
                </div>
            </div>

        @endif

    </div>

<script type="text/javascript">

    $(document).ready(function(){
        $(".search-keyword").on('keyup', function(){
            var query = $(this).val();
            if(query.length > 0){
                $.ajax({
                    url:"{{ url('search') }}",
                    data:{
                        q:query
                    },
                    dataType:'json',
                    beforeSend:function(){
                        $(".search-result").html('<li class="list-group-item font-black">Loading...</li>');
                    },
                    success:function(res){
                        var result = '';
                        $.each(res.jasa, function(index, jasa){
                            result += '<a href="/jasa/'+ jasa.id +'"><li class="list-group-item font-black">'+ jasa.nama +'</li></a>'
                            // console.log(jasa);
                        });
                        $(".search-result").html(result);
                        // console.log(res.jasa);
                    }
                });
            }
            else{
                $(".search-result").html('');
                return false;
            }
        });
    });

</script>
@endsection