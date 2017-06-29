@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Product List</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('product.create')}}" class="btn btn-info">Add New</a>
		</div>
	</div>

	<ul class="list-group">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Name</th>
					<th>Status</th>
					<th>Category</th>
					<th>Created at</th>
					<th>Updated at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $product)
				<tr>
					<td>{{$product->name}}</td>	
					<td>{{$product->status}}</td>
					<td>{{$product->category->name}}</td>
					<td>{{$product->created_at->toDayDateTimeString()}}</td>
					<td>{{$product->updated_at->toDayDateTimeString()}}</td>
					<td>
						<a href="{{route('product.edit', $product->id)}}"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</ul>
</div>
@endsection