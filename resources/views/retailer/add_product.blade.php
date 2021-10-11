@extends('layouts.retailer')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.css')}} ">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@stop

@section('content')

    @php
        echo '<pre>'; print_r($errors);echo '</pre>';
    @endphp
    <div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{route('retailer.saveproduct')}}" method="post" id="addProduct" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="location_count" value="{{ old('location_count', 1) }}">
                        <input type="hidden" name="non_available_date_count" value="{{ old('non_available_date_count', 1) }}">
                        <div class="card-header">
                            <h4>{{ __('product.addProduct') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('product.placeholders.productName') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.category') }}</label>
                                    <select name="category" class="form-control form-control-sm @error('category') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.description') }}</label>
                                    <textarea name="description">{{ old('description') }}</textarea>

                                    @error('description')
                                        <span class="editor-error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.image') }}</label>
                                    <input type="file" name="thumbnail_image" class="form-control @error('thumbnail_image') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg">

                                    @error('thumbnail_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.gallery') }} <small>Press ctrl button to upload multiple files</small></label>
                                    <input type="file" name="gallery_image[]" class="form-control @error('gallery_image.*') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg" multiple>
                                    
                                    @error('gallery_image.*')
                                        @foreach($errors->get('gallery_image.*') as $gallerImageErrors)
                                            @foreach($gallerImageErrors as $message)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @endforeach
                                        @endforeach
                                    @enderror                
                                </div>
                            </div>
                            
                            @for($i = 0; $i < old('location_count', 1); $i++)
                                <div class="form-row @if($i == 0) main-location @endif">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('product.fields.location') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="location[{{ $i }}]" class="form-control @error('location.*') is-invalid @enderror location-required" value="{{ old('location.'.$i) }}" placeholder="{{ __('product.placeholders.location') }}">

                                            @if ($i == 0)
                                                <div class="input-group-prepend cursor-pointer add-more">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-plus-square" title="{{ __('product.addMore') }}"></i>
                                                    </div>
                                                </div> 
                                            @else
                                                <div class="input-group-prepend cursor-pointer remove">
                                                    <div class="input-group-text remove-group-text">
                                                        <i class="fas fa-minus-circle" title="{{ __('product.remove') }}"></i>
                                                    </div>
                                                </div>
                                            @endif
                                      
                                            @error('location.'.$i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                        
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="form-row clone-location-container hidden">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.location') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('product.placeholders.location') }}">

                                        <div class="input-group-prepend cursor-pointer remove">
                                            <div class="input-group-text remove-group-text">
                                                <i class="fas fa-minus-circle" title="{{ __('product.remove') }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.rent') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="rent" class="form-control @error('rent') is-invalid @enderror" value="{{ old('rent') }}" placeholder="{{ __('product.placeholders.rentPerDay') }}">

                                        @error('rent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.security') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="security" class="form-control @error('security') is-invalid @enderror" value="{{ old('security') }}" placeholder="{{ __('product.placeholders.productSecurity') }}">

                                        @error('security')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.quantity') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="{{ __('product.placeholders.productQuantity') }}">

                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.price') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="{{ __('product.placeholders.productPrice') }}">

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @for($i = 0; $i < old('non_available_count', 1); $i++)
                                <div class="form-row @if($i == 0) main-non-available-date @endif">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('product.fields.nonAvailabilityDate') }} <small>{{ __('product.fields.ifAny') }}</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="non_availabile_dates[{{ $i }}]" class="form-control non-availability @error('non_availabile_dates.*') is-invalid @enderror" placeholder="{{ __('product.placeholders.nonAvailableDates') }}" autocomplete="off">

                                            @if ($i == 0)
                                                <div class="input-group-prepend cursor-pointer add-more-daterangepicker">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-plus-square" title="{{ __('product.addMore') }}"></i>
                                                    </div>
                                                </div> 
                                            @else
                                                <div class="input-group-prepend cursor-pointer remove-daterangepicker">
                                                    <div class="input-group-text remove-group-text">
                                                        <i class="fas fa-minus-circle" title="{{ __('product.remove') }}"></i>
                                                    </div>
                                                </div>
                                            @endif
                                      
                                            @error('non_availabile_dates.'.$i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                        
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="form-row clone-non-available-date-container hidden">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.nonAvailabilityDate') }} <small>{{ __('product.fields.ifAny') }}</small></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ __('product.placeholders.nonAvailableDates') }}">

                                        <div class="input-group-prepend cursor-pointer remove-daterangepicker">
                                            <div class="input-group-text remove-group-text">
                                                <i class="fas fa-minus-circle" title="{{ __('product.remove') }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{  __('product.fields.status') }}</label>
                                    <div class="pretty p-default p-curve">
                                        <input type="checkbox" name="status" value="{{ old('status') == 'Inactive' ? 'Inactive' : 'Active' }}" @if(old('status', 'Active') == 'Active') checked @endif>
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
    <script src="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/06agag1yx3npks6ywk9719m46fcigbm4k2wed3dwy99ul721/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
        tinymce.init({
            selector: 'textarea'
        });

        const options = {
            locale: { 
                format: dateFormat 
            },
            autoUpdateInput: false,
            drops: 'down',
            opens: 'right',
            // minDate: new Date(),
        };
        initDateRangePicker('.non-availability', options);

        jQuery.validator.addMethod("locationRequired", jQuery.validator.methods.required,
        '{{ __("product.validations.locationRequired") }}');
        jQuery.validator.addClassRules("location-required", { locationRequired: true });
        
        jQuery(document).ready(function() {
            jQuery('.add-more-daterangepicker').click(function(e) {
                // console.log(jQuery(this).parent().find('input').attr('class'), jQuery(this).parent().parent());
                let nonAvailableDateCounterElem = jQuery('input[name="non_available_date_count"]');
                let nonAvailableDateCounterVal = parseInt(nonAvailableDateCounterElem.val()) + 1;
                nonAvailableDateCounterElem.val(nonAvailableDateCounterVal)
                let cloneDiv = jQuery('.clone-non-available-date-container').clone();
                cloneDiv.removeClass('clone-non-available-date-container hidden')
                cloneDiv.find('input').addClass('non-availability')
                let dateRangeElement = cloneDiv.find('input');
                jQuery(cloneDiv).insertAfter('.main-non-available-date')
                jQuery(document).find('.non-availability').each(function (index) {
                    jQuery(this).attr('name', 'non_availabile_dates['+index+']')
                });

                initDateRangePicker(dateRangeElement, options);
            })

            jQuery(document).on('click', '.remove-daterangepicker', function() {
                let nonAvailableDateCounterElem = jQuery('input[name="non_available_date_count"]');
                let nonAvailableDateCounterVal = parseInt(nonAvailableDateCounterElem.val()) - 1;
                nonAvailableDateCounterElem.val(nonAvailableDateCounterVal)
                jQuery(this).parents('.form-row').remove();
                jQuery(document).find('.non-availability').each(function (index) {
                    jQuery(this).attr('name', 'non_availabile_dates['+index+']')
                });
            })
            
            
            jQuery('select').select2({
                placeholder: '{{ __("product.placeholders.selectCategory") }}',
                allowClear: true
            });

            jQuery('.add-more').click(function(e) {
                let locationCounterElem = jQuery('input[name="location_count"]');
                let locationCounterVal = parseInt(locationCounterElem.val()) + 1;
                locationCounterElem.val(locationCounterVal)
                let cloneDiv = jQuery('.clone-location-container').clone();
                cloneDiv.removeClass('clone-location-container hidden')
                cloneDiv.find('input').addClass('location-required')
                jQuery(cloneDiv).insertAfter('.main-location')
                jQuery(document).find('.location-required').each(function (index) {
                    jQuery(this).attr('name', 'location['+index+']')
                });
            })

            jQuery(document).on('click', '.remove', function() {
                let locationCounterElem = jQuery('input[name="location_count"]');
                let locationCounterVal = parseInt(locationCounterElem.val()) - 1;
                locationCounterElem.val(locationCounterVal)
                jQuery(this).parents('.form-row').remove();
                jQuery(document).find('.location-required').each(function (index) {
                    jQuery(this).attr('name', 'location['+index+']')
                });
            })

            jQuery('form#addProducts').validate({
                ignore: ':hidden:not(textarea)',
                ignore: [],       
                rules: {
                    name: 'required',
                    category: 'required',
                    description: 'required',
                    rent: {
                        required: true,
                        numeric: /^[+-]?\d+(\.\d+)?$/
                    },
                    security: {
                        required: true,
                        numeric: /^[+-]?\d+(\.\d+)?$/
                    },
                    quantity: {
                        required: true,
                        digits: true
                    },
                    price: {
                        required: true,
                        numeric: /^[+-]?\d+(\.\d+)?$/
                    },
                    thumbnail_image: {
                        required: true,
                        accept: "image/jpeg,image/jpg,image/png",
                        filesize: 2000000
                    },
                    "gallery_image[]": { 
                        accept: "image/jpeg,image/jpg,image/png",
                        filesize: 2000000
                    },
                },
                messages: {
                    name: {
                        required: '{{ __("product.validations.productNameRequired") }}'
                    },
                    category: {
                        required: '{{ __("product.validations.productCategory") }}',
                    },
                    description: {
                        required: '{{ __("product.validations.productDescription") }}',
                    },
                    rent: {
                        required: '{{ __("product.validations.rentRequired") }}',
                        numeric: '{{ __("product.validations.rentRegex") }}',
                    },
                    security: {
                        required: '{{ __("product.validations.securityRequired") }}',
                        numeric: '{{ __("product.validations.securityRegex") }}',
                    },
                    quantity: {
                        required: '{{ __("product.validations.quantityRequired") }}',
                        digits: '{{ __("product.validations.quantityRegex") }}',
                    },
                    price: {
                        required: '{{ __("product.validations.priceRequired") }}',
                        numeric: '{{ __("product.validations.priceRegex") }}',
                    },
                    thumbnail_image: {
                        required: '{{ __("product.validations.thumbnailRequired") }}',
                        accept: '{{ __("product.validations.thumbnailExtenstion") }}',
                        filesize: '{{ __("product.validations.thumbnailSize") }}',
                    },
                    "gallery_image[]": {
                        accept: '{{ __("product.validations.galleryExtenstion") }}',
                        filesize: '{{ __("product.validations.gallerySize") }}',
                    },
                }
            });
        })
    </script>
@stop
