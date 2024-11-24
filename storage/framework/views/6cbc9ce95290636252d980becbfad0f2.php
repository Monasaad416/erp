<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.shifts_types_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-وردية-خزينة')): ?>
                    <button type="button" <?php echo e($currentTreasuryShift && Auth::user()->roles_name != 'سوبر-ادمن' ? 'disabled' : ''); ?> class="btn bg-gradient-cyan"  data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_user_shift')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_user_shift')); ?>

                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($treasuryShifts->count() > 0): ?>

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
                                <th colspan="7" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.delivered_shift_info')); ?></th>
                                <th colspan="2" style="background-color: rgb(183, 211, 233)" ><?php echo e(trans('admin.delivered_to_shift_info')); ?></th>
                                <th ></th>
                                <th ></th>
                                <th ></th>
                                <th ></th>

                            </tr>
                            <tr>
                                <th scope="col" >#</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.delivered_user')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.shift')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.shift_start_date')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.shift_end_date')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.start_shift_cash_balance')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.end_shift_cash_balance')); ?></th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)"><?php echo e(trans('admin.end_shift_bank_balance')); ?></th>
                                
                                
                                <th scope="col" style="background-color: rgb(183, 211, 233)"><?php echo e(trans('admin.delivered_to_user')); ?></th>
                                <th scope="col" style="background-color: rgb(183, 211, 233)"><?php echo e(trans('admin.shift')); ?></th>
                                <th scope="col" rowspan="2"><?php echo e(trans('admin.branch')); ?></th>
                                <th scope="col" rowspan="2"><?php echo e(trans('admin.delived_to_approval')); ?></th>

                                <th scope="col" rowspan="2"><?php echo e(trans('admin.edit')); ?></th>
                                <th scope="col" rowspan="2"><?php echo e(trans('admin.delete')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>

                            </style>


                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $treasuryShifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr wire:key="shift-<?php echo e($shift->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e($shift->delivered->name); ?></td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e($shift->deliveredShiftType->label()); ?> </td>
                                    <td style="background-color: rgb(244, 232, 230)"> <?php echo e(Carbon\Carbon::parse($shift->start_shift_date_time)->format('d-m-Y H:i')); ?></td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e(Carbon\Carbon::parse($shift->end_shift_date_time)->format('d-m-Y H:i')); ?></td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e($shift->start_shift_cash_balance); ?> </td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e($shift->end_shift_cash_balance); ?> </td>
                                    <td style="background-color: rgb(244, 232, 230)"><?php echo e($shift->end_shift_bank_balance); ?> </td>
                                    
                                    
                                    <td style="background-color: rgb(183, 211, 233)"><?php echo e($shift->deliveredTo->name); ?></td>
                                    <td style="background-color: rgb(183, 211, 233)"><?php echo e($shift->deliveredToShiftType->label()); ?></td>
                                    <td><?php echo e($shift->branch->name); ?></td>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-وردية-خزينة')): ?>
                                     <?php endif; ?>
                                    <td>
                                        <button type="button" class="btn btn-<?php echo e($shift->is_approved  == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($shift->is_approved  == 1 ? trans('admin.is_approved') : trans('admin.not_approved_yet')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('recieveShift',{id:<?php echo e($shift->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($shift->is_approved == 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-وردية-خزينة')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateTreasuryShift',{id:<?php echo e($shift->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    <?php endif; ?>
                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-وردية-خزينة')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            
                                            title=<?php echo e(trans('admin.delete_shift')); ?>

                                            wire:click="$dispatch('deleteTreasuryShift',{id:<?php echo e($shift->id); ?>})">
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
                    <?php echo e($treasuryShifts->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-shifts/display-treasury-shifts.blade.php ENDPATH**/ ?>