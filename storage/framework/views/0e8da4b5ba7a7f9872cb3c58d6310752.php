

<div class="row">
    <?php
        $transactions = App\Models\Transaction::where('transactionable_type','App\Models\Supplier')->where('inv_num',$invoice->supp_inv_num)->get();
        $bankTransactions = App\Models\BankTransaction::where('transactionable_type','App\Models\Supplier')->where('inv_num',$invoice->supp_inv_num)->get();
    ?>
    <div class="col">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false"><?php echo e(trans('admin.details')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-receipts-tab" data-toggle="pill" href="#custom-tabs-two-receipts" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">إيصالات صرف </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-receipts-tab" data-toggle="pill" href="#custom-tabs-two-checks" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false"> شيكات دفع  </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                         <div class="card-body">
                                            <h5 class="text-danger my-4"><?php echo e(trans('admin.supplier_invoice_details')); ?> <?php echo "&nbsp;"; ?><?php echo e($invoice->supp_inv_num); ?></h5>

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th><?php echo e(trans('admin.product_code')); ?></th>
                                                        <th><?php echo e(trans('admin.name_ar')); ?></th>
                                                        <th><?php echo e(trans('admin.name_en')); ?></th>
                                                        <th><?php echo e(trans('admin.unit')); ?></th>
                                                        <th><?php echo e(trans('admin.qty')); ?></th>
                                                        <th><?php echo e(trans('admin.wholesale_inc_vat')); ?></th>
                                                        <th><?php echo e(trans('admin.purchase_price')); ?></th>
                                                        <th> <?php echo e(trans('admin.tax_value')); ?></th>
                                                        <th>الإجمالي</th>
                                                        <th><?php echo e(trans('admin.batch_num')); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $invoice_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                
                                                                <td><?php echo e($loop->iteration); ?></td>
                                                                <td>
                                                                    <?php echo e($item->product_code); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($item->product_name_ar); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($item->product_name_en); ?>

                                                                </td>
                                                                <td><?php echo e($item->unit); ?></td>
                                                                <td><?php echo e($item->qty); ?></td>
                                                                <td><?php echo e($item->wholesale_inc_vat ?  $item->wholesale_inc_vat : 0); ?></td>

                                                                <td><?php echo e($item->purchase_price ?  $item->purchase_price : 0); ?></td>
                                                                <td><?php echo e($item->tax_value ?  $item->tax_value : 0); ?></td>
                                                                <td><?php echo e($item->tax_value ?  $item->tax_value + $item->purchase_price : $item->purchase_price); ?></td>
                                                                <td><?php echo e($item->batch_num ?  $item->batch_num : '---'); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </tbody>
                                                </table>

                                        </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-receipts" role="tabpanel" aria-labelledby="custom-tabs-two-receipts-tab">
                                    <div class="card-body">
                                            <h5 class="text-danger my-4">إيصالات الصرف لسداد فاتورة مورد رقم <?php echo "&nbsp;"; ?><?php echo e($invoice->supp_inv_num); ?></h5>

                                            <h6 class="text-muted mb-3">المورد : <?php echo e($invoice->supplier->name); ?></h6>
                                            <!--[if BLOCK]><![endif]--><?php if($transactions->count() > 0): ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th> وردية الخزينة</th>
                                                        <th> مسئول الخزينة</th>
                                                        <th>قيمة الإيصال</th>
                                                        <th>المبلغ المستحق للحساب</th>
                                                        <th>الوصف</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                
                                                                <td><?php echo e($loop->iteration); ?></td>
                                                                <td>
                                                                    <?php echo e($trans->treasuryShift->deliveredToShiftType->label()); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->treasuryShift->deliveredTo->name); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->receipt_amount); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->deserved_account_amount); ?>

                                                                </td>
                                                                <td><?php echo e($trans->description ?? null); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p class="h4 text-muted text-center"><?php echo e(trans('admin.not_found')); ?></p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-banks" role="tabpanel" aria-labelledby="custom-tabs-two-receipts-tab">
                                    <div class="card-body">
                                            <h5 class="text-danger my-4">شيكات  لسداد فاتورة مورد رقم <?php echo "&nbsp;"; ?><?php echo e($invoice->supp_inv_num); ?></h5>

                                            <h6 class="text-muted mb-3">المورد : <?php echo e($invoice->supplier->name); ?></h6>
                                            <!--[if BLOCK]><![endif]--><?php if($bankTransactions->count() > 0): ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>البنك</th>
                                                        <th>رقم الشيك</th>
                                                        <th>قيمة الشيك</th>
                                                        <th>المبلغ المستحق للحساب</th>
                                                        <th>الوصف</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                
                                                                <td><?php echo e($loop->iteration); ?></td>
                                                                <td>
                                                                    <?php echo e($trans->treasuryShift->deliveredToShiftType->label()); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->treasuryShift->deliveredTo->name); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->receipt_amount); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($trans->deserved_account_amount); ?>

                                                                </td>
                                                                <td><?php echo e($trans->description ?? null); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p class="h4 text-muted text-center"><?php echo e(trans('admin.not_found')); ?></p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/supplier-invoices/show-invoice.blade.php ENDPATH**/ ?>