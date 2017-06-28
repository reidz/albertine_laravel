@extends('admin.category.create')

@section('editName', $category->name)
@section('editIsActive', $category->is_active)
@section('editId', $category->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection