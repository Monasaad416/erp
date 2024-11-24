<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.customers_invoices_list')); ?></h4>
                    <div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-فاتورة-عميل')): ?>
                        <a href="<?php echo e(route('customers.create_invoice')); ?>" id="newInvoice" class="text-white">
                            <button type="button" class="btn bg-gradient-cyan"  title="إضافة فاتورة">
                                <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_customer_invoice')); ?></span>
                            </button>
                        </a>
                        <a href="<?php echo e(route('customers.create_invoice_return')); ?>" id="newInvoice" class="text-white">
                            <button type="button" class="btn bg-gradient-danger"  title="إضافة مرتجع">
                                <span style="font-weight: bolder; font-size:">إضافة مرتجع</span>
                            </button>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_customer_inv_num')); ?>" wire:model.live="searchItem">

                        <!--[if BLOCK]><![endif]--><?php if(auth()->user()->roles_name == 'سوبر-ادمن'): ?>
                            <select class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_customer_inv_completed')); ?>" wire:model.live="branch_id">
                                <option value="" ><?php echo e(trans('admin.select_branch')); ?></option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::whereNot('id',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name_ar); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                        <select class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_customer_inv_completed')); ?>" wire:model.live="pending_status">
                            <option value="" ><?php echo e(trans('admin.select_status')); ?></option>
                            <option value="1" <?php echo e($pending_status === 1 ? 'selected':''); ?>><?php echo e(trans('admin.pending_invoice')); ?></option>
                            <option value="0" <?php echo e($pending_status === 0 ? 'selected':''); ?>><?php echo e(trans('admin.completed_invoice')); ?></option>
                        </select>

                        <select class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_customer_inv_completed')); ?>" wire:model.live="pending_status">
                            <option value="" ><?php echo e(trans('admin.select_status')); ?></option>
                            <option value="10" <?php echo e($return_status == 10 ? 'selected':''); ?>><?php echo e(trans('admin.return_invoice')); ?></option>
                            <option value="11" <?php echo e($return_status == 11 ? 'selected':''); ?>><?php echo e(trans('admin.return_item')); ?></option>
                        </select>

                        <input type="date" class="form-control mx-1" placeholder="من تاريخ" wire:model.live="from_date">
                        <input type="date" class="form-control mx-1" placeholder="إلي تاريخ" wire:model.live="to_date">

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

                <!--[if BLOCK]><![endif]--><?php if($customerInvoices->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo e(trans('admin.inv_num')); ?></th>
                                <th><?php echo e(trans('admin.inv_date_time')); ?></th>
                                <th><?php echo e(trans('admin.customer_name')); ?></th>
                                <th><?php echo e(trans('admin.is_pending')); ?></th>
                                
                                <th><?php echo e(trans('admin.created_by')); ?></th>
                                <th><?php echo e(trans('admin.updated_by')); ?></th>
                                <th><?php echo e(trans('admin.show')); ?></th>
                                <th>إجمالي المبلغ</th>
                                <th> الدفع</th>
                                <th>طباعة</th>
                                
                                
                                <th>محذوفة / مردودة</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فاتورة-عميل')): ?>
                                <th>إشعار مدين<br> (إضافة بنود)</th>
                                <th>إشعار دائن<br> ( إضافة مرتجع)</th>
                                <?php endif; ?>
                                 
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $customerInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerInv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($customerInv->customer_inv_num); ?></td>
                                    <td>
                                        <?php echo e(Carbon\Carbon::parse($customerInv->customer_inv_date_time)->format('d-m-Y ')); ?>

                                        <br>
                                        <?php echo e(Carbon\Carbon::parse($customerInv->customer_inv_date_time)->format('h:i A')); ?>

                                    </td>
                                    <td><?php echo e($customerInv->customer->name); ?></td>
                                    <td class="text-<?php echo e($customerInv->is_pending == 1 ? 'danger' : 'success'); ?>"><?php echo e($customerInv->is_pending == 1 ? trans('admin.pending_invoice') : trans('admin.completed_invoice')); ?></td>

                                    <td><?php echo e(App\Models\User::where('id',$customerInv->created_by)->first()->name); ?></td>
                                    <td><?php echo e($customerInv->updated_by ?  App\Models\User::where('id',$customerInv->updated_by)->first()->name : '---'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('customers.show_invoice',['id'=> $customerInv->id])); ?>">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                     <td><?php echo e($customerInv->total_after_discount); ?></td>
                                    <?php
                                        $selectedTranaction = App\Models\Transaction::where('account_num',$customerInv->customer->account_num)
                                        ->where('inv_num',$customerInv->customer_inv_num)->first();
                                    ?>
                                    <td>
                                        <a href="<?php echo e(route('customers.cash_pay_invoice',[ 'inv_num' => $customerInv->customer_inv_num ])); ?>">
                                            <button type="button" <?php echo e($selectedTranaction ? 'disabled' :''); ?>

                                            title="الدفع" class="btn btn-primary btn-sm mx-1" title="إضافة إيصال دفع">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                        </a>
                                     </td>
                                     <td>
                                        <a href="<?php echo e(route('customers.print_invoice',[ 'inv_num' => $customerInv->customer_inv_num ])); ?>">
                                            <button type="button" title="طباعة" class="btn btn-outline-dark btn-sm mx-1">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        </a>
                                     </td>
                                    
                                    
                                    <td>
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($customerInv->return_status == 10): ?>
                                           رد كامل البنود
                                        <?php elseif($customerInv->return_status == 11): ?>
                                            رد جزئي للبنود
                                        <?php elseif(($customerInv->return_status == 10) && ($customerInv->deleted_at != null)): ?>
                                            <?php echo e(trans('admin.deleted_invoice')); ?>



                                        <?php elseif($customerInv->return_status == 12): ?>
                                            فاتورة محذوفة
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                                    </td>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فاتورة-عميل')): ?>
                                    <td>

                                        <a href="<?php echo e(route('customers.create_debit_note',['inv_num' => $customerInv->customer_inv_num])); ?>">
                                            <button type="button" title="إصدار إشعار مدين" <?php echo e($customerInv->return_status == 10 || $customerInv->return_status == 12 ? 'disabled' : ''); ?>   class="btn btn-outline-success btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('customers.create_invoice_return',['inv_num' => $customerInv->customer_inv_num])); ?>">
                                            <button type="button" title="إصدار إشعار دائن" <?php echo e($customerInv->return_status == 10 || $customerInv->return_status == 12 ? 'disabled' : ''); ?>   class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </a>
                                        
                                    </td>
                                    <?php endif; ?>
                                    
                                </tr>

                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="d-flex justify-content-center my-4">
                    <?php echo e($customerInvoices->links()); ?>

                </div>
            </div>
        </div>



    </div>


</div>







<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices/display-invoices.blade.php ENDPATH**/ ?>