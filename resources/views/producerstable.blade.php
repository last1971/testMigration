@extends('layouts.app')

@section('content')
    <producer-table-component api-url="{{route('producers.index')}}"></producer-table-component>

@endsection