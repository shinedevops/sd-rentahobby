@extends('layouts.admin')

@section('content')
    <div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <form action="{{ route('admin.updatesetting', [$setting->id]) }}" method="post" id="editSetting">
                        <div class="card-header">
                            <h4>{{ __('setting.editSetting') }}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                <label>{{ __('setting.fields.'.$setting->key) }}</label>
									<select name="value" class="form-control">
                                        @foreach(config('settings.'.$setting->key) as $option => $value)
                                            <option value="{{ $option }}" {{ old('value', $setting->value) == $option ? 'selected' : '' }}> {{ $value }} @if($setting->key != 'pagination') - {{ date($value) }} @endif</option>
                                        @endforeach
                                    </select>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">{{ __('buttons.update') }}</button>
                            <a class="btn btn-dark" href="{{ route('admin.categories') }}">{{ __('buttons.back') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-validation.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#editSetting').validate({
                rules: {
                    value: required
                }
            });
        })
    </script>
@stop
