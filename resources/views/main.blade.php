@extends('layouts.app')

@section('content')
    <h1 class="row justify-content-center">Прувет!</h1>
    <articles-table-component api-url="/articles"></articles-table-component>

@endsection
