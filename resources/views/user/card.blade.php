

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">{{ __('User') }}</div>
                    <div class="text-success text-md-right col-md-6">
                    <em>
                        {{ session('user_update')[0] }}
                    </em>
                    </div></div>
                </div>
                <div class="card-body">
                    {{ Form::open(array('action' => 'UserController@store')) }}
                    {{ Form::hidden('url',Request::url()) }}
                    {{ Form::hidden('id',$user->id) }}
                    <div class="form-group row">
                        {{ Form::label('name',  __('Registartion name'), array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::text('name', $user->name, array('class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '' ),'required', 'autofocus')) }}
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('email',  __('E-Mail Address'), array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::email('email', $user->email, array('class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '' ),'required')) }}
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email')}}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('first_name',  'Имя', array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::text('first_name', $user->first_name, array('class' => 'form-control' . ($errors->has('first_name') ? ' is-invalid' : '' ))) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('patronymic_name', 'Отчество', array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::text('patronymic_name', $user->patronymic_name, array('class' => 'form-control' . ($errors->has('patronymic_name') ? ' is-invalid' : '' ))) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('second_name',  'Фамилия', array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::text('second_name', $user->second_name, array('class' => 'form-control' . ($errors->has('second_name') ? ' is-invalid' : '' ))) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('user_type_id', 'Тип пользователя', array('class' => 'col-md-4 col-form-label text-md-right')) }}
                        <div class="col-md-6">
                            {{ Form::select('user_type_id', App\userType::toSelect(), $user->user_type_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            {{ Form::submit('Сохранить',array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
