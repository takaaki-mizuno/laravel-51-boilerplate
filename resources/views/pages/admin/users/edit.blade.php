@extends('layouts.admin.application', ['menu' => 'users'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});

        $(document).ready(function () {
            $('#profile-image').change(function (event) {
                $('#profile-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Users
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\UserController@index') !!}"><i class="fa fa-files-o"></i> Users</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $user->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="@if($isNew) {!! action('Admin\UserController@store') !!} @else {!! action('Admin\UserController@update', [$user->id]) !!} @endif"
          method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\UserController@index') !!}"
                       class="btn btn-block btn-default btn-sm"
                       style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group text-center">
                            @if( !empty($user->profileImage) )
                                <img id="profile-image-preview" style="max-width: 500px; width: 100%;"
                                     src="{!! $user->profileImage->getThumbnailUrl(480, 300) !!}" alt="" class="margin"/>
                            @else
                                <img id="profile-image-preview" style="max-width: 500px; width: 100%;"
                                     src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                            @endif
                            <input type="file" style="display: none;" id="profile-image" name="profile_image">
                            <p class="help-block" style="font-weight: bolder;">
                                @lang('admin.pages.users.columns.profile_image_id')
                                <label for="profile-image"
                                       style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <table class="edit-user-profile">
                            <tr class="@if ($errors->has('name')) has-error @endif">
                                <td>
                                    <label for="name">@lang('admin.pages.admin-users.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $user->name }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('email')) has-error @endif">
                                <td>
                                    <label for="email">@lang('admin.pages.admin-users.columns.email')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : $user->email }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('password')) has-error @endif">
                                <td>
                                    <label for="password">@lang('admin.pages.users.columns.password')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="password" name="password" @if(!$isNew) disabled @endif value="{{ old('password') ? old('password') : $user->password }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('locale')) has-error @endif">
                                <td>
                                    <label for="locale">@lang('admin.pages.admin-users.columns.locale')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="locale" name="locale" value="{{ old('locale') ? old('locale') : $user->locale }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('api_access_token')) has-error @endif">
                                <td>
                                    <label for="api_access_token">@lang('admin.pages.users.columns.api_access_token')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="api_access_token" name="api_access_token" value="{{ old('api_access_token') ? old('api_access_token') : $user->api_access_token }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('remember_token')) has-error @endif">
                                <td>
                                    <label for="remember_token">@lang('admin.pages.users.columns.remember_token')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="remember_token" name="remember_token" value="{{ old('remember_token') ? old('remember_token') : $user->remember_token }}">
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm"
                        style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
