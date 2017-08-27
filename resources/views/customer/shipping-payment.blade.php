@extends('customer.layouts.app')

@section('content')
@include('customer.layouts.check-out-step')

<h4>SHIPPING METHOD</h4>
JNE <br>
<select class="form-control" id="delivery" name="delivery">
	@foreach($deliveryOptions as $key => $value)
		<option value="{{$key}}" >
		{{-- @if(isset($address->province_id)) --}}
		{{-- {{ ($key === $address->province_id) ? 'selected' : '' }} --}}
		{{-- @endif> --}}
		{{$value}}
	</option>
	@endforeach
</select>

<h4>PAYMENT METHOD</h4>
hardcoded bank transfer <br>

<a class="btn btn-primary" href="#">REVIEW AND CONFIRM ORDER ></a>

@include('customer.layouts.order-summary')
@endsection