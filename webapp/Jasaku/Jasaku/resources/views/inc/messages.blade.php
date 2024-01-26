{{-- @if(count($error) > 0)
<div class="alert alert-danger">
    @foreach($error->all() as $error)
        <ul>
            <li>{{ $error }}</li>
        </ul>
    @endforeach
</div>
@endif --}}

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif


{{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
--}}

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif