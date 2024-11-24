<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.suppliers_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مورد')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_supplier')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_supplier')); ?></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_supplier_name')); ?>" wire:model.live="searchItem">
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($suppliers->count() > 0): ?>
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
                            <th><?php echo e(trans('admin.account_num')); ?></th>
                            <th><?php echo e(trans('admin.tax_num')); ?></th>
                            <th><?php echo e(trans('admin.address')); ?></th>
                            <th><?php echo e(trans('admin.email')); ?></th>
                            <th><?php echo e(trans('admin.phone')); ?></th>
                            <th><?php echo e(trans('admin.balance_state')); ?></th>
                            <th><?php echo e(trans('admin.start_balance')); ?></th>
                            <th><?php echo e(trans('admin.current_balance')); ?></th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مورد')): ?>
                            <th><?php echo e(trans('admin.edit')); ?></th>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مورد')): ?>
                            <th><?php echo e(trans('admin.delete')); ?></th>
                            <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($supplier->name); ?></td>
                                    <td><?php echo e($supplier->account_num); ?></td>
                                    <td class="text-center" style="width:8%"><?php echo e($supplier->tax_num); ?></td>
                                    <td ><?php echo e($supplier->address ? $supplier->address : "---"); ?></td>
                                     <td ><?php echo e($supplier->email ? $supplier->email : "---"); ?></td>
                                    <td ><?php echo e($supplier->phone ? $supplier->phone : "---"); ?></td>
                                     <?php
                                        $state = $supplier->balance_state;
                                        if($state == 1) {
                                            $state = trans('admin.debit');
                                        } elseif ($state == 2) {
                                            $state = trans('admin.credit');
                                        } elseif ($state == 3) {
                                            $state = trans('admin.balanced_at_start') ;
                                        }
                                    ?>
                                    <td ><?php echo e($state); ?></td>
                                    <td ><?php echo e($supplier->start_balance ? $supplier->start_balance : "0"); ?></td>
                                    <td ><?php echo e($supplier->current_balance ? $supplier->current_balance : "0"); ?></td>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-مورد')): ?>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateSupplier',{id:<?php echo e($supplier->id); ?>})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-مورد')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSupplier',{id:<?php echo e($supplier->id); ?>})">
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
                    <?php echo e($suppliers->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/asset-suppliers/display-suppliers.blade.php ENDPATH**/ ?>