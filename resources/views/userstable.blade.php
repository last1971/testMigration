@extends('layouts.app')

@section('content')
    <userstable api-url="{{route('users.index')}}"></userstable>

@endsection