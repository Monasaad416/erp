<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">  تحويل رقم <?php echo e($transaction->trans_num); ?></h4>
                    

                    
                </div>

            </div>

            <div class="card-body">
                <div class="d-flex justify-content-around my-3">
                    
                </div>
                <!--[if BLOCK]><![endif]--><?php if($transaction_items->count() > 0): ?>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>المنتج</th>
                                <th>الكود</th>
                                <th>من مخزن</th>
                                <th>إلي مخزن</th>
                                <th>رصيد المخزن المحول منه</th>
                                <th>رصيد المخزن المحول اليه</th>
                                <th>الكمية المحولة</th>
                                <th>الكمية المقبولة</th>
                                <th>تكلفة الوحدة غير شامل ض</th>

                                <td>حالة التحويل</td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قبول-تحويل-مخزن')): ?>
                                    <td>قبول التحويل</td>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if($transaction_items->count() > 0 ): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transaction_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $inventoryFrom = App\Models\Inventory::where('product_id',$item->product_id)->where('store_id',$item->inventoryTransaction->fromStore->id)->latest()->first();
                                        $inventoryto = App\Models\Inventory::where('product_id',$item->product_id)->where('store_id',$item->inventoryTransaction->toStore->id)->latest()->first();
                                    ?>
                                    <tr>
                                        <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($item->product->name_ar); ?></td>
                                        <td><?php echo e($item->product_code); ?></td>
                                        <td><?php echo e($item->inventoryTransaction->fromStore->name); ?></td>
                                        <td><?php echo e($item->inventoryTransaction->toStore->name); ?></td>
                                        <td><?php echo e($inventoryFrom->inventory_balance); ?></td>
                                        <td><?php echo e($inventoryto ? $inventoryto->inventory_balance : 0); ?></td>
                                        <td><?php echo e($item->qty); ?></td>
                                        <td><?php echo e($item->accepted_qty); ?></td>
                                        <td><?php echo e($item->unit_price); ?></td>

                                        <td>
                                            <!--[if BLOCK]><![endif]--><?php if($item->approval == 'pending'): ?>
                                               <p class="text-muted">معلق</p>
                                            <?php elseif($item->approval == 'partially_accepted'): ?>
                                                <p class="text-info">مقبول جزئيا</p>
                                            <?php elseif($item->approval == 'accepted'): ?>
                                                <p class="text-success">مقبول </p>
                                            <?php elseif($item->approval == 'rejected'): ?>
                                                <p class="text-danger">مرفوض </p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                        <?php
                                            $storeFromBranchId = App\Models\Store::where('id',$transaction->from_store_id)->first()->branch_id;
                                            $storeToBranchId = App\Models\Store::where('id',$transaction->to_store_id)->first()->branch_id;
                                            //dd($storeToBranchId);
                                        ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قبول-تحويل-مخزن')): ?>
                                            <td>
                                                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->branch_id == $storeToBranchId): ?>

                                                    <a href="<?php echo e(route('stores.transactions.approve',['trans_num'=> $transaction->trans_num ])); ?>">
                                                        <button type="button" class="btn btn-secondary btn-sm mx-1">
                                                                <i class="fas fa-star"></i>
                                                        </button>
                                                    </a>

                                                <?php else: ?>
                                                    ---
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                            <p>لايوجد تحويلات بين المخازن  </p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="d-flex justify-content-center my-4">
                    <?php echo e($transaction_items->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores-transactions/transaction-items.blade.php ENDPATH**/ ?>