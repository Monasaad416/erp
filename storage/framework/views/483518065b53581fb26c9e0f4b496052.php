<div>

    <div class="card-body">
        <h3 class="text-muted my-3"><?php echo e(trans('admin.customer_invoice_details')); ?> <?php echo "&nbsp;"; ?><?php echo e($invoice->customer_inv_num); ?></h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th><?php echo e(trans('admin.product_code')); ?></th>
                <th><?php echo e(trans('admin.name_ar')); ?></th>
                <th><?php echo e(trans('admin.name_en')); ?></th>
                <th><?php echo e(trans('admin.unit')); ?></th>
                <th><?php echo e(trans('admin.qty')); ?></th>
                <th><?php echo e(trans('admin.sale_price')); ?></th>
                <th> <?php echo e(trans('admin.tax_value')); ?></th>
                </tr>
            </thead>
            <tbody>
        
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <td><?php echo e($item->sale_price); ?></td>
                        <td><?php echo e($item->taxes ?  $item->taxes : 0); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <h3 class="text-danger my-3">إشعارات الدائن</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th><?php echo e(trans('admin.product_code')); ?></th>
                <th><?php echo e(trans('admin.name_ar')); ?></th>
                <th><?php echo e(trans('admin.name_en')); ?></th>
                <th><?php echo e(trans('admin.unit')); ?></th>
                <th><?php echo e(trans('admin.qty')); ?></th>
                <th><?php echo e(trans('admin.sale_price')); ?></th>
                <th> <?php echo e(trans('admin.tax_value')); ?></th>
                <th>رقم الإشعار</th>
                <th> طباعة</th>
                </tr>
            </thead>
            <tbody>
        
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serial_num => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $rowspan = count($items);
                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php echo e($return->product_code); ?>

                            </td>
                            <td>
                                <?php echo e($return->product_name_ar); ?>

                            </td>
                            <td>
                                <?php echo e($return->product_name_en); ?>

                            </td>
                            <td><?php echo e($return->unit); ?></td>
                            <td><?php echo e($return->qty); ?></td>
                            <td><?php echo e($return->sale_price); ?></td>
                            <td><?php echo e($return->taxes ?  $return->taxes : 0); ?></td>
                            <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                <td rowspan="<?php echo e($rowspan); ?>"><?php echo e($serial_num); ?></td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <td></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>

    <div class="card-body">
        <h3 class="text-success my-3">إشعارات المدين</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th><?php echo e(trans('admin.product_code')); ?></th>
                <th><?php echo e(trans('admin.name_ar')); ?></th>
                <th><?php echo e(trans('admin.name_en')); ?></th>
                <th><?php echo e(trans('admin.unit')); ?></th>
                <th><?php echo e(trans('admin.qty')); ?></th>
                <th><?php echo e(trans('admin.sale_price')); ?></th>
                <th> <?php echo e(trans('admin.tax_value')); ?></th>
                <th>رقم الإشعار</th>
                <th> طباعة</th>
                </tr>
            </thead>
            <tbody>
        
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $debitNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serial_num => $notes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $rowspan = count($notes);
                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$debit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                        <tr>
                            
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php echo e($debit->product_code); ?>

                            </td>
                            <td>
                                <?php echo e($debit->product_name_ar); ?>

                            </td>
                            <td>
                                <?php echo e($debit->product_name_en); ?>

                            </td>
                            <td><?php echo e($debit->unit); ?></td>
                            <td><?php echo e($debit->qty); ?></td>
                            <td><?php echo e($debit->sale_price); ?></td>
                            <td><?php echo e($debit->taxes ?  $debit->taxes : 0); ?></td>
                            <td><?php echo e($serial_num); ?></td>
                            <td><?php echo e($debit->sale_price); ?></td>
                            <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                <td rowspan="<?php echo e($rowspan); ?>"><?php echo e($serial_num); ?></td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices/show-invoice.blade.php ENDPATH**/ ?>