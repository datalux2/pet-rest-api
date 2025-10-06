@extends('layout')

@section('content')
<div class="col-lg-12 margin-tb">
    <div class="pull-left mb-5">
        <h1>Formularz dodawania elementu do zasobu PET</h1>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        Wystąpiły błędy:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('api-add-pet') }}" method="POST" id="add-pet-form">
    @csrf
    
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong>Nazwa:</strong>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
    	<div class="form-group">
            <strong>Nazwa kategorii:</strong>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong class="d-block mb-3">Tagi:</strong>
            <div id="list-tags">
            	@if(is_array(old('tag_names')) && !empty(old('tag_names')))
                	@foreach(old('tag_names') as $key => $tag)
                	<div class="row">
                		<div class="col-10">
                    		<strong>Nazwa tagu {{ $key+1 }}:</strong>
                    		<input type="text" class="form-control mb-3" name="tag_names[]" value="{{ $tag }}" />
                		</div>
                		<div class="col-2 d-flex align-items-end pb-3">
                			<input type="button" class="del-tag-button" value="Usuń tag"/>
                		</div>
                	</div>
                	@endforeach
            	@endif
            	<input type="button" id="add-tag-button" value="Dodaj tag">
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong>Status:</strong>
            <input type="text" name="status" class="form-control" value="{{ old('name') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Dodaj</button>
    </div>
   
</form>

@endsection
