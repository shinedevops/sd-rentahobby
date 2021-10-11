@extends('layouts.admin')

@section('links')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@stop

@section('content')
    <div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.updateproduct', [$product->category_id, $product->id]) }}" method="post" id="editCategoryProduct" enctype="multipart/form-data">
                    <input type="hidden" name="location_count" value="{{ old('location_count', 1) }}">
                        @csrf
                        <div class="card-header">
                            <h4>{{ __('product.title') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name' , $product->name)}}" placeholder="{{ __('product.placeholders.productName') }}">

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
                                            <option value="{{ $category->id }}" @if(old('category') == $category->id || $product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
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
                                    <textarea name="description">{{ old('description', $product->description) }}</textarea>

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

                            @for($i = 0; $i < old('location_count', $product->locations->count()); $i++)
                                <div class="form-row @if($i == 0) main-location @endif">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('product.fields.location') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="location[{{ $i }}]" class="form-control @error('location.*') is-invalid @enderror location-required" placeholder="{{ __('product.placeholders.location') }}" value="{{ $product->locations[$i]->address }}">

                                            @if ($i == 0)
                                                <div class="input-group-prepend cursor-pointer add-more">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-plus-square" title="Add more"></i>
                                                    </div>
                                                </div> 
                                            @else
                                                <div class="input-group-prepend cursor-pointer remove">
                                                    <div class="input-group-text remove-group-text">
                                                        <i class="fas fa-minus-circle" title="Remove"></i>
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

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('product.fields.rent') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="rent" class="form-control @error('rent') is-invalid @enderror" value="{{ old('rent', $product->rent) }}" placeholder="{{ __('product.placeholders.rentPerDay') }}">

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
                                        <input type="text" name="security" class="form-control @error('security') is-invalid @enderror" value="{{ old('security', $product->security) }}" placeholder="{{ __('product.placeholders.productSecurity') }}">

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
                                        <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity )}}" placeholder="{{ __('product.placeholders.productQuantity') }}">

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
                                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" placeholder="{{ __('product.placeholders.productPrice') }}">

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{  __('product.fields.status') }}</label>
                                    <div class="pretty p-default p-curve">
                                        <input type="checkbox" name="status" value="Active" @if($product->status == 'Active') checked @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">{{  __('buttons.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/06agag1yx3npks6ywk9719m46fcigbm4k2wed3dwy99ul721/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
        tinymce.init({
            selector: 'textarea'
        });
        
        jQuery(document).ready(function() {
            jQuery('select').select2({
                placeholder: '{{ __("product.placeholders.selectCategory") }}',
                allowClear: true
            });

            jQuery('form#editCategoryProduct').validate({
                ignore: ':hidden:not(textarea)',
                ignore: [],       
                rules: {
                    name: 'required',
                    category: 'required',
                    description: 'required',
                    location: 'required',
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
                        accept: "image/jpeg,image/jpg,image/png",
                        filesize: 2000000
                    },
                    "gallery_image[]": { 
                        accept: "image/jpeg,image/jpg,image/png",
                        filesize: 2000000
                    }

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
                    location: {
                        required: '{{ __("product.validations.locationRequired") }}',
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
                        accept: '{{ __("product.validations.thumbnailExtenstion") }}',
                        filesize: '{{ __("product.validations.thumbnailSize") }}',
                    },
                    "gallery_image[]": {
                        accept: '{{ __("product.validations.galleryExtenstion") }}',
                        filesize: '{{ __("product.validations.gallerySize") }}',
                    }
                }
            });
        })
    </script>
@stop
