<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قوائم الدخل</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-قائمة-دخل')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_income')); ?>">
                        <span style="font-weight: bolder; font-size:">إضافة/ تعديل<br> قائمة الدخل للعام المالي</span>
                    </button>
                    <?php endif; ?>
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


                <!--[if BLOCK]><![endif]--><?php if($incomes->count() > 0): ?>
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
            <th scope="col">الرصيد</th>
            <th scope="col">الفرع</th>
            <th scope="col">النوع</th>
            <th scope="col">من تاريخ</th>
            <th scope="col">إلي تاريخ</th>
            <th>صافي الربح </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $balance = 0;
        ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr wire:key="income_type-<?php echo e($income->id); ?>">
            <td><?php echo e($loop->iteration); ?></td>
            <td><span class="text-dark"><?php echo e($income->name); ?></span></td>
            <td><span class="text-dark"><?php echo e($income->account_num); ?></span></td>
            <td  style="background-color:   <?php echo e($income->type == "ايراد"  ? 'rgb(189, 236, 189)' : 'rgb(235, 192, 192)'); ?>"><span class="text-dark"><?php echo e($income->balance); ?></span></td>
            <td><span class="text-dark"><?php echo e($income->branch->name); ?></span></td>
            <td><span class="text-dark"><?php echo e($income->type); ?></span></td>
            <td><span class="text-dark"><?php echo e($income->start_date); ?></span></td>
            <td><span class="text-dark"><?php echo e($income->end_date); ?></span></td>
            <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                <td rowspan="12" style="text-align:center ;font-weight:bold;color:rgb(223, 27, 27)" style="vertical-align: middle;"><?php echo e($balance += $income->balance); ?></td>
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
                    <?php echo e($incomes->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/income-list/display-income-list.blade.php ENDPATH**/ ?>