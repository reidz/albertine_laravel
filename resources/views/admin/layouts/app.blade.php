<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF=8">
	<title>Albertine Admin</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>
		.btn-spacing{
			margin-right: 5px;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Albertine Admin</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="{{ Request::is('admin/category', 'admin/category/*') ? 'active' : '' }}"><a href="{{route('category.index')}}">Category <span class="sr-only">(current)</span></a></li>
					<li class="{{ Request::is('admin/colour', 'admin/colour/*') ? 'active' : '' }}"><a href="#">Colour</a></li>
					<li class="{{ Request::is('admin/product', 'admin/product/*') ? 'active' : '' }}"><a href="#">Product</a></li>
					<li class="{{ Request::is('admin/size', 'admin/size/*') ? 'active' : '' }}"><a href="{{route('size.index')}}">Size</a></li>
					<li class="{{ Request::is('admin/purchase', 'admin/purchase/*') ? 'active' : '' }}"><a href="#">Purchase</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			@section('content')
			@show
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
</body>
</html>