<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">مراكز التكلفة</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مركز-تكلفة')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_center')); ?>">
                        <span style="font-weight: bolder; font-size:">إضافة مركز تكلفة</span>
                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($centers->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث إسم مركز التكلفة" wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الكود</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">الحساب الرئيسي</th>
                                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مركز-تكلفة')): ?>
                                <th scope="col">تعديل</th>
                                  <?php endif; ?>
                                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مركز-تكلفة')): ?>
                                <th scope="col">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr wire:key="center-<?php echo e($center->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><span class="text-dark"><?php echo e($center->code); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($center->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($center->parent_id ? $center->parent->name : '---'); ?></span> </td>
                      
                                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مركز-تكلفة')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateCenter',{id:<?php echo e($center->id); ?>})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                      
                                    </td>
                                      <?php endif; ?>
                                      <?php endif; ?>
                                       
                                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مركز-تكلفة')): ?>
                                    <td> 
                                    <!--[if BLOCK]><![endif]--><?php if($center->id >= 1 && $center->id < 8): ?> 
                                        <i class="fas fa-lock text-muted"></i>
                                    <?php else: ?> 
                                       
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            
                                            title=<?php echo e(trans('admin.delete_center')); ?>

                                            wire:click="$dispatch('deleteCenter',{id:<?php echo e($center->id); ?>})">
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
                    <?php echo e($centers->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/cost-centers/display-cost-centers.blade.php ENDPATH**/ ?>