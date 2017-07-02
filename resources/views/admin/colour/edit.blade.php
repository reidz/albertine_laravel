@extends('admin.colour.create')

@section('editId', $colour->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection