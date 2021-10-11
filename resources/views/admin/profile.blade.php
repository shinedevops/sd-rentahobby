@extends('layouts.admin')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@stop

@section('content')

@php
$user = auth()->user();
@endphp

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card author-box">
                <div class="card-header">
                    <h4>{{ __('user.myaccount') }}</h4>
                </div>
                <div class="card-body">
                    <div class="author-box-center">
                        <img alt="profile-pic" src="{{ asset('../storage/app/' . $user->profile_pic) }}" class="rounded-circle author-box-picture">
                        <div class="clearfix"></div>
                        <div class="author-box-name">
                            <a href="#">{{ $user->name }}</a>
                        </div>
                        <div class="author-box-job">{{ $user->role->name }}</div>
                    </div>
                    <div class="py-4">
                        <p class="clearfix">
                            <span class="float-left">
                                {{ __('user.name') }}
                            </span>
                            <span class="float-right text-muted">
                                {{ $user->name }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                {{ __('user.phone') }}
                            </span>
                            <span class="float-right text-muted">
                                {{ $user->phone_number }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                {{ __('user.email') }}
                            </span>
                            <span class="float-right text-muted">
                                {{ $user->email }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
                
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card">
                <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if (!$errors->has('old_password') && !$errors->has('new_password') && !session('error')) active @endif" id="profile-tab2" data-toggle="tab" href="#settings" role="tab" aria-selected="true">{{__('user.setting') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($errors->has('old_password') || $errors->has('new_password') || session('error')) active @endif" id="home-tab2" data-toggle="tab" href="#changePassword" role="tab" aria-selected="false">{{ __('user.changePassword') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade @if (!$errors->has('old_password') && !$errors->has('new_password') && !session('error')) show active @endif" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                            <form method="post" id="userDetail" action="{{ route('admin.saveuserdetail') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ __('user.editProfile') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.name') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>                                        
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.email') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.phone') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                </div>
                                                <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $user->phone_number }}">
                                                @error('phone_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.uploadProfilePic') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-upload"></i>
                                                    </div>
                                                </div>
                                                <input id="profile_pic" type="file" class="form-control @error('profile_pic') is-invalid @enderror" name="profile_pic">
                                                @error('profile_pic')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button id="userSave" class="btn btn-primary">{{ __('buttons.saveChanges') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade @if ($errors->has('old_password') || $errors->has('new_password') || session('error')) show active @endif" id="changePassword" role="tabpanel" aria-labelledby="home-tab2">
                            <form method="post" id="changePassword" action="{{ route('admin.updatepassword') }}">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ __('user.changePassword') }}</h4>
                                </div>
                                <div class="card-body">
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                                </button>
                                                {{ session()->get('error') }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.oldPassword') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                </div>
                                                <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">

                                                @error('old_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.newPassword') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                </div>
                                                <input type="password" id="newPassword" name="new_password" class="form-control @error('new_password') is-invalid @enderror">

                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12 floating-addon">
                                            <label>{{ __('user.fields.confirmPassword') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                </div>
                                                <input type="password" name="confirm_password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">{{ __('buttons.saveChanges') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('js/jquery-validation.min.js') }}"></script>
<script src="{{ asset('js/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
@if (session('success'))
<script>
jQuery(function () {
    iziToast.success({
        title: '{{ __("user.success") }}',
        message: '{{ session()->get("success") }}',
        position: 'topRight'
    });
});
</script>
@endif

<script>
   
    jQuery(document).ready(function() {
        jQuery('form#userDetail').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                phone_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 12
                },
                profile_pic: {
                    accept:"image/jpeg,image/png",
                    filesize: 2000000
                }
            },
            messages: {
                name: {
                    required: '{{ __("user.validations.nameRequired") }}',
                    maxlength: '{{ __("user.validations.nameMax") }}',
                },
                phone_number: {
                    required: '{{ __("user.validations.phoneRequired") }}',
                    minlength: '{{ __("user.validations.phoneMin") }}',
                    maxlength: '{{ __("user.validations.phoneMax") }}',
                },
                profile_pic: {
                    accept: '{{ __("user.validations.uploadProfilePicExtenstion") }}',
                    filesize: '{{ __("user.validations.uploadProfilePicSize") }}',
                }
            }
        });

        jQuery('form#changePassword').validate({
            rules: {
                old_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    minlength: 8,
                    equalTo : "#newPassword"
                },
            },
            messages: {
                old_password: {
                    required: '{{ __("user.validations.oldPasswordRequired") }}',
                },
                new_password: {
                    required: '{{ __("user.validations.newPasswordRequired") }}',
                    minlength: '{{ __("user.validations.newPasswordMin") }}',
                },
                confirm_password: {
                    required: '{{ __("user.validations.confirmPasswordRequired") }}',
                    minlength: '{{ __("user.validations.confirmPasswordMin") }}',
                    equalTo: '{{ __("user.validations.confirmPasswordMatch") }}',
                },
            }
        });
    })
</script>
@stop