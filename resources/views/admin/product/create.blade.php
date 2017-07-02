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
			<a href="{{route('product.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>

	<form class="form-horizontal" action="/admin/product/@yield('editId')" method="post">
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">
				<label class="col-md-1 control-label">Category</label>
				<div class="col-md-2">
					<select class="form-control" id="category" name="category">
						@foreach($categoryOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($product->category))
								{{ ($key === $product->category->id) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Type</label>
				<div class="col-md-2">
					<select class="form-control" id="type" name="type">
						@foreach($typeOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($product->type))
								{{ ($key === $product->currency) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="name" id="name" value="{{$product->name or old('name')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Currency - Amount</label>
				<div class="col-md-2">
					<select class="form-control" id="currency" name="currency">
						@foreach($currencyOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($product->is_active))
								{{ ($key === $product->currency) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-1 control-label">Status</label>
				<div class="col-md-2">
					<select class="form-control" id="status" name="status">
						@foreach($statusOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($product->is_active))
								{{ ($key === $product->status) ? 'selected' : '' }}
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