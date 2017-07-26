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
			<a href="{{route('category.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>
	bisa jadi problem kalo misalnya name ada spasi, soalnya kepake di URL /collections/name,
	handle bikin 1 field baru name dan displayName aja, displayname boleh pake spasi
	contoh:
	name sepatu-santai
	display name Sepatu Santai
	
	<form class="form-horizontal" action="/admin/category/@yield('editId')" method="post">
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">

				<label class="col-md-1 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="name" id="name" value="{{$category->name or old('name')}}">
				</div>
			</div>
			<div class="form-group row">

				<label class="col-md-1 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="display_name" id="display_name" value="{{$category->display_name or old('display_name')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Is active</label>
				<div class="col-md-2">
					<select class="form-control" id="is_active" name="is_active">
						@foreach($isActiveOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($category->is_active))
								{{ ($key === $category->is_active) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</fieldset>
	</form>
</div>
@endsection