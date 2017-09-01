@extends('customer.layouts.app')

@section('content')
@include('customer.layouts.check-out-step')

<form class="form-horizontal" role="form" method="POST" action="{{ route('customer.review-order') }}">
	{{ csrf_field() }}
	<h4>SHIPPING METHOD</h4>
	JNE <br>
	<select class="form-control" id="shipping" name="shipping">
		@foreach($shippingOptions as $key => $value)
			<option value="{{$key}}" >
			{{-- @if(isset($address->province_id)) --}}
			{{-- {{ ($key === $address->province_id) ? 'selected' : '' }} --}}
			{{-- @endif> --}}
			{{$value}}
		</option>
		@endforeach
	</select>


	{{-- form --}}
	{{-- id address --}}
	{{-- detail --}}

	<h4>PAYMENT METHOD</h4>
	How to pay, contact this number<br>

	<button type="submit" class="btn btn-primary">
	    REVIEW AND CONFIRM ORDER >
	</button>
</form>

@include('customer.layouts.order-summary')
@endsection