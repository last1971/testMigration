@extends('layouts.app')

@section('content')
    <h1 class="row justify-content-center">Прувет!</h1>
    <product-for-sale-component api-url="{{route('products.index')}}"></product-for-sale-component>

@endsection
