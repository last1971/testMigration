@extends('layouts.app')

@section('content')
    <h1 class="row justify-content-center">Прувет!</h1>
    <case-table-component api-url="/cases"></case-table-component>

@endsection
