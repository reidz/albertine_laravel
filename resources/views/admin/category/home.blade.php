@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
<br>
<a href="/category/create" class="btn btn-info">Add New</a>
<div class="col-lg-4 col-lg-offset-4">
	<h1>Category List</h1>
	
	<ul class="list-group col-lg-8">
		{{-- @foreach($todos as $todo)
			<li class="list-group-item">
				<a href="/todo/{{$todo->id}}">{{$todo->title}}</a>
				<span class="pull-right">{{$todo->created_at->diffForHumans()}}</span>
			</li>
		@endforeach --}}
	</ul>

	<ul class="list-group col-lg-4">
		{{-- @foreach($todos as $todo)
			<li class="list-group-item">
				<a href="/todo/{{$todo->id}}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
				<form style="margin-top:-8px;" class="form-group pull-right" action="/todo/{{$todo->id}}" method="post">
					{{method_field('DELETE')}}
					{{csrf_field()}}
					<button type="submit" class="form-control" style="border:none;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				</form>
			</li>
		@endforeach --}}
	</ul>
</div>
@endsection