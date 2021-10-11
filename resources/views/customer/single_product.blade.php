@extends('layouts.app')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product Test') }}</div>
                <div class="card-body">
                    @if (auth()->user())
                        <label data-pid="{{ $product->id }}" data-uid="{{ auth()->user()->id }}" class="add-favorite">Add as favorite</label>
                    @endif
                    <img src="{{ asset('../storage/app/' . $thumbnailImage) }}" alt="thumbnail-image">
                    <label for="product-name">{{ $product->name }} <span> - {{ $product->category->name }}</span></label>
                    <span class="avg-rating">Rating: {{ $averageRating }}</span>
                    <span>Sold By: <strong><a href="{{ route('vendor', [$product->user_id]) }}">{{ $product->retailer->name }}</a></strong></span>
                    <p for="rent">{{ $product->rent }}/day</p>
                    <div class="product-description">{{ $product->description }}</div>
                    <div class="product-locations">{{ $product->locations->pluck('address')->implode(', ') }}</div>

                    @foreach($galleries as $gallery)
                        <img src="{{ asset('../storage/app/' . $gallery->file) }}" alt="image">
                    @endforeach

                    @if($product->nonAvailableDates->isNotEmpty())
                        <div class="non-available-dates">
                            <label for="">Non available dates</label>
                            @foreach($product->nonAvailableDates as $singleDate)
                                {{ $singleDate->date }}
                                {{-- date(session()->get('dateformat'), strtotime($singleDate->date)) --}}

                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <a href="{{ route('book', [$product->id]) }}"><button>Book Now</button></a>
                </div>

                <!-- Rating list -->
                @if($product->ratings->isNotEmpty())
                    <div class="non-available-dates">
                        <label for="">Ratings</label>
                        @foreach($product->ratings as $rating)
                            <div class="each-rating">
                                <img src="{{ asset('../storage/app/' . $rating->user->profile_pic) }}" alt="user-image"> 
                                <label for="rating">{{ $rating->rating }}</label>
                                <label for="review">{{ $rating->review }}</label>
                           </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script>
    const userId = @if(auth()->user()) {!! json_encode(auth()->user()->id) !!} @else '' @endif;
    const productId = {!! json_encode($product->id) !!};
    const url = "{{ route('addfavorite') }}";

    jQuery(document).ready(function() {
        jQuery('.add-favorite').click(function() {
            if (jQuery.isNumeric(userId) && jQuery.isNumeric(productId) && userId > 0 && productId > 0) {
                jQuery.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        userid: userId,
                        productid: productId,
                    },
                    success: function(response) {
                        console.log(response);
                        iziToast.success({
                            title: response.title,
                            message: response.message,
                            position: 'topRight'
                        });
                    },
                    error: function(errors) {
                        let result = errors.responseJSON;
                        let message = result.message
                        // for (var prop in result.errors) {
                        //     message += result.errors[prop];
                        // }
                        
                        iziToast.error({
                            title: '{{ __("favorite.error") }}',
                            message: message,
                            position: 'topRight'
                        });
                    }
                })
            }
        })
    })
</script>

@endsection
