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
			<a href="{{route('order.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>
	
	<form class="form-horizontal" action="/admin/order/{{$order->id}}" method="post">
		{{method_field('PUT')}}
		{{csrf_field()}}
		<fieldset>
			<div class="form-group row">
				<label class="col-md-2 control-label">Buyer</label>
				<label class="col-md-2 control-label">{{$order->user_email}}<br>{{$order->user_last_name}}, {{$order->user_first_name}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Order date</label>
				<label class="col-md-2 control-label">{{$order->created_at->toDayDateTimeString()}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Total Item Qty, Price</label>
				<label class="col-md-2 control-label">{{$order->grand_total_qty}} item(s), {{$order->currency}} {{$order->grand_total_price}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Total Shipping</label>
				<label class="col-md-2 control-label">{{$order->currency}} {{$order->shipping_price}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Promo</label>
				<label class="col-md-2 control-label">{{$order->currency}} {{$order->promo_price}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Grand Total</label>
				<label class="col-md-2 control-label">{{$order->currency}} {{$order->grand_total}}</label>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Status</label>
				<div class="col-md-2">
					<select class="form-control" id="status" name="status">
						@foreach($editStatusOptions as $key => $value)
							<option value="{{$key}}" 
							@if(isset($order->status))
							{{ ($key === $order->status) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-2 control-label">Reason</label>
				<div class="col-md-2">
					<textarea class="form-control" rows="3" name="reason">{{$order->reason or old('reason')}}</textarea>					
				</div>
			</div>
{{-- 			<div class="form-group row">
				<label class="col-md-2 control-label">Size Value</label>
				<div class="col-md-2">					
					<input type="text" class="form-control" name="size_value" id="size_value" value="{{$size->size_value or old('size_value')}}">
				</div>
			</div> --}}
			<button type="submit" class="btn btn-primary">Save</button>
		</fieldset>
	</form>
</div>
@endsection