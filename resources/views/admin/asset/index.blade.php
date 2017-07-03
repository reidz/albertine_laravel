@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Asset List</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('asset.create')}}" class="btn btn-info">Add New</a>
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
				@foreach($assets as $asset)
				<tr>
					<td>{{$asset->name}} <br>
						<img src="{{asset('storage/'.$asset->thumbnail_path)}}" alt="{{$asset->name}} face" width="80" height="60"> 
					</td>	
					<td>{{$asset->created_at->toDayDateTimeString()}}</td>
					<td>{{$asset->updated_at->toDayDateTimeString()}}</td>
					{{-- <td>
						<a href="{{route('asset.edit', $asset->id)}}"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
						<a href="#" onclick="event.preventDefault(); document.getElementById('delete-{{$asset->id}}').submit();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
						<form id="delete-{{$asset->id}}" class="form-group pull-right" action="/admin/asset/{{$asset->id}}" method="post">
							{{method_field('DELETE')}}
							{{csrf_field()}}
						</form>
					</td> --}}
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</ul>
</div>
@endsection