<?php $__env->startSection('title', $categories->title); ?>
<?php $__env->startSection('meta_desc', $categories->meta_desc); ?>
<?php $__env->startSection('meta_key', $categories->meta_key); ?>

<?php $__env->startSection('content'); ?>
    <?php echo Breadcrumbs::render('categories', $categories->title, $categories->slug); ?>


    <?php if( $category_menu ): ?>
    <div class="row">
        <div class="col-md-3">
            <button type="button" data-toggle="modal" data-target="#customProducts" class="btn btn-primary  mb-3">Add Custom Products</button>
            <div class="list-group">
                <?php echo $category_menu; ?>

            </div>
        </div>
        <div class="col-md-9">
            <h3><?php echo e($categories->title, false); ?></h3>
            <div class="row">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('frontend.'.config('template').'.partials.short_products', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h3><?php echo e($categories->title, false); ?></h3>
        <div class="row">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('frontend.'.config('template').'.partials.short_products', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="text-center">
        <?php echo e($products->links(), false); ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>