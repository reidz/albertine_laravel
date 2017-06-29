@extends('admin.colour.create')

@section('editName', $colour->name)
@section('editId', $colour->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection