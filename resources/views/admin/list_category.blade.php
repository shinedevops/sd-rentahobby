@extends('layouts.admin')

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <x-alert/>
                        <div class="card-header">
                            <h4>{{ __('category.title') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('category.name') }}</th>
                                        <th>{{ __('category.noOfProducts') }}</th>
                                        <th>{{ __('common.status') }}</th>
                                        <th>{{ __('common.createdAt') }}</th>
                                        <th>{{ __('common.action') }}</th>
                                    </tr>
                                    @foreach($categories as $index => $category)
                                        <tr>
                                            <td>{{ $index + 1 }}</th>
                                            <td><a href="{{ route('admin.editcategory', [$category->id]) }}">{{ $category->name }}</a></td>
                                            <td><a href="{{ route('admin.categoryproduct', [$category->id]) }}">{{ $category->products_count }}</a></td>
                                            <td>
                                                @if($category->status == 'Active')
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at ? date('d F Y', strtotime($category->created_at)): 'N/A' }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('admin.viewcategory', [$category->id]) }}" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-success" href="{{ route('admin.editcategory', [$category->id]) }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a> 
                                                <a class="btn btn-danger" href="{{ route('admin.deletecategory', [$category->id]) }}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a class="btn btn-primary" href="{{ route('admin.categoryproduct', [$category->id]) }}" title="Products">
                                                    <i class="fab fa-product-hunt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($categories->count() == 0)
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">{{ __('category.empty') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
