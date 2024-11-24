<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة رأ س المال</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-راس-مال')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_capital')); ?>">
                        <span style="font-weight: bolder; font-size:">إضافة رأس مال</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الشريك" wire:model.live="searchItem">
                    </div>


                <!--[if BLOCK]><![endif]--><?php if($capitals->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>إسم الشريك</th>
                            <th><?php echo e(trans('admin.account_num')); ?></th>
                            <th>المبلغ</th>
                            <th>تاريخ الإضافة</th>
                            
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-راس-مال')): ?>
                            <th><?php echo e(trans('admin.edit')); ?></th>
                            <?php endif; ?>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $capitals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capital): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($capital->partner->name); ?></td>
                                    <td><?php echo e($capital->account_num); ?></td>
                                    <td ><?php echo e($capital->amount); ?></td>
                                    <td><?php echo e(Carbon\Carbon::parse($capital->start_date)->format('Y-m-d')); ?></td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-راس-مال')): ?>
                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateCapital',{id:<?php echo e($capital->id); ?>})">
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
                    <?php echo e($capitals->links()); ?>

                </div>

            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/capitals/display-capitals.blade.php ENDPATH**/ ?>