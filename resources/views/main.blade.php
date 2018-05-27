@extends('layouts.app')

@section('content')
    <hero></hero>
    <div class="modal fade modal-centered user-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать информацию о пользователе</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer form-group row mb-0">

                        <div class="col-md-8 offset-md-4">
                            <button class="btn btn-primary" name="user-save">
                                Сохранить
                            </button>
                            <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                Отменить
                            </button>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection