@extends('frontend.'.config('template').'.layouts.app')

@section('title', $product->title)
@section('meta_desc', $product->meta_desc)
@section('meta_key', $product->meta_key)

@section('content')
{{ Breadcrumbs::render('product_full', $product) }}

<div class="row">
    <div class="col-6 product-detail">
        @if ( !empty($product->photo) )
            <img class="img-responsive" src="{{ URL::asset('/uploads/'.$product->photo) }}" alt="{{$product->title}}" />
        @else
            {{ Html::image('https://dummyimage.com/640x480/000/fff.jpg&text=No+image', $product->title, ['class'=>'img-responsive']) }}
        @endif
    </div>
    <div class="col-6">
        <h2>{{ $product->title }}</h2>
        <input type="hidden" name="prod_title" id="prod_title" value="{{ $product->title }}" />
        <small class="text-muted">Category: {{ $product->categories['title'] }}</small>
        <div><br/>Description<br/>{!! $product->fulldesc !!}</div>
        <hr/>

        <?php
            $options = array('twin', 'twin-xl', 'full', 'queen', 'king', 'cal-king', 'split-king');
            $optionsName = array('Twin', 'Twin xl', 'Full', 'Queen', 'King', 'Cal King', 'Split King');
            $price = 0;

            $firmness = array();
            if(!empty($product->firmness))
                $firmness = explode(",", trim($product->firmness));
        ?>

        {{ Form::open(['route' => 'cart.store', "id" => "product_form"]) }}

        <div class="row">
            <div class="col-md-2">
                <b>Options:</b>
            </div>
            <div class="col-md-4">
                <select name="product_price" class="form-control text-center optionField" required>
                    <option value="0">Choose Size</option>
                    <?php 
                        $found = 0; 
                        $size = null;    
                    ?>
                    @foreach($options as $key => $option)
                        @if(!empty($product[$option]))
                           <?php
                                if($price == 0)
                                    $price  = $product[$option];

                                if($found == 0 && !empty($optionsName[$key])){
                                    $size = $optionsName[$key];
                                    $found = 1;
                                }
                            ?>
                            <option data-prodname="{{ $optionsName[$key] }}" value="{{ $product[$option] }}">{{$optionsName[$key]}} - ${{ $product[$option] }}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>
        @if(!empty($firmness))
            <br />
            <div class="row">
                <div class="col-md-2">
                    <b>Firmness:</b>
                </div>
                <div class="col-md-4">
                    <select name="fimness_level" class="form-control text-center" id="fimness_level">
                        <option value="0">Choose Firmness</option>
                        @foreach($firmness as $key => $firm)
                            <option value="{{ $firm }}">{{ $firm }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        
        <br />

        <div class="row">
            <div class="col-md-2">
                <b>Discount:</b>
            </div>
            {{-- <div class="col-md-3">
                <select name="discountType" class="form-control text-center">
                    <option value="1">Percent</option>
                    <option value="2">Flat</option>
                </select>
            </div> --}}
            <input type="hidden" name="discountType" value="2" />
            <div class="col-md-4">
                <input type="text" name="discoutValue" id="discoutValue" class="form-control" />
            </div>
        </div>
        <br />

        <div class="row">
            <div class="col-md-5">
                <h3><b>COST:</b> $<span class="show_price">{{$price}}</span></h3>
            </div>
            <div class="col-md-3">
                {{ Form::text('qty', 1, ['class' => 'form-control text-center',"id" => "prod_qty"]) }}
            </div>
            <div class="col-md-4">
                <a id="addToCart" class="btn btn-primary btn-block blue-btn">Add Product</a>
            </div>
        </div>
        {{ Form::hidden('product_id', $product->id) }}
         <input type="hidden" name="product_size" id="product_size" value="{{ $size }}" class="form-control" />
        @csrf
        {{ Form::close() }}

        <hr/>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="confrimProduct" tabindex="-1" role="dialog" aria-labelledby="confrimProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to want to add this?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body confirmModal"></div>
        <div class="modal-footer">
            <button type="button" id="confirmProduct" class="btn btn-primary">Confirm</button>
        </div>
        </div>
    </div>
</div>
@endsection