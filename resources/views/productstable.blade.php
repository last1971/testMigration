@extends('layouts.app')

@section('content')
    <product-table-component api-url="{{route('products.index')}}"></product-table-component>

@endsection