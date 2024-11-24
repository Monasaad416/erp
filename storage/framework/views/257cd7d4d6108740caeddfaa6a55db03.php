<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.branches_list')); ?></h4>
                    
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_branch_name')); ?>" wire:model.live="searchItem">
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($branches->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo e(trans('admin.branch_num')); ?></th>
                            <th><?php echo e(trans('admin.name')); ?></th>
                            <th>رقم المبني</th>
                            <th>إسم الشارع</th>
                            <th>المنطقة</th>
                            <th>المحافظة</th>
                            <th>الكود البريدي</th>
                            <th>الرقم الفرعي</th>
                            <th><?php echo e(trans('admin.phone')); ?></th>
                            <th><?php echo e(trans('admin.email')); ?></th>
                            <th><?php echo e(trans('admin.gln')); ?></th>
                            <th><?php echo e(trans('admin.status')); ?></th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فرع')): ?>
                            <th><?php echo e(trans('admin.edit')); ?></th>
                            <?php endif; ?>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center" ><?php echo e($branch->branch_num); ?></td>
                                    <td><?php echo e($branch->name); ?></td>
                                    <td><?php echo e($branch->building_number); ?></td>
                                    <td><?php echo e($branch->streetName); ?></td>
                                    <td><?php echo e($branch->region); ?></td>
                                    <td><?php echo e($branch->city); ?></td>
                                    <td><?php echo e($branch->postal_code); ?></td>
                                    <td><?php echo e($branch->plot_identification); ?></td>
                                    <td><?php echo e($branch->phone ? $branch->phone : "---"); ?></td>
                                    <td><?php echo e($branch->email ? $branch->email : "---"); ?></td>
                                    <td><?php echo e($branch->gln); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-<?php echo e($branch->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($branch->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('toggleBranch',{id:<?php echo e($branch->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($branch->is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فرع')): ?>
                                    <td class="text-center" >

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateBranch',{id:<?php echo e($branch->id); ?>})">
                                            <i class="far fa-edit"></i>
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
                    <?php echo e($branches->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/branches/display-branches.blade.php ENDPATH**/ ?>