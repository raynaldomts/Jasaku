@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-shcraft font-black">
                <div class="card-header card-shcraft-header">{{ __('Verifikasi Alamat Email') }}</div>

                <div class="card-body card-body-shcraft">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link verifikasi baru telah dikirimkan ke Email Kamu') }}
                        </div>
                    @endif

                    {{ __('Kamu tidak dapat menggunakan fitur ini sebelum email kamu terverifikasi') }}
                    {{ __('Jika kamu tidak menerima email verifikasi') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk mengirimkan ulang email verifikasi.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
