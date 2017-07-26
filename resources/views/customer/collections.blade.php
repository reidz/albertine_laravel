@extends('customer.layouts.app')

@section('content')

Categories
<ul>

    <li class="{{ Request::segment(2) == 'all' ? 'active' : '' }}"><a href="{{route('customer.collections', 'all')}}">All</a></li>
	@foreach($categories as $category)
		{{-- <li>{{$category->name}} <a></a></li> --}}
		<li class="{{ Request::segment(2) == $category->name ? 'active' : '' }}"><a href="{{route('customer.collections', $category->name)}}">{{$category->display_name}}</a></li>

	@endforeach
</ul>



Products
@if($products->count() == 0)
  Sorry no product for specified category
@else
<ul>
  @foreach($products as $product)
    <li>{{$product}} <br>categoryName: {{$product->category->name}}<br> <a href="{{route('customer.collections.detail', [$product->category->name, $product->name])}}">here</a><br>
    	<img src="{{asset(empty($product->thumbnail_path) ? 'http://placehold.it/200x150' :'storage/'.$product->thumbnail_path)}}"> <br>
      {!! $product->details !!}
    </li>
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