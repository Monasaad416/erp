<div class="row">
    <div class="col">
        <div class="card">
            <?php

            ?>
            <div class="card-header">
                <div class="d-flex justify-content-around my-2">
                    
                    

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-ايصال-صرف')): ?>
                    <a href="<?php echo e(route('create_exchange_reciept')); ?>">
                        <button type="button" class="btn btn-outline-danger mx-1" title="إضافة إيصال صرف">
                            إضافة إيصال صرف
                        </button>
                    </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-ايصال-قبض')): ?>
                    <a href="<?php echo e(route('create_collection_reciept')); ?>">
                        <button type="button" class="btn btn-outline-success mx-1" title="إضافة إيصال تحصيل">
                            إضافة إيصال تحصيل
                        </button>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                       <div class="d-flex my-3">
                    <input type="text" class="form-control mx-2" placeholder="بحث برقم الفاتورة" wire:model.live="searchItem">
                    <input type="text" class="form-control mx-2" placeholder="بحث برقم الحساب " wire:model.live="accountNum">
                    <select class="form-control  mx-2 " wire:model.live="branch_id">
                        <option value="" >إختر الفرع</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    </select>
                    <select class="form-control mx-2" wire:model.live="state">
                        <option value="">إختر نوع الحركة</option>
                        <option value="صرف" <?php echo e($state == 'صرف' ? 'selected':''); ?> >صرف</option>
                        <option value="تحصيل" <?php echo e($state == 'تحصيل' ? 'selected':''); ?>>تحصيل</option>
                    </select>
                </div>
                <div class="d-flex justify-content-around">
                        <div class="form-group w-50 mx-1">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date" class="form-control ml-2" wire:model.live="from_date">
                        </div>



                        <div class="form-group w-50 mx-1">
                            <label for="from_date">إلي تاريخ:</label>
                            <input type="date" class="form-control ml-2"  wire:model.live="to_date">
                        </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($transactions->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>الخزينة</th>
                                <th>رقم الحركة</th>
                                <th>نوع الحركة</th>
                                <th>وصف الحركة</th>
                                <th>تابعة لحساب مالي</th>
                                <th>رقم الحساب</th>
                                <th>رقم الفاتورة</th>
                                <th>قيمة الإيصال</th>
                                <th>وردية الخزينة</th>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-حركة-خزينة')): ?>
                                <th>تعديل</th>
                                 <?php endif; ?>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-حركة-خزينة')): ?>
                                <th>حذف</th>
                                 <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($transaction->treasury->name); ?></td>
                                    <td><?php echo e($transaction->serial_num); ?></td>
                                    <td class="text-<?php echo e($transaction->state =="صرف" ? 'danger' : 'success'); ?>"><?php echo e($transaction->state); ?></td>
                                    <td><?php echo e($transaction->description ? $transaction->description : '--'); ?></td>
                                    <td class="text-<?php echo e($transaction->is_account ? 'success':'danger'); ?>"><?php echo e($transaction->is_account ? trans('admin.yes') : trans('admin.no')); ?></td>
                                    <td><?php echo e($transaction->account_num ? $transaction->account_num : '---'); ?></td>
                                    <td><?php echo e($transaction->inv_num ? $transaction->inv_num : '---'); ?></td>
                                    <td><?php echo e($transaction->receipt_amount); ?></td>
                                    <td><?php echo e($transaction->treasuryShift->deliveredToShiftType->label()); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-حركة-خزينة')): ?>
                                    <td class="text-center">

                                        <button type="button" <?php echo e($transaction->state =="تحصيل"  ? 'disabled' : ''); ?> class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateTransaction',{id:<?php echo e($transaction->id); ?> })">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                     <?php endif; ?>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-حركة-خزينة')): ?>
                                    <td>

                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteTransaction',{id:<?php echo e($transaction->id); ?>})">
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
                    <?php echo e($transactions->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-transactions/display-transactions.blade.php ENDPATH**/ ?>