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
			<div class="well">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</fieldset>
	</form>

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
				<button type="button" class="btn btn-default" data-dismiss="modal" id="modalAssignmentRemove">Remove</button>
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
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
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

		$('#addAssignment').click(function(event) {
			// clear modal input values first
			$("#modalAssignment #modalId").val('');
			$("#modalAssignment #modalAssetId").val('');
			$("#modalAssignment #modalWeight").val('');
			$("#modalAssignment #modalImagePath").attr('src', '');
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
					if(data == 'failed')
					{
						alert('Failed');
					}
					else
					{
						alert('Success');
						$('#assignments').load(location.href + ' #assignments');
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
					if(data == 'failed')
					{
						alert('Failed');
					}
					else
					{
						alert('Success');
						// white space before #name is intended
						$('#assignments').load(location.href + ' #assignments');
					}
					$('#modalAssignment').modal('hide');
				});
			}
		});

		$('#modalAssignmentRemove').click(function(event) {
			var id = $("#modalAssignment #modalId").val('');
			// ajax post remove
		});
	});
</script>
@endsection