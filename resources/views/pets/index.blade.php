@extends('layout')

@section('content')
<div class="col-lg-12 margin-tb">
    <div class="pull-left mb-5">
        <h1>Lista elementów zasobu PET</h1>
    </div>
</div>
<div>
	<a href="{{ route('list-by-status', 'available') }}" class="d-block mb-3">Lista elementów o statusie available</a>
	<a href="{{ route('list-by-status', 'pending') }}" class="d-block mb-3">Lista elementów o statusie pending</a>
	<a href="{{ route('list-by-status', 'sold') }}" class="d-block mb-3">Lista elementów o statusie sold</a>
</div>
<div>
	<div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong>Status:</strong>
    		<input type="text" name="status" id="status" />
    	</div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="button" class="btn btn-primary" id="show-list-by-status">Wyświetl</button>
    </div>
</div>
@endsection
