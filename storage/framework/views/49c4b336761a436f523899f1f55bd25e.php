
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <?php
                        $invoice = App\Models\CustomerInvoice::where('id',$invoiceReturn->customer_invoice_id)->first();
                    ?>
                    <h4 class="card-title h4">إشعار دائن رقم <?php echo e($invoiceReturn->serial_num); ?>  
                        <?php echo e($invoice ?  "والخاص بفاتورة مبيعات رقم " . $invoice->customer_inv_num : ""); ?></h4>
                    <a href="<?php echo e(route('customers_returns.print_return',[ 'return_num' => $invoiceReturn->serial_num ])); ?>">
                        <button type="button" title="طباعة" class="btn btn-outline-secondary mx-1">
                            <i class="fas fa-print"></i>
                        </button>
                    </a>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($items->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_category')); ?> " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                            <th><?php echo e(trans('admin.branch')); ?></th>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <th>رقم الفاتورة</th>
                        <th><?php echo e(trans('admin.product_code')); ?></th>
                        <th><?php echo e(trans('admin.name')); ?></th>
                        <th><?php echo e(trans('admin.unit')); ?></th>
                        <th><?php echo e(trans('admin.qty')); ?></th>
                        
                        <th><?php echo e(trans('admin.sale_price')); ?></th>
                        <th> <?php echo e(trans('admin.tax_value')); ?></th>

               
                        </tr>
                    </thead>
                    <tbody>


                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         
                                <tr>
                                    <?php
                                        if($item->return_status === 1 ) {
                                            $status = 'رد كلي للفاتورة';
                                        }
                                        if($item->return_status ===2 ) {
                                            $status = 'رد كلي للبند';
                                        }
                                        if($item->return_status === 3 ) {
                                            $status = 'رد جزئي للبند';
                                        }
                                    ?>
                                    
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                        <td>
                                            <?php echo e($invoiceReturn->branch->name); ?>

                                        </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                                    <td>
                                        <?php
                                            $invoiceReturn = App\Models\CustomerReturn::where('id',$item->customer_return_id)->first();
                                            $invoice = App\Models\CustomerInvoice::withTrashed()->where('id',$invoiceReturn->customer_invoice_id)->first();
                                            //dd($invoice);
                                        ?>
                                        <?php echo e($invoice ? $invoice->customer_inv_num : '---'); ?>

                                    </td>   
                                    <td>
                                        <?php echo e($item->product_code); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->product_name_ar); ?>

                                    </td>
                                    <td><?php echo e($item->unit); ?></td>
                                    <td><?php echo e($item->return_qty); ?></td>
                                    
                                    <td><?php echo e($item->sale_price); ?></td>
                                    <td><?php echo e($item->taxes ?  $item->taxes : 0); ?></td>
                 
                                </tr>
                
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($items->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices-returns/show-returns.blade.php ENDPATH**/ ?>