<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الأصول الثابتة</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-اصل-ثابت')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة أصل ثابت">
                        <span style="font-weight: bolder; font-size:">إضافة أصل ثابت</span>
                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الأصل " wire:model.live="searchItem">
                </div>
                <!--[if BLOCK]><![endif]--><?php if($assets->count() > 0): ?>


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
                                <th scope="col">رقم الحساب المالي </th>
                                <th scope="col">تاريخ الشراء</th>
                                <th scope="col">سعر الشراء</th>
                                <th scope="col">السعر الحالي</th>
                                <th scope="col">السعر الخردة</th>
                                <th scope="col">العمر  الإفتراضي</th>
                                <th scope="col">الحساب المالي التابع له</th>
                                <th scope="col">الفرع</th>
                                <th>الإهلاكات</th>
                                <th scope="col"><?php echo e(trans('admin.edit')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.delete')); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr wire:key="bank-<?php echo e($asset->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($asset->name); ?></td>
                                    <td><?php echo e($asset->account_num); ?></td>
                                    <td><?php echo e($asset->purchase_date); ?></td>
                                    <td><?php echo e($asset->purchase_price); ?></td>
                                    <td><?php echo e($asset->current_price); ?></td>
                                    <td><?php echo e($asset->scrap_price); ?></td>
                                    <td><?php echo e($asset->life_span); ?></td>
                                    <td><?php echo e($asset->parentAccount->name); ?></td>
                                    <td><?php echo e($asset->branch->name); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="الإهلاكات"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('showDepreciations',{id:<?php echo e($asset->id); ?>})">
                                            <i class="far fa-eye"></i>

                                        </button>
                                    </td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-اصل-ثابت')): ?>
                                    <td>
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateAsset',{id:<?php echo e($asset->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-اصل-ثابت')): ?>
                                    <td>
                                        
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                
                                                title=<?php echo e(trans('admin.delete_bank')); ?>

                                                wire:click="$dispatch('deleteAsset',{id:<?php echo e($asset->id); ?>})">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
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
                    <?php echo e($assets->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/asset/display-assets.blade.php ENDPATH**/ ?>