<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.shifts_types_list')); ?></h4>
                    
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_shift')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_shift')); ?></span>
                    </button>
                    
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($shiftsTypes->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_shift')); ?> " wire:model.live="searchItem">
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
                                <th scope="col"><?php echo e(trans('admin.shift_type')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.shift_start')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.shift_end')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.total_hours')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.created_by')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.updated_by')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.status')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.edit')); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $shiftsTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr wire:key="shift-<?php echo e($shift->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
            
                                    <td><span class="text-dark"><?php echo e($shift->label()); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($shift->start); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($shift->end); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($shift->total_hours); ?></span> </td>
                                    <td><?php echo e($shift->createdBy->name); ?></td>
                                    <td><?php echo e($shift->updated_by ?  $shift->updatedBy->name  :'---'); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-<?php echo e($shift->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($shift->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('toggleShift',{id:<?php echo e($shift->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($shift->is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateShift',{id:<?php echo e($shift->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($shiftsTypes->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/shifts-types/display-shifts-types.blade.php ENDPATH**/ ?>