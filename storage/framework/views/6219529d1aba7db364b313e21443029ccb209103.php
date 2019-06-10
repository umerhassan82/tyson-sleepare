<div class="form-group <?php echo !$errors->has($label) ?: 'has-error'; ?>">

    <label for="<?php echo e($id, false); ?>" class="col-sm-2 control-label"><?php echo e($label, false); ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div id="<?php echo e($id, false); ?>" style="width: 100%; height: 100%;">
            <p><?php echo old($column, $value); ?></p>
        </div>

      <input type="hidden" name="<?php echo e($name, false); ?>" value="<?php echo e(old($column, $value), false); ?>" />
      <?php echo csrf_field(); ?>

    </div>
</div>