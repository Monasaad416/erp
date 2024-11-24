
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25"><?php echo e(trans('admin.product_codes')); ?></th>
                            <th><?php echo e(trans('admin.print_product_code')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->productCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="w-25"><?php echo e($code->code); ?></td>
                     
      
                            <td>
                          <a target="_blank" href="<?php echo e(route('product.print_code',['id'=>$code->product_id ,'code' => $code->code ])); ?>">
                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="<?php echo e(trans('admin.print_code')); ?>">
                                <i class="fas fa-print"></i>
                            </button>
                          </a>
                            </div>

   
                            </td>
                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

<?php /**PATH D:\laragon\www\pharma\resources\views/inc/products/codes.blade.php ENDPATH**/ ?>