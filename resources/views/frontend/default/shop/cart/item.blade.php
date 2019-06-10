
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-1">
                {{ Form::open(['method'  => 'delete', 'route' => ['cart.destroy', $item['id']]]) }}
                    {{ Form::button('x', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
                    @csrf
                {{ Form::close() }}
            </div>
            <div class="col-md-1 cartItems">
                <a href="/{{ $item['id'] }}-{{ $item['slug'] }}" title="{{ $item['name'] }}">
                    @if ( $item['image'] !== null )
                        <?php
                            $imageURL = URL::asset('uploads/'.$item['image']);
                        ?>
                        <img class="img-responsive" src="{{ $imageURL }}" alt="{{ $item['name'] }}" />
                    @else
                        {{ Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $item['name'], ['class'=>'img-responsive', 'style'=>'width:100%;']) }}
                    @endif
                </a>
            </div>
            <div class="col-md-3">
                <b>{{ link_to_route('products.show', $item['name'], [$item['id'], $item['slug']]) }}</b>
            </div>
            <div class="col-md-2">
                @if(!empty($item['firmness']))
                     <b>{{ $item['firmness'] }}</b>
                 @endif
            </div>
            <div class="col-md-1">
                <b>{{ $item['size'] }}</b>
            </div>
            <div class="col-md-2">
                {{ $item['qty'] }}
            </div>
            <div class="col-md-2 text-center">
                <?php
                    if(isset($item["dis_value"]) && !empty($item["dis_value"])){
                        echo('<del>$'.$item['full_price'] * config('rate').'</del><br />');
                    }
                ?>
                ${{ $item['cost']*config('rate') }}
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>