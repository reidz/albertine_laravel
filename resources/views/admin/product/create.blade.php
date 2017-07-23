@extends('admin.layouts.app')

@section('css')
<style>
	.gallery_product
	{
		margin-bottom: 30px;
		text-align: center;
	}

	.gallery_product img
	{
		border: 1px solid #50514F;
	}

	.modal-dialog{
	    overflow-y: initial !important
	}
	.modal-body{
	    max-height: calc(100vh - 200px);
	    overflow-y: auto;
	}
</style>
@endsection

@section('content')
@include('layouts.message')
@include('layouts.errors')

<div class= "container-fluid">
	<div class="row">
		<div class="pull-left">
			<h1>{{$page->title}}</h1>
		</div>
		<div class="pull-right">
			<a href="{{route('product.index')}}" class="btn btn-info">Back</a>
		</div>
	</div>

	<form class="form-horizontal" action="/admin/product/@yield('editId')" method="post">
	
		{{csrf_field()}}
		@section('editMethod')
		@show
		<fieldset>
			<div class="form-group row">
				<label class="col-md-2 control-label">Category</label>
				<div class="col-md-2">
					<select class="form-control" id="category" name="category">
						@foreach($categoryOptions as $key => $value)
							<option value="{{$key}}" 
							@if(isset($product->category))
							{{ ($key === $product->category->id) ? 'selected' : '' }}
							@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Type</label>
				<div class="col-md-2">
					<select class="form-control" id="type" name="type">
						@foreach($typeOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->type))
						{{ ($key === $product->type) ? 'selected' : '' }}
						@endif>
							{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="name" id="name" value="{{$product->name or old('name')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Colour</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="colour_name" id="colour_name" value="{{$product->colour_name or old('colour_name')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Display Name</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="display_name" id="display_name" value="{{$product->display_name or old('display_name')}}">
				</div>
			</div>
			<div class="form-group row form-inline">
				<label class="col-md-2 control-label">Currency - Amount</label>
				<div class="col-md-4">
					<select class="form-control" id="currency" name="currency">
						@foreach($currencyOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->is_active))
						{{ ($key === $product->currency) ? 'selected' : '' }}
						@endif>
						{{$value}}
					</option>
					@endforeach
				</select>
					<input type="number" class="form-control" name="amount" id="amount" value="{{$product->amount or old('amount')}}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Is Sale</label>
				<div class="col-md-2">
					<select class="form-control" id="is_sale" name="is_sale">
						@foreach($yesnoOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->is_sale))
						{{ ($key === $product->is_sale) ? 'selected' : '' }}
						@endif>
						{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row form-inline">
				<label class="col-md-2 control-label">Sale Amount</label>
				<div class="col-md-4">
					<input type="number" class="form-control" name="sale_amount" id="sale_amount" value="{{$product->sale_amount or old('sale_amount')}}">
				</div>
			</div>
			{{-- <div class="form-group row form-inline">
				<label class="col-md-2 control-label">Alloted Stock</label>
				<div class="col-md-4">
					<input type="number" class="form-control" name="stock" id="stock" value="{{$product->stock or old('stock')}}">
				</div>
			</div> --}}
			<div class="form-group row">
				<label class="col-md-2 control-label">Status</label>
				<div class="col-md-2">
					<select class="form-control" id="status" name="status">
						@foreach($statusOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->status))
						{{ ($key === $product->status) ? 'selected' : '' }}
						@endif>
						{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Details</label>
				<div class="col-md-2">
					<textarea rows="5" class="form-control" name="details" id="details" value="{{$product->details or old('details')}}">{{$product->details or old('details')}}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Is Featured</label>
				<div class="col-md-2">
					<select class="form-control" id="is_featured" name="is_featured">
						@foreach($yesnoOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->is_featured))
						{{ ($key === $product->is_featured) ? 'selected' : '' }}
						@endif>
						{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Is New</label>
				<div class="col-md-2">
					<select class="form-control" id="is_new" name="is_new">
						@foreach($yesnoOptions as $key => $value)
						<option value="{{$key}}" 
						@if(isset($product->is_new))
						{{ ($key === $product->is_new) ? 'selected' : '' }}
						@endif>
						{{$value}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="well">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</fieldset>
	</form>
			@if(!empty($product))
			<div class="form-group row form-inline">
				<label class="col-md-2 control-label">Sizes</label>
				<button type="button" id="addStock" class="btn btn-primary" data-toggle="modal" data-target="#modalStock">
					Add Stock Size
				</button>
			</div>
			@endif

			<div id="stocks">
				@if(!empty($productStocks))
					<table class="table table-striped table-hover" style="width: 500px;">
						<thead>
							<tr>
								<th>Size</th>
								<th>Stock</th>
								<th>Is active</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					@foreach($productStocks as $productStock)
							<tr>
								<td>{{$productStock->size->size_value}}</td>
								<td>{{$productStock->stock}}</td>
								<td>{{$productStock->is_active}}</td>
								<td>
									<a href="#stocks" class="stocks"><span class="glyphicon glyphicon-pencil btn-spacing" aria-hidden="true"></span></a>
									<input type="hidden" name="id" value="{{$productStock->id}}" />
									<input type="hidden" name="size_id" value="{{$productStock->size_id}}" />
									<input type="hidden" name="stock" value="{{$productStock->stock}}" />
									<input type="hidden" name="is_active" value="{{$productStock->is_active}}" />
								</td>
							</tr>
					@endforeach
						</tbody>
					</table>
				@endif
			</div>

<div class="modal fade" id="modalStock" tabindex="-1" role="dialog" aria-labelledby="modalStockLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalProductStockLabel">Product Stock</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="modalStockId" id="modalStockId" value="" />
				<input type="hidden" name="modalStockProductId" id="modalStockProductId" value="{{$product->id}}" />

				<div class="row">
					<label class="col-md-2">Size</label>
					<select class="form-control" id="modalStockSize" name="modalStockSize">
						@foreach($sizeOptions as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
						@endforeach
					</select>
				</div>

				<div class="row">
					<label class="col-md-2">Stock</label>
					<input type="number" class="form-control" name="modalStockStock" id="modalStockStock" value="">
				</div>

				<div class="row">
					<label class="col-md-2">Is active</label>
					<input type="number" class="form-control" name="modalStockIsActive" id="modalStockIsActive" value="">
					<p class="text-muted">1: active, 0: inactive</p>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="modalStockSave">Save changes</button>
			</div>
		</div>
	</div>
</div>

			@if(!empty($product))
			<div class="form-group row form-inline">
				<label class="col-md-2 control-label">Asset Assignments</label>
				<button type="button" id="addAssignment" class="btn btn-primary" data-toggle="modal" data-target="#modalAssignment">
					Add Asset Assignment
				</button>
			</div>

			<div id="assignments">
				@if(!empty($assetAssignments))
					@foreach($assetAssignments as $assetAssignment)
						<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6">
							<img src="{{asset('storage/'.$assetAssignment->asset->thumbnail_path)}}" class="img-responsive center-block assignments">
							<input type="hidden" name="id" value="{{$assetAssignment->id}}" />
							<input type="hidden" name="asset_id" value="{{$assetAssignment->asset_id}}" />
							<input type="hidden" name="assignment_id" value="{{$assetAssignment->assignment_id}}" />
							<input type="hidden" name="weight" value="{{$assetAssignment->weight}}" />
							<input type="hidden" name="image_path" value="{{$assetAssignment->asset->image_path}}" />
							<input type="hidden" name="thumbnail_path" value="{{$assetAssignment->asset->thumbnail_path}}" />
						</div>
					@endforeach
				@endif
			</div>
				
<!-- Modal -->
<div class="modal fade" id="modalAssignment" tabindex="-1" role="dialog" aria-labelledby="modalAssignmentLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalAssignmentLabel">Asset Assignment</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="modalId" id="modalId" value="" />
				<input type="hidden" name="modalAssetId" id="modalAssetId" value="" />
				<input type="hidden" name="modalAssignmentId" id="modalAssignmentId" value="{{$product->id}}" />

				<div class="row">
					<label class="col-md-2">Weight</label>
					<input type="number" class="col-md-2 col-md-offset-2" name="modalWeight" id="modalWeight" value="">
				</div>
				<div class="row">
					<img src="" name="modalImagePath" id="modalImagePath" class="img-responsive center-block assignments">
				</div>
				<div class="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAssets ">
					Assign Asset
					</button>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="modalAssignmentRemove">Remove</button>
				<button type="button" class="btn btn-primary" id="modalAssignmentSave">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAssets" tabindex="-1" role="dialog" aria-labelledby="modalAssetsLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalAssetsLabel">Assets</h4>
			</div>
			<div class="modal-body">
				@if(!empty($assets))
					@foreach($assets as $asset)
					<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6">
						<img src="{{asset('storage/'.$asset->thumbnail_path)}}" class="img-responsive center-block assets">
						<input type="hidden" name="id" value="{{$asset->id}}" />
						<input type="hidden" name="image_path" value="{{asset('storage/'.$asset->image_path)}}" />
					</div>
					@endforeach
				@endif
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
@endif

<div class="clearfix"></div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {

		 $(".assignmentAlert").hide();

		 $(document).on('click', '.assignments', function(event) {
		 	var id = $(this).siblings(':hidden[name=id]').val();
			var assetId = $(this).siblings(':hidden[name=asset_id]').val();
			var assignmentId = $(this).siblings(':hidden[name=assignment_id]').val();
			var weight = $(this).siblings(':hidden[name=weight]').val();
			var imagePath = $(this).siblings(':hidden[name=image_path]').val();
			imagePath =  '{{asset('storage')}}/'+imagePath;

			$("#modalAssignment #modalId").val(id);
			$("#modalAssignment #modalAssetId").val(assetId);
			$("#modalAssignment #modalAssignmentId").val(assignmentId);
			$("#modalAssignment #modalWeight").val(weight);
			$("#modalAssignment #modalImagePath").attr('src', imagePath);
			$('#modalAssignment').modal('show');
			console.log(id+'-'+assetId+'-'+assignmentId+'-'+weight+'-'+imagePath);
		 });

		$('.assets').dblclick(function(event) {
			var id = $(this).siblings(':hidden[name=id]').val();
			var imagePath = $(this).siblings(':hidden[name=image_path]').val();
			$("#modalAssignment #modalAssetId").val(id);
			$("#modalAssignment #modalImagePath").attr('src', imagePath);
			$('#modalAssets ').modal('hide');
			$('#assignment').modal('handleUpdate');
			console.log(id+'-'+imagePath);
		});

		$('#addStock').click(function(event) {
			// clear modal input values first
			$("#modalStock #modalStockId").val('');
			$("#modalStock #modalStockSize").val('');
			$("#modalStock #modalStockStock").val('');
			$("#modalStock #modalStockIsActive").val('');
			$("#modalStock #modalStockSize").prop('disabled', false);
		});

		$('.stocks').click(function(event) {
			var id = $(this).siblings(':hidden[name=id]').val();
			var size_id = $(this).siblings(':hidden[name=size_id]').val();
			// var product_id = $(this).siblings(':hidden[name=product_id]').val();
			var stock = $(this).siblings(':hidden[name=stock]').val();
			var is_active = $(this).siblings(':hidden[name=is_active]').val();

			$("#modalStock #modalStockSize").prop('disabled', 'disabled');

			// console.log(id+'-'+stock);
			$("#modalStock #modalStockId").val(id);
			$("#modalStock #modalStockSize").val(size_id);
			$("#modalStock #modalStockStock").val(stock);
			$("#modalStock #modalStockIsActive").val(is_active);
			$('#modalStock').modal('show');
			// console.log(id+'-'+imagePath);
		});

		$('#addAssignment').click(function(event) {
			// clear modal input values first
			$("#modalAssignment #modalId").val('');
			$("#modalAssignment #modalAssetId").val('');
			$("#modalAssignment #modalWeight").val('');
			$("#modalAssignment #modalImagePath").attr('src', '');
		});

		$('#modalStockSave').click(function(event) {
			var id = $("#modalStock #modalStockId").val();
			var size_id = $("#modalStock #modalStockSize").val();
			var stock = $("#modalStock #modalStockStock").val();
			var is_active = $("#modalStock #modalStockIsActive").val();
			var product_id = $("#modalStock #modalStockProductId").val();
			if(id == '')
			{
				$.post('/admin/productStock/create', {
													'_token': $('input:hidden[name=_token]').val(),
													'size_id': size_id,
													'product_id': product_id,
													'stock': stock,
													'is_active': is_active}, function(data) {														
					if(data == 'success')
					{
						alert('Success');
						$('#stocks').load(location.href + ' #stocks');
					}
					else
					{
						alert('Failed');
						
					}
					$('#modalStock').modal('hide');
				});
			}
			else
			{
				$.post('/admin/productStock/update', {
													'_token': $('input:hidden[name=_token]').val(),
													'id': id,
													'stock': stock,
													'is_active': is_active}, function(data) {	
					if(data == 'success')
					{
						// white space before #name is intended
						$('#stocks').load(location.href + ' #stocks');
						alert('Success');
					}
					else
					{
						alert('Failed');
					}
					$('#modalStock').modal('hide');
				});
			}
		});
		
		$('#modalAssignmentSave').click(function(event) {
			var id = $("#modalAssignment #modalId").val();
			var weight = $("#modalAssignment #modalWeight").val();
			var assetId = $("#modalAssignment #modalAssetId").val();
			var assignmentId = $("#modalAssignment #modalAssignmentId").val();

			// insert
			if(id == '')
			{
				$.post('/admin/assetAssignment/create', {
													'_token': $('input:hidden[name=_token]').val(),
													'weight': weight,
													'asset_id': assetId,
													'assignment_type': 'PRODUCT',
													'assignment_id': assignmentId}, function(data) {
					if(data == 'successs')
					{
						alert('Success');
						$('#assignments').load(location.href + ' #assignments');
					}
					else
					{
						alert('Failed');
					}
					$('#modalAssignment').modal('hide');
				});
			}
			else
			{
				$.post('/admin/assetAssignment/update', {
													'id': id, 
													'_token': $('input:hidden[name=_token]').val(),
													'weight': weight,
													'asset_id': assetId,
													'assignment_type': 'PRODUCT',
													'assignment_id': assignmentId}, function(data) {
					if(data == 'success')
					{
						alert('Success');
						// white space before #name is intended
						$('#assignments').load(location.href + ' #assignments');
						
					}
					else
					{
						alert('Failed');
					}
					$('#modalAssignment').modal('hide');
				});
			}
		});

		$('#modalAssignmentRemove').click(function(event) {
			var r = confirm("Are you sure want to remove this asset assignment ?");
			if (r == true)
			{
			    var id = $("#modalAssignment #modalId").val();
			    console.log(id);
			    $.post('/admin/assetAssignment/delete', {'id': id, '_token': $('input:hidden[name=_token]').val()}, function(data) {
			    	if(data == 'success')
			    	{
			    		alert('Success');
			    		// white space before #name is intended
			    		$('#assignments').load(location.href + ' #assignments');
			    	}
			    	else
			    	{
			    		alert('Failed');
			    	}
			    	$('#modalAssignment').modal('hide');
			    });
			}
		});
	});
</script>
@endsection