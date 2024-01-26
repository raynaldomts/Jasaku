@extends('layouts.app')

@section('content')
<div class="auth-master-container">
    <div class="container auth-web">
        <div class="container-auth">
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <h4>Silahkan Registrasi</h4>
                    <hr class="new1"/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
        
                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label label-auth">{{ __('Nama') }}</label>
        
                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}"  autocomplete="nama" autofocus>
        
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label label-auth">{{ __('Alamat Email') }}</label>
        
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="no_telp" class="col-md-4 col-form-label label-auth">{{ __('Nomor Telp.') }}</label>
        
                            <div class="col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                    <input id="id_telp" type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp') }}"  autocomplete="no_telp" autofocus>
                                </div>        
                                {{-- <input type="number" id="id_telp"> --}}

                                @error('no_telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label label-auth">{{ __('Alamat') }}</label>
        
                            <div class="col-md-6">
                                <textarea id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}"  autocomplete="alamat" autofocus>{{ old('alamat') }}</textarea>
        
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label label-auth">{{ __('Mendaftar sebagai?') }}</label>
        
                            <div class="col-md-6">
                                <select name="roles" id="roles" class="form-control @error('roles') is-invalid @enderror">
                                    <option selected disabled>-Pilih-</option>
                                    <option value="2" {{ old('roles') == 2 ? "selected" : "" }}>Penjual</option>
                                    <option value="3" {{ old('roles') == 3 ? "selected" : "" }}>Konsumen</option>
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="hidden1">
                            <label for="no_rek" class="col-md-4 col-form-label label-auth">{{ __('Nomor Rekening') }}</label>
        
                            <div class="col-md-6">
                                <input id="no_rek" type="text" class="form-control @error('no_rek') is-invalid @enderror" name="no_rek" value="{{ old('no_rek') }}"  autocomplete="no_rek" autofocus>
        
                                @error('no_rek')
                                    <span class="invalid-feedback" role="alert">
                                        @if (str_contains($message, '2'))
                                        <strong>{{ str_replace("2", "Penjual", $message) }}</strong>
                                        @endif
                                        {{-- <strong>{{ $message }}</strong> --}}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="hidden2">
                            <label for="deskripsi" class="col-md-4 col-form-label label-auth">{{ __('Deskripsi') }}</label>

                            <div class="col-md-6">
                                <textarea id="deskripsi" type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi') }}"  autocomplete="deskripsi" autofocus>{{ old('deskripsi') }}</textarea>
        
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        @if (str_contains($message, '2'))
                                        <strong>{{ str_replace("2", "Penjual", $message) }}</strong>
                                        @endif
                                        {{-- <strong>{{ $message }}</strong> --}}
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label label-auth">{{ __('Password') }}</label>
        
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
        
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label label-auth">{{ __('Confirm Password') }}</label>
        
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label label-auth">{{ __('Captcha') }}</label>
        
                            <div class="col-md-6">
                                <div class="captcha">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                                <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" name="captcha" value="{{ old('captcha') }}"  autocomplete="captcha" autofocus>
        
                                @error('captcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn-auth">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Sudah memiliki akun? Login <a class="link-auth2" href="{{ route('login') }}">di sini</a>.</label>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

    $("#id_telp").on("input", function() {
        if (/^0/.test(this.value)) {
            this.value = this.value.replace(/^0/, "");
        }
    });

    $("#roles").change(function(){
        if($(this).val() == "2"){
            $('#hidden1').show();
            $('#hidden2').show();
        }
        else{
            $('#hidden1').hide();
            $('#hidden2').hide();
        }
    });
    $("#roles").trigger("change");

</script>
@endsection
