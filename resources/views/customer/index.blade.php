
@extends('customer.layouts.app')

@section('content')
<div class="container-fluid no-padding">
		 <img src="http://placehold.it/1600x150" class="img-responsive" />
		
		<p class="text-center">FEATURED COLLECTIONS</p>

		<div class="row">
			@foreach($featuredProducts as $featuredProduct)
				<div class="gallery_product col-md-4" style="width: 250px;">
					<img src="{{asset('storage/'.$featuredProduct->thumbnail_path)}}">
				</div>
			@endforeach
		</div>
					
		<p class="text-center"><a href="{{route('customer.collections', 'all')}}">VIEW ALL COLLECTIONS</a></p>
	</div>
	@endsection