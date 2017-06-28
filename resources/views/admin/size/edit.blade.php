@extends('admin.size.create')

@section('editSizeMetric', $size->size_metric)
@section('editSizeValue', $size->size_value)
@section('editId', $size->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection