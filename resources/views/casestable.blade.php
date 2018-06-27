@extends('layouts.app')

@section('content')
    <case-table-component api-url="{{route('cases.index')}}"></case-table-component>

@endsection