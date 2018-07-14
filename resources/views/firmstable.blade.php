@extends('layouts.app')

@section('content')
    <firm-table-component api-url="{{route('firms.index')}}"></firm-table-component>
@endsection