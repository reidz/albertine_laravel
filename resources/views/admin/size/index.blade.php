@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Size List</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('size.create')}}" class="btn btn-info">Add New</a>
		</div>
	</div>

	<ul class="list-group">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Metric</th>
					<th>Size</th>
					<th>Created at</th>
					<th>Updated at</th>
					{{-- <th>Action</th> --}}
				</tr>
			</thead>
			<tbody>
				@foreach($sizes as $size)
				<tr>
					<td>{{$size->size_metric}}</td>	
					<td>{{$size->size_value}}</td>
					<td>{{$size->created_at->toDayDateTimeString()}}</td>
					<td>{{$size->updated_at->toDayDateTimeString()}}</td>
					{{-- <td>
						<a href="/admin/size/{{$size->id}}/edit"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
					</td> --}}
				</tr>
				@endforeach
			</tbody>
		</table>
	</ul>
</div>
@endsection