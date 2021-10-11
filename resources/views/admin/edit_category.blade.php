@extends('layouts.admin')

@section('content')
    <div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <form action="{{ route('admin.updatecategory', [$category->id]) }}" method="post" id="editCategory">
                        <div class="card-header">
                            <h4>{{ __('category.editCategory') }}</h4>
                        </div>
                        @csrf
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>{{ __('category.fields.name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}" placeholder="{{ __('category.placeholders.name') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>{{ __('category.fields.status') }}</label>
                                    <div class="input-group">
                                        <input type="checkbox" name="status" value="Active" @if($category->status == 'Active') checked @endif>
                                    </div>

                                    @if ($errors->has('status'))
                                        <label class="error">{{ $errors->first('status') }}</label>
                                    @endif
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
            jQuery('form#editCategory').validate({
                rules: {
                    name: required
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
