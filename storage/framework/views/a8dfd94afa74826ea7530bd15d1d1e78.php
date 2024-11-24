<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قوائم المركز المالي </h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مركز-مالي')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قائمة المركز المالي  ">
                        <span style="font-weight: bolder; font-size:">إضافة قائمة مركز مالي</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 " placeholder="بحث بالحساب" wire:model.live="searchItem">
                        <select wire:model.live="branch_id" class="form-control  w-25 mx-3">
                            <option value="">إختر الفرع</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($balances->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo e(trans('admin.name')); ?></th>
                                    <th scope="col"><?php echo e(trans('admin.account_num')); ?></th>
                                    <th scope="col">مدين</th>
                                    <th scope="col">دائن</th>
                                    <th scope="col">الرصيد</th>
                                    <th scope="col">الفرع</th>
                                    <th scope="col">من تاريخ</th>
                                    <th scope="col">إلي تاريخ</th>
            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $debitBalance = 0;
                                        $creditBalance = 0;

                                ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $balances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    
                        
                                    if($balance->account->level == 1 ) {
                                        $bg = '#add0f5';
                                    }elseif($balance->account->level == 2 ) {
                                        $bg = '#f2eecd';
                                    }elseif($balance->account->level == 3 ) {
                                        $bg = '#eff3f8';
                                    }elseif($balance->account->level == 4 ) {
                                        $bg = '#e2fae0';
                                    }elseif($balance->account->level == 5 ) {
                                        $bg = '#f1e4ea';
                                    }
                        


                                    ?>

                                    <tr wire:key="balance_type-<?php echo e($balance->id); ?>" style="background-color: <?php echo e($bg); ?>" >
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><span class="text-dark"><?php echo e($balance->name); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->account_num); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->debit); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->credit); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->balance); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->branch->name); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->start_date); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($balance->end_date); ?></span> </td>     
                                    </tr>

                                    <?php


                                    ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                
                            </tbody>
                        </table>
                <?php else: ?>
                     <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($balances->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/financial-positions/display-financial-positions.blade.php ENDPATH**/ ?>