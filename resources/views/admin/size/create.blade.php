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
			<a href="{{route('size.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>
	
	<form class="form-horizontal" action="/admin/size/@yield('editId')" method="post">
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">
				<label class="col-md-2 control-label">Size Metric</label>
				<div class="col-md-2">
					<select class="form-control" id="size_metric" name="size_metric">
						@foreach($sizeMetricOptions as $key => $value)
						<option value="{{$key}}" 
							@if(isset($size->size_metric))
								{{ ($key === $size->size_metric) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Size Value</label>
				<div class="col-md-2">					
					<input type="text" class="form-control" name="size_value" id="size_value" value="{{$size->size_value or old('size_value')}}">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</fieldset>
	</form>
</div>
@endsection