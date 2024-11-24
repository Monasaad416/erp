<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الشركاء</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-شريك')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_partner')); ?>">
                        <span style="font-weight: bolder; font-size:">إضافة شريك</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الشريك" wire:model.live="searchItem">
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($partners->count() > 0): ?>
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
                            <th><?php echo e(trans('admin.address')); ?></th>
                            <th><?php echo e(trans('admin.email')); ?></th>
                            <th><?php echo e(trans('admin.phone')); ?></th>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-شريك')): ?>
                            <th><?php echo e(trans('admin.edit')); ?></th>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-شريك')): ?>
                            <th><?php echo e(trans('admin.delete')); ?></th>
                            <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($partner->name); ?></td>
                                    
                                    <td ><?php echo e($partner->address ? $partner->address : "---"); ?></td>
                                     <td ><?php echo e($partner->email ? $partner->email : "---"); ?></td>
                                    <td ><?php echo e($partner->phone ? $partner->phone : "---"); ?></td>
                                     
                                    

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-شريك')): ?>
                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updatePartner',{id:<?php echo e($partner->id); ?>})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-شريك')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deletePartner',{id:<?php echo e($partner->id); ?>})">
                                            <i class="fas fa-trash"></i>
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
                    <?php echo e($partners->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/partners/display-partners.blade.php ENDPATH**/ ?>