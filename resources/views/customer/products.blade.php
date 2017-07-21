
@extends('customer.layouts.app')

@section('content')

categories
<ul>
	@foreach($categories as $category)
		<li>{{$category->name}}</li>
	@endforeach
</ul>

products

<ul>
	@foreach($products as $product)
		<li>{{$product->name}}</li>
	@endforeach
</ul>

<input type="hidden" name="page" value="{{$page}}">
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
@endsection