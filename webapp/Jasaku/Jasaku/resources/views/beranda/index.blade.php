@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row title">
        <div class="col-md-12 mb-1">
            <h2 class="title-beranda">Selamat datang di <span class="brand-name font-xlarge font-less-bold">Jasaku</span></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <hr class="new1">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{-- <hr class="new1"> --}}
            <h3 class="subtitle-1-beranda">Penyedia Jasa di Indonesia</h3>
            {{-- <hr class="new1"> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <hr class="new1">
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mt-2">
            <p class="subtitle-2-beranda">
                <span class="brand-name">Jasaku</span> adalah platform penyedia jasa online yang berfokus mempertemukan para pancari jasa dan penyedia 
                jasa di Indonesia. Melalui <span class="brand-name">Jasaku</span> Anda dapat mendukung UMKM lokal 
                untuk terus berinovasi.
            <p class="subtitle-beranda">
        </div>
    </div>


</div>


@endsection