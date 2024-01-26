@extends('layouts.app')

@section('content')
    
    <div class="container">
        @include('inc.messages')

        <div class="row d-flex justify-content-between">
            <div class="col-md-4 mb-3">
                <h4>Order</h4>
                <hr class="new1" style="margin-bottom: 15px; margin-top: -2px;"/>
                <a href="{{ route('order.excel') }}" class="btn-edit">Export Excel</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                @can('role-create')
                    <span>Halaman ini menampilkan order yang sudah dilakukan pada website ini</span>
                @endcan
                @can('jasa-create')
                    <span>Halaman ini menampilkan jasa kamu yang dipesan oleh pengguna lain</span>
                @endcan
            </div>
        </div>

        @if (count($order) > 0)
            <div class="list-group">
                @if( !(Auth::user()->hasRole('Admin')) )
                    @foreach ($order as $o)
                        @if($o->getJasa->id_penjual == Auth::user()->id)
                        <a href="{{ route('order.show', $o->id) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-2 list-order-user">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="container title-list-laporan-group">
                                            <div class="kiri">
                                                <h4>Order-{{ $o->id }}-{{ $o->waktu_dibuat }}</h4>
                                                <span>
                                                    Dipesan tanggal {{ date('d-M-Y', strtotime($o->waktu_dibuat)) }}
                                                    oleh <b>{{ $o->getPengguna->nama }}</b>
                                                </span>
                                                <br>
                                                <span>Status Order: 
                                                    @if ($o->status == "Menunggu Pembayaran")
                                                        <label class="badge badge-warning">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Transaksi Gagal")
                                                        <label class="badge badge-danger">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Sudah Membayar")
                                                        <label class="badge badge-primary">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Dikirim")
                                                        <label class="badge badge-info">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Selesai")
                                                        <label class="badge badge-success">{{ $o->status }}</label>
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="kanan text-right">
                                                <h5>{{ $o->getJasa->nama }}</h5>
                                                <span>Rp {{ number_format($o->total_harga) }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </a>
                        @endif
                    @endforeach
                    {{ $o->paginate(5)->links() }}
                    
                @else 
                    {{-- Jika admin maka ini akan berjalan --}}
                    @foreach ($order as $o)
                        <a href="{{ route('order.show', $o->id) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-2 list-order-user">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="container title-list-laporan-group">
                                            <div class="kiri">
                                                <h4>Order-{{ $o->id }}-{{ $o->waktu_dibuat }}</h4>
                                                <span>
                                                    Dipesan tanggal {{ date('d-M-Y', strtotime($o->waktu_dibuat)) }}
                                                    oleh <b>{{ $o->getPengguna->nama }}</b>
                                                </span>
                                                <br>
                                                <span>Status Order: 
                                                    @if ($o->status == "Menunggu Pembayaran")
                                                        <label class="badge badge-warning">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Transaksi Gagal")
                                                        <label class="badge badge-danger">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Sudah Membayar")
                                                        <label class="badge badge-primary">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Dikirim")
                                                        <label class="badge badge-info">{{ $o->status }}</label>
                                                    @endif

                                                    @if ($o->status == "Selesai")
                                                        <label class="badge badge-success">{{ $o->status }}</label>
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="kanan">
                                                <h5>{{ $o->getJasa->nama }}</h5>
                                                <span>Rp {{ number_format($o->total_harga) }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </a>
                    @endforeach
                {{ $o->paginate(5)->links() }}

                @endif
            </div>

            <div class="mt-3" style="width:100%; margin:auto; padding:10px 20px; background-color:white; border-radius:10px;">
                <canvas id="barChart"></canvas>
            </div>
        
            <script>
                $(function(){
                    var datas = <?php echo json_encode($datas); ?>;
                    var barCanvas = $("#barChart");
                    var barChart = new Chart(barCanvas, {
                        type:'bar',
                        data:{
                            labels:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets:[
                                {
                                    label:'History Order {{ Auth::user()->nama }}',
                                    data:datas,
                                    backgroundColor:['red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'violet', 'purple', 'pink', 'silver', 'gold', 'brown']
                                }
                            ]
                        },
                        options:{
                            scales:{
                                yAxes:[{
                                    ticks:{
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                });
            </script>
            
        @else
        <div class="row">
            <div class="col-md-6">
                <b>Waduh, belum ada orderan nih.</b>
                <p>Tetap ditunggu, ya!</p>
            </div>
        </div>
            
        @endif

    </div>

@endsection