@extends('customer.layouts.app')

@section('content')

{{csrf_field()}}


@if(!empty($productStocks))
<div id="cart">
	<ul>
	@foreach($productStocks as $productStock)
		<li>
			{{-- {{$productStock['productStock']}}<br> --}}
			{{$productStock['productStock']['product']['display_name']}}<br>
			{{$productStock['productStock']['product']['colour_name']}}<br>
			{{$productStock['productStock']['size']['size_value']}}<br>
			{{$productStock['productStock']['product']['currency']}}-{{$productStock['productStock']['product']['price']}}<br>
			{{$productStock['qty']}}<br>
			{{$productStock['productStock']['product']['currency']}}-{{$productStock['subTotal']}}<br>
			<input type="hidden" class="id" value="{{$productStock['productStock']['id']}}"></input>
			<a class="remove-cart" href="#">Remove</a><br>
		</li>
	@endforeach
	</ul>
	<h3>Grand total: {{$currency}}-{{$grandTotalPrice}}</h3>
</div>
<a href="{{route('customer.collections', 'all')}}">Continue Shopping</a><br>
<a href="#">Check Out</a>
@else
	link to collections/all
@endif
@endsection

@section('js')
<script type="text/javascript">

	$('.remove-cart').click(function(event) {
		var r = confirm("Are you sure want to remove this cart item ?");
		if (r == true)
		{
			var id = $(this).siblings(':hidden[class=id]').val();
			// console.log(id);
			if(id != '')
			{
				$.post('/remove-cart', {
													'_token': $('input:hidden[name=_token]').val(),
													'id': id}, function(data) {										
					if(data == 'success')
					{
						alert('Success');
						$('#cart').load(location.href + ' #cart');
					}
					else
					{
						alert('Failed');
						
					}
				});
			}
		}	
	});
</script>
@endsection