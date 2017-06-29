@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Colour List</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('colour.create')}}" class="btn btn-info">Add New</a>
		</div>
	</div>

	<ul class="list-group">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created at</th>
					<th>Updated at</th>
					{{-- <th>Action</th> --}}
				</tr>
			</thead>
			<tbody>
				@foreach($colours as $colour)
				<tr>
					<td>{{$colour->name}}</td>	
					<td>{{$colour->created_at->toDayDateTimeString()}}</td>
					<td>{{$colour->updated_at->toDayDateTimeString()}}</td>
					{{-- <td>
						<a href="{{route('colour.edit', $colour->id)}}"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
					</td> --}}
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</ul>
</div>
@endsection