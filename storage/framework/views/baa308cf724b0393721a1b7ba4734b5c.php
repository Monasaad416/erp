<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة المخازن</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مخزن')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة مخزن">
                        <span style="font-weight: bolder; font-size:">إضافة مخزن</span>
                    </button>
                    <?php endif; ?>

                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم المخزن " wire:model.live="searchItem">
                </div>
                <!--[if BLOCK]><![endif]--><?php if($stores->count() > 0): ?>


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?php echo e(trans('admin.name')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.branch')); ?></th>
                                <th scope="col">نوع المخزن</th>
                                <th scope="col">اخر ايصال دفع</th>
                                <th scope="col">اخر ايصال تحصيل</th>
                                <th scope="col"><?php echo e(trans('admin.status')); ?></th>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مخزن')): ?>
                                <th scope="col"><?php echo e(trans('admin.edit')); ?></th>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مخزن')): ?>
                                <th scope="col"><?php echo e(trans('admin.delete')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr wire:key="store-<?php echo e($store->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($store->name); ?></span> </td>
                                    <td><?php echo e($store->branch->name); ?></span> </td>
                                    <td class="text-<?php echo e($store->is_parent == 1 ? 'success': 'primary'); ?>"><?php echo e($store->is_parent == 1 ? 'رئيسي': 'فرعي'); ?></td>
                                    <td><?php echo e($store->last_exchange_reciept ? $store->last_exchange_reciept : '---'); ?></span> </td>
                                    <td><?php echo e($store->last_collection_reciept ? $store->last_collection_reciept : '---'); ?></span> </td>
                                        
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تغيير-حالة-مخزن')): ?>
                                    <td>
                                        <button type="button" class="btn btn-<?php echo e($store->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($store->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('togglestore',{id:<?php echo e($store->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($store->is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مخزن')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateStore',{id:<?php echo e($store->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مخزن')): ?>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($store->id >= 1 && $store->id < 8): ?>
                                            <i class="fas fa-lock text-muted"></i>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                
                                                title=<?php echo e(trans('admin.delete_store')); ?>

                                                wire:click="$dispatch('deleteStore',{id:<?php echo e($store->id); ?>})">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                     <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($stores->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores/display-stores.blade.php ENDPATH**/ ?>