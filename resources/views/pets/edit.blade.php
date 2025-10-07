@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mb-5">
            <h1>Edycja elementu w zasobie PET</h1>
        </div>
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

@if($httpCode == 200)
<form action="{{ route('api-edit-pet') }}" method="POST" id="edit-pet-form">
    @csrf
    
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong>ID elementu:</strong>
            {{ $data['id'] }}
            <input type="hidden" name="id" value="{{ $data['id'] }}" />
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong>Nazwa:</strong>
            <input type="text" name="name" class="form-control" value="{{ old('name', $data['name'] ?? '') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
    	<div class="form-group">
            <strong>Nazwa kategorii:</strong>
            <input type="text" name="category_name" class="form-control" 
            	value="{{ old('category_name', $data['category']['name'] ?? '') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <div class="form-group">
            <strong class="d-block mb-3">Tagi:</strong>
            <div id="list-tags">
            	@if(old('tag_names', $data['tags']) !== null && is_array(old('tag_names', $data['tags'])) && 
            		!empty(old('tag_names', $data['tags'])))
                	@foreach(old('tag_names', $data['tags']) as $key => $tag)
                	<div class="row">
                		<div class="col-10">
                    		<strong>Nazwa tagu {{ $key+1 }}:</strong>
                    		<input type="text" class="form-control mb-3" name="tag_names[]" value="{{ $tag['name'] ?? $tag }}" />
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
            <input type="text" name="status" class="form-control" value="{{ old('status', $data['status'] ?? '') }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Aktualizuj</button>
    </div>
   
</form>
@else

<div class="alert alert-danger">
	<div class="mb-3">
    	Wystąpił błąd przesyłania danych.
    </div>
    <div class="mb-3">
    	Kod błędu HTTP: {{ $httpCode }}
    </div>
    @switch($httpCode)
        @case(404)
            Brak elementu PET w zasobie REST API
            @break
    
        @case(400)
            Nieprawidłe pole id elementu PET w zasobie REST API
            @break
    
        @default
            Nieokrelony błąd
	@endswitch
</div>

@endif
    
@endsection
