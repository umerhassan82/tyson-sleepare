<div class="card">
    <div class="card-body">
        <div class="row">
            @if($close)
                <div class="col-md-1">
                    <a class="btn btn-danger btn-sm" href="/cart/{{ urlencode($item['id']) }}">x</a>
                </div>
            @endif
            <div class="col-md-2 cartItems">
                @if(!empty($item['product_id']))
                    <a href="/{{ $item['product_id'] }}-{{ $item['slug'] }}" title="{{ $item['name'] }}">    
                @endif
                    @if ( $item['image'] !== null && !empty($item['image']))
                        <?php
                            $imageURL = 'https://newyork.sleepare.com/uploads/'.$item['image'];
                        ?>
                        <img class="img-responsive" src="{{ $imageURL }}" alt="{{ $item['name'] }}" />
                    @else
                        {{ Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $item['name'], ['class'=>'img-responsive', 'style'=>'width:100%;']) }}
                    @endif
                
                @if(!empty($item['product_id']))
                    </a>
                @endif

                @if(!empty($item['product_id']))
                    <b class="pt-2">{{ link_to_route('products.show', $item['name'], [$item['product_id'], $item['slug']]) }}</b>
                @else
                    <b class="pt-2">{{ $item['name'] }}</b>
                @endif
            </div>
            <div class="col-md-2">
                @if(!empty($item['firmness']))
                     <p class="mb-0">Firmness: <b>{{ $item['firmness'] }}</b></p>
                @endif
                <p class="mb-0">Size: <b>{{ $item['size'] }}</b></p>
                <p class="mb-0">Quantity: <b>{{ $item['qty'] }}</b></p>
                @if(!empty($item['open_mattress']))
                    <b>Open Mattress</b>
                @endif
            </div>
            <div class="col-md-3">
                @if ($item['cat_id'] == 5)
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-{{ $item['hash'] }}">
                        <option data-product="{{ $item['hash'] }}" value="0">Choose Shipping</option>
                        <option data-product="{{ $item['hash'] }}" value="1">Regular shipping immediatly</option>
                        <option data-product="{{ $item['hash'] }}" value="2">White Glove shipping immediately</option>
                        <option data-product="{{ $item['hash'] }}" value="3">Picked up</option>
                        <option data-product="{{ $item['hash'] }}" value="4">Will Pick up</option>
                        <option data-product="{{ $item['hash'] }}" value="6">Free delayed curbside</option>
                        <option data-product="{{ $item['hash'] }}" value="7">Delayed - White Glove</option>
                        <option data-product="{{ $item['hash'] }}" value="8">Drop Off</option>
                    </select>
                    <div id="sub-items-div-{{ $item['hash'] }}" class="mt-3">
                        <div id="sub-option-1-{{ $item['hash'] }}" class="sub-option">
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input data-product="{{ $item['hash'] }}" type="radio" name="option-1-{{ $item['hash'] }}" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input data-product="{{ $item['hash'] }}" type="radio" name="option-1-{{ $item['hash'] }}" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 1  -->

                        <div id="sub-option-2-{{ $item['hash'] }}" class="sub-option">
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-2-{{ $item['hash'] }}" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-2-{{ $item['hash'] }}" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 2  -->

                        <div id="sub-option-3-{{ $item['hash'] }}" class="sub-option">
                            <b>Picked up</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <p>Print Receipt with delivered certificate</p>
                            </div>
                        </div> <!-- Option 3  -->

                        <div id="sub-option-4-{{ $item['hash'] }}" class="sub-option">
                            <b>Product in stock</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-4-{{ $item['hash'] }}" value="yes" class="m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-4-{{ $item['hash'] }}" value="no" class="m-1 ml-3"><span>No</span></label>
                            </div>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-4-2-{{ $item['hash'] }}" id="option-4-2-{{ $item['hash'] }}" />
                            </div>
                        </div> <!-- Option 4  -->

                        <div id="sub-option-6-{{ $item['hash'] }}" class="sub-option">
                            <b>Please enter the first day when you will be ready to receive the product</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-6-{{ $item['hash'] }}" class="form-control">
                            </div>
                        </div> <!-- Option 6  -->

                        <div id="sub-option-7-{{ $item['hash'] }}" class="sub-option">
                            <b>Please choose a date to deliver</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-7-{{ $item['hash'] }}" class="form-control">
                            </div>
                            <br />
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-7-1-{{ $item['hash'] }}" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="{{ $item['hash'] }}" name="option-7-1-{{ $item['hash'] }}" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 7  -->
                    </div>
                @elseif ($item['cat_id'] == 6)
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-{{ $item['hash'] }}">
                        <option data-product="{{ $item['hash'] }}" value="0">Choose Shipping</option>
                        <option data-product="{{ $item['hash'] }}" value="9">Free curbside delivery</option>
                        <option data-product="{{ $item['hash'] }}" value="10">WG W/ASSEMBLY - no removal</option>
                        <option data-product="{{ $item['hash'] }}" value="11">Drop off</option>
                        <option data-product="{{ $item['hash'] }}" value="12">Picked up</option>
                        <option data-product="{{ $item['hash'] }}" value="13">Will Pick up</option>
                    </select>
                    <div id="sub-items-div-{{ $item['hash'] }}" class="mt-3">
                        <div id="sub-option-10-{{ $item['hash'] }}" class="sub-option">
                            <b>No Removal</b>
                        </div> <!-- Option 9  -->
                        <div id="sub-option-13-{{ $item['hash'] }}" class="sub-option">
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-13-{{ $item['hash'] }}" id="option-13-{{ $item['hash'] }}" />
                            </div>
                        </div>
                    </div>
                @else 
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-{{ $item['hash'] }}">
                        <option data-product="{{ $item['hash'] }}" value="0">Choose Shipping</option>
                        <option data-product="{{ $item['hash'] }}" value="14">Regular shipping</option>
                        <option data-product="{{ $item['hash'] }}" value="15">Picked up</option>
                        <option data-product="{{ $item['hash'] }}" value="16">Will Pick up</option>
                    </select>
                    <div id="sub-items-div-{{ $item['hash'] }}" class="mt-3">
                        <div id="sub-option-16-{{ $item['hash'] }}" class="sub-option">
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-16-{{ $item['hash'] }}" id="option-16-{{ $item['hash'] }}" />
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-2">
                <input {{ auth::check() ? '' : 'readonly' }} class="form-control item-shipping-cost" type="number" name="itemShippingCost[]" id="shippingCost-{{ $item['hash'] }}" value="0.0">
            </div>
            <div class="col-md-2 text-center">
                <?php
                    if(isset($item["dis_value"]) && !empty($item["dis_value"])){
                        echo('<del>$'.$item['full_price'] * config('rate').'</del><br />');
                    }
                ?>
                ${{ number_format($item['cost'] * config('rate'), 2) }}
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>