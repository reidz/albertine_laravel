@extends('admin.product.create')

@section('editCurrency', $product->currency)
@section('editAmount', $product->amount)
@section('editStatus', $product->status)
@section('editType', $product->type)
@section('editCategory', $product->category)
@section('editId', $product->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection