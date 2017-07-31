@extends('customer.layouts.app')

@section('content')

<h3>Category</h3>
{{$category}}
<br>
<h3>Product</h3>
{{$product}}
<br>

<h3>Asset assignments</h3>
@if(empty($assetAssignments))
	kosong ga ada asset assignment, display default image
@else
	<ul>
	@foreach($assetAssignments as $assetAssignment)
		<li>{{$assetAssignment}}</li>
	@endforeach
	</ul>
@endif

<h3>Product Stock</h3>
@if(empty($productStocks))
	kosong ga ada product stock, handle aja pake out of stock
@else
	<ul>
	@foreach($productStocks as $productStock)
		<li>{{$productStock}} <a href="{{route('customer.add-to-cart', [$productStock->id, 1])}}">Add to Cart</a></li>
	@endforeach
	</ul>
@endif

<h3>Product Detail</h3>
{!! $product->details !!}

<h3>Size chart</h3>
@include('customer.size-chart-small')

<h3>Recommendations</h3>
ini masi tarik top 4 products
@if(empty($recommendations))
	kosong ga ada recommendation, ga usa tongolin apa2
@else
	<ul>
	@foreach($recommendations as $product)
		<li>{{$product}}</li>
	@endforeach
	</ul>
@endif

@endsection