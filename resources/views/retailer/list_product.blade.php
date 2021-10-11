@extends('layouts.retailer')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@stop

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <x-alert/>
                        <div class="card-header">
                            <h4>{{ __('product.title') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('product.name') }}</th>
                                        <th>{{ __('common.status') }}</th>
                                        <th>{{ __('common.createdAt') }}</th>
                                        <th>{{ __('common.action') }}</th>
                                    </tr>
                                    @foreach($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><a href="{{ route('retailer.editproduct', [$product->id]) }}">{{ $product->name }}</a></td>
                                            <td>
                                                @if($product->status == 'Active')
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $product->created_at ? date('d F Y', strtotime($product->created_at)): 'N/A' }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('viewproduct', [$product->id]) }}" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a class="btn btn-success" href="{{ route('retailer.editproduct', [$product->id]) }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a> 
                                                <a class="btn btn-danger" href="{{ route('retailer.deleteproduct', [$product->id]) }}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($products->count() == 0)
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">{{ __('product.empty') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function() {
        jQuery('.toast').toast("show")
    })
</script>
@stop
