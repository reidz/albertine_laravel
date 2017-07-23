
@extends('customer.layouts.app')

@section('content')

Categories
<ul>
    <li>All</li>
	@foreach($categories as $category)
		{{-- <li>{{$category->name}} <a></a></li> --}}
		<li class="{{ 'a' == $category->name ? 'active' : '' }}"><a href="{{route('customer.collections', $category->name)}}">{{$category->display_name}}</a></li>

	@endforeach
</ul>



Products
@if($products->count() == 0)
  Sorry no product for specified category
@else
<ul>
  @foreach($products as $product)
    <li>{{$product}}</li>
  @endforeach
</ul>
@endif

@unless( empty($products))
{{ $products->links() }}
@endunless

<br>
amount: normal price <br>
sale_amount: sale price <br>
new ? <br>
sale : is_sale <br>
last_pair : stock_available = 1 <br>
sold : status = SOLD_OUT, harusnya ketika jualan stock -1 = 0 then update status to SOLD_OUT <br>

@endsection