@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Category List</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('category.create')}}" class="btn btn-info">Add New</a>
		</div>
	</div>

	<ul class="list-group">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Name</th>
					<th>Is Active</th>
					<th>Created at</th>
					<th>Updated at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr>
					<td>{{$category->name}}</td>	
					<td>{{ $category->is_active === 1 ? "Active" : "Inactive" }}</td>
					<td>{{$category->created_at->toDayDateTimeString()}}</td>
					<td>{{$category->updated_at->toDayDateTimeString()}}</td>
					<td>
						<a href="{{route('category.edit', $category->id)}}"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
						{{-- <a href="#" onclick="event.preventDefault(); document.getElementById('delete-{{$category->id}}').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
						<form id="delete-{{$category->id}}" class="form-group pull-right" action="/admin/category/{{$category->id}}" method="post">
							{{method_field('DELETE')}}
							{{csrf_field()}}
						</form> --}}
					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</ul>
</div>
@endsection