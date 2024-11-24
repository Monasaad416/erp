<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.products_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-منتج')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_product')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_product')); ?></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_product_name')); ?>" wire:model.live="searchItem">
                        
                    </div>

                <!--[if BLOCK]><![endif]--><?php if($products->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo e(trans('admin.name')); ?></th>
                                <th>نسبة العمولة</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check( 'تعديل-منتج')): ?>
                                <th><?php echo e(trans('admin.edit')); ?></th>
                                <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check( 'حذف-منتج')): ?>
                                <th><?php echo e(trans('admin.delete')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($product->product->name); ?></td>
                                    <td><?php echo e($product->commission_rate); ?></td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check( 'تعديل-منتج')): ?>
                                    <td>

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateProduct',{product_id:<?php echo e($product->product_id); ?>})">
                                            <i class="far fa-edit"></i>
                                        </button>

                                    </td>
                                    <?php endif; ?>




                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-منتج')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="<?php echo e(trans('admin.delete')); ?>"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteProduct',{id:<?php echo e($product->id); ?>})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                        <?php endif; ?>

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center">لا يوجد منتجات للعرض</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($products->links()); ?>

                </div>
            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/commissions/display-commissions.blade.php ENDPATH**/ ?>