<div>
    <form wire:submit.prevent="approve">
        <div class="row">
            <div class="col-12">
                <hr>
                <div class="row">

                    <table class="table table-bordered" id="supp_inv">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo e(trans('admin.product_code')); ?></th>
                                <th><?php echo e(trans('admin.name')); ?></th>
                                <th><?php echo e(trans('admin.qty')); ?></th>
                                <th><?php echo e(trans('admin.unit')); ?></th>
                                <th>سعر الوحدة</th>
                                <th>إجمالي السعر</th>
                                <th>قبول البند</th>
                                <th> الكمية المقبولة</th>


                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width: 10px"><?php echo e($loop->iteration); ?></td>
                                    <td><p><?php echo e($trans->product_code); ?></p></td>

                                    <td> <p><?php echo e($trans->product_name_ar); ?></p></td>
                                    <td><p><?php echo e($trans->qty); ?></p></td>

                                    <td><p><?php echo e($trans->unit); ?></p></td>
                                    <td><p><?php echo e($trans->unit_price); ?></p></td>

                                    <td><p><?php echo e($trans->total_price); ?></p></td>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($trans->approval == 'pending'): ?>
                                        <select class="form-control" wire:model.live="approval.<?php echo e($index); ?>">
                                            <option value="" selected>إختر حالة القبول</option>
                                            <option value="accepted" <?php echo e(isset($approval[$index]) && $approval[$index] === 'accepted' ? 'selected' : ''); ?>>مقبول</option>
                                            <option value="partially_accepted" <?php echo e(isset($approval[$index]) && $approval[$index] === 'partially_accepted' ? 'selected' : ''); ?>>مقبول جزئيا</option>
                                            <option value="rejected" <?php echo e(isset($approval[$index]) && $approval[$index] === 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                                        </select>
                                        <?php else: ?>
                                        <p>تم التعامل مع التحويل</p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>

                                    <!--[if BLOCK]><![endif]--><?php if(isset($approval[$index]) && $approval[$index] === 'partially_accepted'): ?>
                                        <td>
                                            <input type="number" min="0" step="any" max="<?php echo e(isset($trans->qty) ? $trans->qty : 0); ?>" class="form-control" wire:model="accepted_qty.<?php echo e($index); ?>">
                                        </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center">
            <button type="submit"  class="btn btn-info mx-2">حفظ</button>
        </div>
    </form>


</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores-transactions/approve-store-transaction.blade.php ENDPATH**/ ?>