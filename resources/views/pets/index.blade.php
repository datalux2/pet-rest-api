@extends('layout')

@section('content')
<div class="col-lg-12 margin-tb">
    <div class="pull-left mb-5">
        <h1>Lista elementów zasobu PET</h1>
    </div>
</div>
<div>
	<a href="{{ route('list-by-status', 'available') }}" class="d-block mb-3">Lista elementów o statusie available</a>
	<a href="{{ route('list-by-status', 'pending') }}" class="d-block mb-3">Lista elementów o statusie Pending</a>
	<a href="{{ route('list-by-status', 'sold') }}" class="d-block mb-3">Lista elementów o statusie sold</a>
</div>
@endsection
