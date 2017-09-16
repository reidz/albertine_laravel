@extends('admin.layouts.app')

@section('content')
@include('layouts.message')
@include('layouts.errors')
<div class="container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>Order List</h1>
		</div>
	</div>

	<div>
		<form class="form-horizontal" role="form" method="POST" action="{{ route('order.search') }}">
		    {{ csrf_field() }}

		    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		        <div class="col-md-6">
		        	<label for="email">Email</label>
		            <input id="email" type="input" class="form-control input-text" name="email" value="{{$filter->email or old('email')}}" autofocus placeholder="EMAIL">

		            @if ($errors->has('email'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('email') }}</strong>
		                </span>
		            @endif
		        </div>
		    </div>

		    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
		    	<div class="col-md-6">
		    		<label for="email">Status</label>
		    		<select class="form-control" id="status" name="status">
		    			@foreach($statusOptions as $key => $value)
		    			<option value="{{$key}}" 
		    			@if(isset($filter->status))
		    			{{ ($key === $filter->status) ? 'selected' : '' }}
		    			@endif>
		    			{{$value}}
		    			</option>
		    			@endforeach
			    	</select>

			    	@if ($errors->has('status'))
			    	<span class="help-block">
			    		<strong>{{ $errors->first('status') }}</strong>
			    	</span>
			    	@endif       
			    </div>
		    </div>

		    <div class="form-group">
		        <div class="col-md-8 col-md-offset-4">
		            <button type="submit" class="btn btn-primary">
		                SEARCH
		            </button>
		        </div>
		    </div>
		</form>
	</div>

	<ul class="list-group">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>Buyer</th>
					<th>Order date</th>
					<th>Total Payment</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{$order->user_email}}<br>{{$order->user_first_name}} {{$order->user_last_name}}</td>
					<td>{{$order->created_at->toDayDateTimeString()}}</td>
					<td>{{$order->grand_total}}</td>
					<td>{{$order->status}}</td>
					<td>
						<a href="{{route('order.edit', $order->id)}}"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</ul>
</div>
@endsection