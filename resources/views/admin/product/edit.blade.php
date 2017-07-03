@extends('admin.product.create')

@section('editId', $product->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection