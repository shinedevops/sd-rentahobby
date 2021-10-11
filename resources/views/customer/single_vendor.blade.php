@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Vendor Details') }}</div>
                <div class="card-body">
                    <img src="{{ asset('../storage/app/' . $vendor->profile_pic) }}" alt="profile-pic">
                    <label for="product-name">{{ $vendor->name }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
