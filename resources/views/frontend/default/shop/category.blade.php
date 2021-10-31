@extends('frontend.'.config('template').'.layouts.app')

@section('title', $categories->title)
@section('meta_desc', $categories->meta_desc)
@section('meta_key', $categories->meta_key)

@section('content')
    {!! Breadcrumbs::render('categories', $categories->title, $categories->slug) !!}

    @if( $category_menu )
    <div class="row">
        <div class="col-md-3">
            <button type="button" data-toggle="modal" data-target="#customProducts" class="btn btn-primary  mb-3">Add Custom Products</button>
            <div class="list-group">
                {!! $category_menu !!}
            </div>
        </div>
        <div class="col-md-9">
            <h3>{{ $categories->title }}</h3>
            <div class="row">
                @foreach ($products as $product)
                    @include('frontend.'.config('template').'.partials.short_products')
                @endforeach
            </div>
        </div>
    </div>
    @else
        <h3>{{ $categories->title }}</h3>
        <div class="row">
        @foreach ($products as $product)
            @include('frontend.'.config('template').'.partials.short_products')
        @endforeach
        </div>
    @endif

    <div class="text-center">
        {{ $products->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="customProducts" tabindex="-1" role="dialog" aria-labelledby="customProducts" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add details for custom product?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body confirmModal">
                    <form action="/custom/add" id="customProductForm">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Product Name:</label>
                                <input type="text" name="custom_name" id="custom_name" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Price:</label>
                                <input type="number" name="custom_price" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Quantity:</label>
                                <select class="form-control" name="custom_qty" id="custom_qty">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addCustom" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </div>
    </div>

@endsection