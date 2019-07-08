<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-1">
                <?php echo e(Form::open(['method'  => 'delete', 'route' => ['cart.destroy', $item['id']]]), false); ?>

                    <?php echo e(Form::button('x', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']), false); ?>

                    <?php echo csrf_field(); ?>
                <?php echo e(Form::close(), false); ?>

            </div>
            <div class="col-md-1 cartItems">
                <a href="/<?php echo e($item['id'], false); ?>-<?php echo e($item['slug'], false); ?>" title="<?php echo e($item['name'], false); ?>">
                    <?php if( $item['image'] !== null ): ?>
                        <?php
                            $imageURL = URL::asset('uploads/'.$item['image']);
                        ?>
                        <img class="img-responsive" src="<?php echo e($imageURL, false); ?>" alt="<?php echo e($item['name'], false); ?>" />
                    <?php else: ?>
                        <?php echo e(Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $item['name'], ['class'=>'img-responsive', 'style'=>'width:100%;']), false); ?>

                    <?php endif; ?>
                </a>
            </div>
            <div class="col-md-3">
                <b><?php echo e(link_to_route('products.show', $item['name'], [$item['product_id'], $item['slug']]), false); ?></b>
            </div>
            <div class="col-md-2">
                <?php if(!empty($item['firmness'])): ?>
                     <b><?php echo e($item['firmness'], false); ?></b>
                 <?php endif; ?>
            </div>
            <div class="col-md-1">
                <b><?php echo e($item['size'], false); ?></b>
            </div>
            <div class="col-md-2">
                <?php echo e($item['qty'], false); ?>

            </div>
            <div class="col-md-2 text-center">
                <?php
                    if(isset($item["dis_value"]) && !empty($item["dis_value"])){
                        echo('<del>$'.$item['full_price'] * config('rate').'</del><br />');
                    }
                ?>
                $<?php echo e($item['cost']*config('rate'), false); ?>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>