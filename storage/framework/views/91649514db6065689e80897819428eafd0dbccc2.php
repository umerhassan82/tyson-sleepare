<div class="col-xs-3 col-md-4 col-md-4 mb-3 col-sm-6">
    <div class="card product-listing">
        <a class="image-wrapper" href="/<?php echo e($product->id, false); ?>-<?php echo e($product->slug, false); ?>" title="<?php echo e($product->title, false); ?>">

            <?php if( !empty($product->photo) ): ?>
                <img src="<?php echo e(URL::asset('/uploads/'.$product->photo), false); ?>" alt="<?php echo e($product->title, false); ?>" />
            <?php else: ?>
                <?php echo e(Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $product->title, ['class'=>'img-responsive', 'style'=>'width:100%;']), false); ?>

            <?php endif; ?>
        </a>
        <div class="card-body">
            <b>
                <?php echo link_to_route('products.show', $product->title, [$product->id, $product->slug]); ?>

            </b>
        </div>
    </div>
</div>