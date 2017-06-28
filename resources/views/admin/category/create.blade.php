@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')

<div class= "container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>{{$page->title}}</h1>
		</div>
		<div class="pull-right">
			<a href="/admin/category" class="btn btn-info">Back</a>
		</div>
	</div>
	
	<form class="form-horizontal" action="/admin/category/@yield('editId')" method="post">
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">
				<label for="inputEmail" class="col-md-1 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="name" id="name" value="@yield('editName')">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputEmail" class="col-md-1 control-label">Is active</label>
				<div class="col-md-2">
					<select class="form-control" id="is_active" name="is_active">
						@foreach($isActiveOptions as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</fieldset>
	</form>
</div>
@endsection