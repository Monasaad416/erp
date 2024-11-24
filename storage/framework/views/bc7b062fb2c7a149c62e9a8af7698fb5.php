<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">الأرباح والخسائر</h4>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3 search_term">
                            <option value="">إختر الفرع</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <select class="form-control w-25 search_term mx-3"  wire:model.live="searchItem">
                            <option>إختر السنة المالية </option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\FinancialYear::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($year->year); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($profits->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
           <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">الربح أو الخسارة</th>
            <th scope="col">الفرع</th>
            <th scope="col">من تاريخ</th>
            <th scope="col">إلي تاريخ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $balance = 0;
        ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $profits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $profit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr wire:key="income_type-<?php echo e($profit->id); ?>">
            <td><?php echo e($loop->iteration); ?></td>
            <td><span class="text-dark"><?php echo e($profit->profit); ?></span></td>
            <td><span class="text-dark"><?php echo e($profit->branch->name); ?></span></td>
            <td><span class="text-dark"><?php echo e($profit->start_date); ?></span></td>
            <td><span class="text-dark"><?php echo e($profit->end_date); ?></span></td>
            <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                <td rowspan="12" style="text-align:center ;font-weight:bold;color:rgb(223, 27, 27)" style="vertical-align: middle;"><?php echo e($balance += $profit->balance); ?></td>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </tr>
        <?php
        // Additional logic for calculations
        ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        
    </tbody>
</table>
                <?php else: ?>
                     <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($profits->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>






<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/net-profits/display-net-profits.blade.php ENDPATH**/ ?>