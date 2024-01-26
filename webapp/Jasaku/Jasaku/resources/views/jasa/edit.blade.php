@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row mb-1">
            <div class="col-md-4">
                <h4>Edit {{ $jasa->nama }}</h4>
                <hr class="new1"/>
            </div>
        </div>

        {!! Form::open(['action' => ['App\Http\Controllers\JasaController@update', $jasa->id], 'method' => 'POST', 'files' => true, 'enctype' => 'multipart/form-data']) !!}

            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gambar">Gambar jasa Anda saat ini</label>

                        <img src="{{ asset($jasa->gambar) }}" id="gambar" alt="Gambar Jasa {{ $jasa->nama }}" width="100%">
                    </div>

                    <div class="form-group">
                        {{ Form::label('gambar', 'Ingin mengubah gambar?') }}
                        <br/>
                        <input type="file" name="gambar" id="gambar" class="@error('gambar') is-invalid @enderror">
                        @error('gambar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            
                <div class="col-md-8">
                    <div class="form-group">
                        {{ Form::label('nama', 'Nama Jasa') }}
                        {{ Form::text('nama', $jasa->nama, ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : null), 'placeholder' => 'Nama Jasa...']) }}
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        {{ Form::label('deskripsi', 'Deskripsi Jasa') }}
                        {{ Form::textarea('deskripsi', $jasa->deskripsi, ['class' => 'form-control' . ($errors->has('deskripsi') ? ' is-invalid' : null), 'placeholder' => 'Deskripsi Jasa...']) }}
                        @error('deskripsi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        {{ Form::label('id_kategori', 'Kategori Jasa') }}
                        <br/>
                        {{ Form::select('id_kategori', ['1' => 'Serat Alam', '2' => 'Daur Ulang', '3' => 'Tembikar'], $jasa->id_kategori, ['class' => 'form-control']) }}
                    </div>
        
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                {{ Form::label('harga', 'Harga') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                            {{ Form::text('harga', $jasa->harga, ['class' => 'form-control' . ($errors->has('harga') ? ' is-invalid' : null), 'placeholder' => 'Harga...']) }}
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
                            {{ Form::number('stok', $jasa->stok, ['class' => 'form-control' . ($errors->has('stok') ? ' is-invalid' : null), 'placeholder' => 'Stok...']) }}
                            @error('stok')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::hidden('_method', 'PUT') }} {{-- Penting untuk bagian edit --}}
                        {{ Form::submit('Edit Jasa', ['class' => 'btn btn-edit']) }}
                    </div>
                </div>

            </div>

        {!! Form::close() !!}
    </div>
    
@endsection