@extends('layouts.admin')

@section('content')
    <div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{route('admin.savecategory')}}" method="post" id="addCategory">
                        <div class="card-header">
                            <h4>{{ __('category.addCategory') }}</h4>
                        </div>
                        @csrf
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>{{ __('category.fields.name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="{{ __('category.placeholders.name') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>{{  __('category.fields.status') }}</label>
                                    <div class="pretty p-default p-curve">
                                        <input type="checkbox" name="status" value="{{ old('status') == 'Inactive' checked ? 'Inactive' : 'Active' checked}}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">{{  __('buttons.save') }}</button>
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
            jQuery('form#addCategory').validate({
                rules: {
                    name: 'required',
                },
                messages: {
                    name: {
                        required: '{{ __("category.validations.name") }}'
                    }
                }
            });
        })
    </script>
@stop
