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

        {{ Form::open(['route' => 'cart.store']) }}

        <div class="row">
            <div class="col-md-2">
                <b>Options:</b>
            </div>
            <div class="col-md-4">
                <select name="product_price" class="form-control text-center optionField">
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
                    <select name="fimness_level" class="form-control text-center">
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
            <div class="col-md-3">
                <select name="discountType" class="form-control text-center">
                    <option value="1">Percent</option>
                    <option value="2">Flat</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="discoutValue" class="form-control" />
            </div>
        </div>
        <br />

        <div class="row">
            <div class="col-md-5">
                <h3><b>COST:</b> $<span class="show_price">{{$price}}</span></h3>
            </div>
            <div class="col-md-3">
                {{ Form::text('qty', 1, ['class' => 'form-control text-center']) }}
            </div>
            <div class="col-md-4">
                {{ Form::submit('Buy', ['class' => 'btn btn-primary btn-block']) }}
            </div>
        </div>
        {{ Form::hidden('product_id', $product->id) }}
         <input type="hidden" name="product_size" id="product_size" value="{{ $size }}" class="form-control" />
        @csrf
        {{ Form::close() }}

        <hr/>
    </div>
</div>
@endsection