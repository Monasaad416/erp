
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة المردودات</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مردودات-فاتورة-عميل')): ?>
                        <a href="<?php echo e(route('customers.create_invoice_return')); ?>" id="newInvoice" class="text-white">
                            <button type="button" class="btn bg-gradient-cyan"  title="رد بند فاتورة مبيعات">
                                <span style="font-weight: bolder; font-size:">رد بند (إشعار دائن)</span>
                            </button>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($returns->count() > 0): ?>

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
                        <th>رقم الإشعار</th>
                        <th>الحالة</th>
                        <th>التفاصيل</th>
                        <th>طباعة</th>
                        </tr>
                    </thead>
                    <tbody>


                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         
                            <tr>
                                <?php

                                    if($return->return_status === 1 ) {
                                        $status = 'رد كلي للفاتورة';
                                    }
                                    if($return->return_status ===2 ) {
                                        $status = 'رد كلي للبند';
                                    }
                                    if($return->return_status === 3 ) {
                                        $status = 'رد جزئي للبند';
                                    }
                                    else{
                                        $status = '---';
                                    }
                                ?>
                                
                                <td><?php echo e($loop->iteration); ?></td>
                                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                    <td>
                                        <?php echo e($return->branch->name); ?>

                                    </td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                                <td>
                                    <?php
                                        $invoice = App\Models\CustomerInvoice::withTrashed()->where('id',$return->customer_invoice_id)->first();
                                        //dd($invoice);
                                    ?>
                                    <?php echo e($return->customer_invoice_id ? $invoice->customer_inv_num : '---'); ?>

                                </td>   
                                <td><?php echo e($return->serial_num); ?></td>
                                <td><?php echo e($status); ?></td>
                                <td>
                                    <a href="<?php echo e(route('customers_returns.show_return',['return_num'=> $return->serial_num])); ?>">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <!--[if BLOCK]><![endif]--><?php if($invoice): ?>
                                    <a href="<?php echo e(route('customers_returns.print_return',[ 'return_num' => $return->serial_num ])); ?>">
                                        <button type="button" title="طباعة" class="btn btn-outline-dark btn-sm mx-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </a>
                                    <?php else: ?>
                                    <span>---</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($returns->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices-returns/display-returns.blade.php ENDPATH**/ ?>