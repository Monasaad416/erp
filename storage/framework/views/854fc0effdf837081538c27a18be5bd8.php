<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.units_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-وحدة')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_unit')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_unit')); ?></span>
                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($units->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_unit')); ?>  " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo e(trans('admin.unit')); ?></th>
                            <th><?php echo e(trans('admin.operations')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($unit->name); ?></td>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-وحدة')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateUnit',{id:<?php echo e($unit->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-وحدة')): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="<?php echo e(trans('admin.delete')); ?>"
                                            data-toggle="modal"
                                            

                                            wire:click="$dispatch('deleteUnit',{id:<?php echo e($unit->id); ?>})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($units->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/units/display-units.blade.php ENDPATH**/ ?>