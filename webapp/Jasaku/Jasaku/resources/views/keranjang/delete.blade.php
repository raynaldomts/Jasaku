{{ Form::open(['action' => ['App\Http\Controllers\KeranjangController@destroy', $jasa->id], 'method' => 'POST', 'class' => 'pull-right']) }}
{{ Form::hidden('_method', 'DELETE') }}
{{ Form::submit('Hapus', ['class' => 'btn btn-hapus', 'onclick' => 'return confirm("Konfirmasi penghapusan?");']) }}
{{ Form::close() }}