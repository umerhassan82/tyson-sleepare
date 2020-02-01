<div class="col-xs-3 col-md-4 col-md-4 mb-3 col-sm-6">
    <div class="card product-listing">
        <a class="image-wrapper" href="/{{ $product->id }}-{{ $product->slug }}" title="{{ $product->title }}">

            @if ( !empty($product->photo) )
                <img src="{{ config('app.image_path')}} /uploads/ {{ $product->photo }}" alt="{{$product->title}}" />
            @else
                {{ Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $product->title, ['class'=>'img-responsive', 'style'=>'width:100%;']) }}
            @endif
        </a>
        <div class="card-body">
            <b>
                {!! link_to_route('products.show', $product->title, [$product->id, $product->slug]) !!}
            </b>
        </div>
    </div>
</div>