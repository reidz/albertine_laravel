@extends('customer.layouts.app')

@section('content')
@include('customer.layouts.check-out-step')

<h4>SHIPPING METHOD</h4>
JNE <br>
list box type

<h4>PAYMENT METHOD</h4>
hardcoded bank transfer <br>

<a class="btn btn-primary" href="#">REVIEW AND CONFIRM ORDER ></a>

@include('customer.layouts.order-summary')
@endsection