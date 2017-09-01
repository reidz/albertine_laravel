@extends('customer.layouts.app')

@section('content')
@include('customer.layouts.check-out-step')

<form class="form-horizontal" role="form" method="POST" action="{{ route('customer.shipping-address-save') }}">

<h4>SHIPPING ADDRESS</h4>
<div id="address-form">
	    {{ csrf_field() }}
	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->first_name}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->last_name}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->address}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->province->name}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->city->name}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->subdistrict->name}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->postal_code}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-6">
	            {{$address->phone}}
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-8 col-md-offset-4">
	            <button type="submit" class="btn btn-primary">
	                CONFIRM ORDER
	            </button>
	        </div>
	    </div>
	
</div>

<h4>SHIPPING METHOD</h4>
JNE <br>
{{$shipping}}
</form>

{{-- form --}}
{{-- id address --}}
{{-- detail --}}

<h4>PAYMENT METHOD</h4>
How to pay, contact this number<br>

@include('customer.layouts.order-summary')
@endsection