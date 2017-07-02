@extends('admin.asset.create')

@section('editId', $asset->id)

@section('editMethod')
{{method_field('PUT')}}
@endsection