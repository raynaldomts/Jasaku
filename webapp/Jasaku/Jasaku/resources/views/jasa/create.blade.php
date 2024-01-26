@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row mb-1">
            <div class="col-md-4">
                <h4>Tambah Jasa</h4>
                <hr class="new1"/>
            </div>
        </div>
        
        @include('inc.messages')

        {!! Form::open(['action' => 'App\Http\Controllers\JasaController@store', 'files' => true, 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group">
            {{ Form::label('nama', 'Nama Jasa') }}
            {{ Form::text('nama', '', ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : null), 'placeholder' => 'Nama Jasa...']) }}
            @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            {{ Form::label('deskripsi', 'Deskripsi Jasa') }}
            {{ Form::textarea('deskripsi', '', ['class' => 'form-control' . ($errors->has('deskripsi') ? ' is-invalid' : null), 'placeholder' => 'Deskripsi Jasa...']) }}
            @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group row">
            <div class="col-md-3">
            {{ Form::label('id_kategori', 'Kategori Jasa') }}
            <br/>
            {{-- {{ 
                Form::select('id_kategori', 
                ['0' => '-Pilih Kategori-', '1' => 'Serat Alam', '2' => 'Daur Ulang', '3' => 'Tembikar'], 
                0, 
                ['class' => 'form-control form-select-sm'],
                [0 => ["disabled" => true]]
            ) }} --}}
            <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                <option value="0" selected disabled>-Pilih Kategori-</option>
                <option value="1" {{ old('id_kategori') == 1 ? "selected" : "" }}>Jasa Service Elektronik</option>
                <option value="2" {{ old('id_kategori') == 2 ? "selected" : "" }}>Jasa Print dan Fotocopy</option>
                <option value="3" {{ old('id_kategori') == 3 ? "selected" : "" }}>Jasa Kecantikan</option>
            </select>
            @error('id_kategori')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    {{ Form::label('harga', 'Harga') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                {{ Form::text('harga', '', ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : null), 'placeholder' => 'Harga...']) }}
                @error('harga')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    {{ Form::label('stok', 'Stok') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                {{ Form::number('stok', '', ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : null), 'placeholder' => 'Stok...']) }}
                @error('stok')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('gambar', 'Gambar') }}
            <br/>
            <input type="file" name="gambar" id="gambar" class="@error('gambar') is-invalid @enderror">
            @error('gambar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <br/>
        
        {{ Form::submit('Tambah Jasa'), ['class' => 'btn btn-success'] }}

        {!! Form::close() !!}
    </div>


@endsection