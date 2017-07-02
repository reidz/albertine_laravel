@extends('admin.category.create')

@section('editId', $category->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection