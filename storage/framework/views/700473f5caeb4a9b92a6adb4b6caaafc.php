<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.products_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-منتج')): ?>
                    <div>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_product')); ?>">
                            <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_product')); ?></span>
                        </button>
                        <button type="button" class="btn bg-gradient-warning mx-2" data-toggle="modal" wire:click="$dispatch('importProducts')">
                                استيراد من  EXCEL
                        </button>
                    </div>
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
                                <th><?php echo e(trans('admin.status')); ?></th>
                                <th><?php echo e(trans('admin.sale_price')); ?></th>
                                <th>الضريبة</th>
                                
                                <th><?php echo e(trans('admin.inventory_balance')); ?></th>
                                <th>تنبية الرصيد بالمخزن الرئيسي</th>
                                <th>تنبيه الرصيد بمخزن الفرع</th>
                                <th><?php echo e(trans('admin.show')); ?></th>
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
                                    <td><?php echo e($product->name); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-<?php echo e($product->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($product->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>"
                                            data-toggle="modal"
                                            wire:click="$dispatch('toggleProduct',{id:<?php echo e($product->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($product-> is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <td><?php echo e($product->sale_price); ?></td>
                                    <td class="text-<?php echo e($product->taxes == 1 ? 'success' :'danger'); ?>"> <?php echo e($product->taxes == 1 ? 'خاضع للضريبة' :'غير خاضع للضريبة'); ?> </td>
                                    <td><?php echo e(App\Models\Inventory::where('product_id',$product->id)->where('branch_id',1)->latest()->first()->inventory_balance); ?></td>

                                     <td><?php echo e($product->alert_main_branch); ?></td>

                                     <td >
                                        <?php echo e($product->alert_branch); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('product.show',['id'=> $product->id])); ?>">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check( 'تعديل-منتج')): ?>
                                    <td>

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateProduct',{id:<?php echo e($product->id); ?>})">
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





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/products/display-products.blade.php ENDPATH**/ ?>