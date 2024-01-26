@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-tb mb-3">
            <div class="pull-left">
              <h2>Kelola User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}">Tambah User Baru</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif


    <table class="table table-bordered text-center font-white">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th>
        </tr>
        @foreach ($data as $key => $user)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif
            </td>
            <td>
                
                <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Detail</a>
                
                @can('user-edit')
                <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                @endcan

                @can('user-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline'])
                !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}    
                @endcan
                
            </td>
        </tr>
        @endforeach
    </table>


    {!! $data->render() !!}
</div>

@endsection