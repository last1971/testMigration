@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Информация</div>

                <div class="card-body">

                    <useredit :user='{!!  Auth::user()->toJson() !!}' :errors='[]' action="{{route('users.index',Auth::user()->id)}}"></useredit>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

