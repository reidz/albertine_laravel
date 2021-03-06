@extends('customer.layouts.app')

@section('content')
@include('customer.layouts.check-out-step')
{{-- bikin component aja ini ntar kalo misalnya udah di 2, bisa back ke 1, tapi dari 2 ga bisa ke 3 kalo belom --}}

<h4>Shipping Address</h4>

{{-- if customer doesn't have address, handle with new address --}}

<span>New address, will replace old address</span>

<div id="address-form">
	<form class="form-horizontal" role="form" method="POST" action="{{ route('customer.shipping-address-save') }}">
	   	@unless(empty($address))
	   	<label class="radio-inline">
	   		<input type="radio" class="my_address" name="my_address" value="old" {!! !empty($address) ? "checked=\"checked\"" : "" !!}>MY ADDRESS
	   	</label>
	   	@endunless
	   	<label class="radio-inline">
	   		<input type="radio" class="my_address" name="my_address" value="new" {!! empty($address) ? "checked=\"checked\"" : "" !!}>NEW ADDRESS
	   	</label>
	    {{ csrf_field() }}

	    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <input id="first_name" type="input" class="form-control input-text" name="first_name" value="{{$address->first_name or old('first_name')}}" required autofocus placeholder="FIRST NAME">

	            @if ($errors->has('first_name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('first_name') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <input id="last_name" type="input" class="form-control input-text" name="last_name" value="{{$address->last_name or old('last_name')}}" required autofocus placeholder="LAST NAME">

	            @if ($errors->has('last_name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('last_name') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <input id="address" type="input" class="form-control input-text" name="address" value="{{$address->address or old('address')}}" required autofocus placeholder="ADDRESS">

	            @if ($errors->has('address'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('address') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
	        <div class="col-md-6">
				<select class="form-control" id="province_id" name="province_id">
					@foreach($provinceOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($address->province_id))
						{{ ($key === $address->province_id) ? 'selected' : '' }}
						@endif>
						{{$value}}
					</option>
					@endforeach
				</select>

	            @if ($errors->has('province_id'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('province_id') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <select class="form-control" id="city_id" name="city_id">
					@foreach($cityOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($address->city_id))
						{{ ($key === $address->city_id) ? 'selected' : '' }}
						@endif>
						{{$value}}
					</option>
					@endforeach
				</select>

	            @if ($errors->has('city_id'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('city_id') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('subdistrict_id') ? ' has-error' : '' }}">
	        <div class="col-md-6">
				<select class="form-control" id="subdistrict_id" name="subdistrict_id">
					@foreach($subdistrictOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($address->subdistrict_id))
						{{ ($key === $address->subdistrict_id) ? 'selected' : '' }}
						@endif>
						{{$value}}
					</option>
					@endforeach
				</select>

	            @if ($errors->has('subdistrict_id'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('subdistrict_id') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <input id="postal_code" type="input" class="form-control input-text" name="postal_code" value="{{$address->postal_code or old('postal_code')}}" required autofocus placeholder="POSTAL CODE">

	            @if ($errors->has('postal_code'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('postal_code') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
	        <div class="col-md-6">
	            <input id="phone" type="input" class="form-control input-text" name="phone" value="{{$address->phone or old('phone')}}" required autofocus placeholder="PHONE">

	            @if ($errors->has('phone'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('phone') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-8 col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                SHIPPING & PAYMENT METHOD
	            </button>
	        </div>
	    </div>
	</form>
</div>

{{-- <a class="btn btn-primary" href="{{route('customer.shipping-payment')}}">SHIPPING & PAYMENT METHOD</a> --}}

@include('customer.layouts.order-summary')

	@section('js')
	<script type="text/javascript">

		$(document).on('change', '.my_address', function(event) {
			var radioValue = $("input[name='my_address']:checked"). val();
			if(radioValue == 'new')
				$('.input-text').val('');
			else
				$('#address-form').load(location.href + ' #address-form');
		});
	</script>
	@endsection
@endsection