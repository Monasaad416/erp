<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة اجماليات الضرائب</h4>
                    <?php
                        $currentDate = Carbon\Carbon::now();
                        $cutoffDateFirst = Carbon\Carbon::createFromDate($currentDate->year, 3, 31);
                        $cutoffDateSec = Carbon\Carbon::createFromDate($currentDate->year, 6, 30);
                        $cutoffDateThird = Carbon\Carbon::createFromDate($currentDate->year, 9, 30);
                        $cutoffDateForth = Carbon\Carbon::createFromDate($currentDate->year, 12, 31);
                    ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-ميزان-مراجعة')): ?>

                                <button type="button" class="btn bg-gradient-cyan"  <?php echo e($currentDate->greaterThanOrEqualTo($cutoffDateFirst) ? '' : 'disabled'); ?> data-toggle="modal" data-target="#create_modal_first" title="إضافة ضرائب الربع الاول">
                                    <span style="font-weight: bolder; font-size:">إضافة ضرائب الربع المالي </span>
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


                <!--[if BLOCK]><![endif]--><?php if($taxes->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">إجمالي ضرائب المدخلات</th>
                                    <th scope="col">اجمالي ضرائب المخرجات</th>
                                    <th scope="col">الفرع</th>
                                    <th scope="col">من تاريخ</th>
                                    <th scope="col">إلي تاريخ</th>

                                </tr>
                            </thead>
                            <tbody>

                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <tr wire:key="balance_type-<?php echo e($tax->id); ?>">
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><span class="text-dark"><?php echo e($tax->in_amount); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($tax->out_amount); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($tax->branch->name); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($tax->start_date); ?></span> </td>
                                        <td><span class="text-dark"><?php echo e($tax->end_date); ?></span> </td>
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
                    <?php echo e($taxes->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/taxes/display-taxes.blade.php ENDPATH**/ ?>