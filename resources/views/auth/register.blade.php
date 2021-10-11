@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" id="register" action="{{ route('register') }}" @if(Route::current()->getName() === 'retailer.register') enctype="multipart/form-data" @endif>
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="passwordConfirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        @if(Route::current()->getName() === 'retailer.register')   
                            <div class="form-group row">
                                <label for="retailer-type" class="col-md-4 col-form-label text-md-right">{{ __('Retailer Type') }}</label>

                                <div class="col-md-6">
                                    <select name="type" class="form-control @error('type') is-invalid @enderror" id="retailerType">
                                        <option value="">Select type</option>
                                        <option value="individual">Individiual</option>
                                        <option value="retailer">Retailer</option>
                                    </select>
                                    
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="proof" class="col-md-4 col-form-label text-md-right">{{ __('Govt. Id proof') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control @error('proof') is-invalid @enderror" name="proof">

                                    @error('proof')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('form#register').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo : "#passwordConfirm"
                    },
                    type: {
                        required: true,
                    },
                    proof: {
                        required: true,
                        accept: "image/jpeg,image/png",
                        filesize: 2000000
                    },
                },
                messages: {
                    name: {
                        required: '{{ __("user.validations.nameRequired") }}',
                        maxlength: '{{ __("user.validations.nameMax") }}',
                    },
                    email: {
                        required: '{{ __("user.validations.emailRequired") }}',
                        email: '{{ __("user.validations.emailType") }}',
                        maxlength: '{{ __("user.validations.emailMax") }}',
                    },
                    password: {
                        required: '{{ __("user.validations.passwordRequired") }}',
                        minlength: '{{ __("user.validations.passwordMin") }}',
                    },
                    password_confirmation: {
                        required: '{{ __("user.validations.confirmPasswordRequired") }}',
                        minlength: '{{ __("user.validations.confirmPasswordMin") }}',
                        equalTo: '{{ __("user.validations.confirmPasswordMatch") }}',
                    },
                    type: {
                        required: '{{ __("user.validations.typeRequired") }}',
                    },
                    proof: {
                        required: '{{ __("user.validations.proofRequired") }}',
                        accept: '{{ __("user.validations.proofExtenstion") }}',
                        filesize: '{{ __("user.validations.proofSize") }}',
                    }
                }
            });
        })
    </script>
@stop
