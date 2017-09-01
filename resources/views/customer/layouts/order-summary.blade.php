<h4>Order Summary</h4>
@if(!empty($cart))
<div id="cart">
	<ul>
	@foreach($cart->productStocks as $productStock)
		<li>
			{{$productStock['productStock']['product']['thumbnail_path']}}<br>
			{{$productStock['productStock']['product']['display_name']}}<br>
			{{$productStock['productStock']['product']['colour_name']}}<br>
			{{$productStock['productStock']['size']['size_value']}}<br>
			{{$productStock['productStock']['size']['size_value']}}<br>
			{{$productStock['productStock']['product']['currency']}}-{{$productStock['productStock']['product']['price']}}<br>
			{{$productStock['qty']}}<br>
			{{$productStock['productStock']['product']['currency']}}-{{$productStock['subTotal']}}<br>
			<input type="hidden" class="id" value="{{$productStock['productStock']['id']}}"></input>
		</li>
	@endforeach
	</ul>
	SUBTOTAL {{$cart->currency}}-{{$cart->grandTotalPrice}}<br>
	PROMO {{$cart->currency}}-{{$cart->promo}}<br>
	SHIPPING {{$cart->currency}}-{{$cart->shippingFee}}<br>
	TOTAL {{$cart->currency}}-{{$cart->grandTotal}}<br>
</div>
@endif