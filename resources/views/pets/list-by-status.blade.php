@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mb-5">
            <h1>Lista elementów o statusie {{ $status }} zasobu PET</h1>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($data)
<table class="table table-bordered">
		<thead>
			<tr>
				<td>Id</td>
				<td>Id kategorii</td>
				<td>Nazwa kategorii</td>
				<td>Nazwa</td>
				<td>Status</td>
				<td>Akcje</td>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $pet)
			<tr>
				<td>{{ $pet['id'] }}</td>
				<td>{{ $pet['category']['id'] ?? '-' }}</td>
				<td>{{ $pet['category']['name'] ?? '-' }}</td>
				<td>{{ $pet['name'] ?? '-' }}</td>
				<td>{{ $pet['status'] ?? '-' }}</td>
				<td>
					<a href="{{ route('edit', $pet['id']) }}" class="d-block mb-2">Edytuj</a>
					<a href="javascript: void(0);" class="del-pet-link d-block mb-2" id="{{ $pet['id'] }}">Usuń</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
	<div class="pagination">
  		{{ $data->links() }}
	</div>
@else if(!session('success'))
    <div class="alert alert-danger">
            Wystąpił błąd pobierania danych:<br/><br/>
            Kod HTTP błedu: {{ $httpCode }}
    </div>
@endif
@endsection
