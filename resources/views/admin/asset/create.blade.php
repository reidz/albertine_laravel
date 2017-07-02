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
			<a href="{{route('asset.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>
	<form class="form-horizontal" action="/admin/asset/@yield('editId')" method="post" {!! !isset($asset->id) ? "enctype=\"multipart/form-data\"" : " "  !!} > 
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">
				<label class="col-md-1 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="name" id="name" value="{{$asset->name or old('name')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Image</label>
				<div class="col-md-2">
					<label class="btn btn-default btn-file">
						Browse <input type="file" name="image" style="display: none;">
					</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</fieldset>
	</form>
</div>
@endsection
