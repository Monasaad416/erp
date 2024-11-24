<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.suppliers_invoices_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-فاتورة-مورد')): ?>
                    <a href="<?php echo e(route('suppliers.create_invoice')); ?>" class="text-white">
                        <button type="button" class="btn bg-gradient-cyan" title="إضافة فاتورة">
                            <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_supplier_invoice')); ?></span>
                        </button>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_supp_inv_num')); ?>" wire:model.live="searchItem">
                        <select class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_supp_inv_completed')); ?>" wire:model.live="pending_status">
                            <option value="" ><?php echo e(trans('admin.select_status')); ?></option>
                            <option value="1" <?php echo e($pending_status === 1 ? 'selected':''); ?>><?php echo e(trans('admin.pending_invoice')); ?></option>
                            <option value="0" <?php echo e($pending_status === 0 ? 'selected':''); ?>><?php echo e(trans('admin.completed_invoice')); ?></option>
                        </select>
                        <select class="form-control mx-1" placeholder="<?php echo e(trans('admin.search_by_supp_inv_completed')); ?>" wire:model.live="return_status">
                            <option value="" ><?php echo e(trans('admin.select_status')); ?></option>
                            <option value="10" <?php echo e($return_status == 10 ? 'selected':''); ?>><?php echo e(trans('admin.return_invoice')); ?></option>
                            <option value="11" <?php echo e($return_status == 11 ? 'selected':''); ?>><?php echo e(trans('admin.return_item')); ?></option>
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

                <!--[if BLOCK]><![endif]--><?php if($suppInvoices->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                            font-size: 14px;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo e(trans('admin.inv_num')); ?></th>
                                <th><?php echo e(trans('admin.inv_date_time')); ?></th>
                                <th><?php echo e(trans('admin.supplier_name')); ?></th>
                                <th>إجمالي المبلغ</th>
                                <th>ماتم سداده</th>
                                <th><?php echo e(trans('admin.is_pending')); ?></th>
                                
                                <th><?php echo e(trans('admin.created_by')); ?></th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تفاصيل-فاتورة-مورد')): ?>
                                <th><?php echo e(trans('admin.show')); ?></th>
                                <?php endif; ?>
                                <th>حالة الفاتورة</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اصدار-ايصال-صرف')): ?>
                                <th>إصدار ايصال صرف</th>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-شيك')): ?>
                                <th>إصدار شيك </th>
                                <?php endif; ?>
                                
                                <th>مردودات</th>

                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مردودات-فاتورة-مورد')): ?>
                                <th>رد الفاتورة</th>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فاتورة-مورد')): ?>
                                <th><?php echo e(trans('admin.edit')); ?></th>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-فاتورة-مورد')): ?>
                                <th><?php echo e(trans('admin.delete')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suppInv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($suppInv->supp_inv_num); ?></td>
                                    <td>
                                        <?php echo e(Carbon\Carbon::parse($suppInv->created_at)->format('d-m-Y ')); ?>

                                        <br>
                                        <?php echo e(Carbon\Carbon::parse($suppInv->created_at)->format('h:i A')); ?>

                                    </td>
                                    <td><?php echo e($suppInv->supplier->name); ?></td>
                                    <td><?php echo e($suppInv->total_after_discount); ?></td>
                                    <td><?php echo e($suppInv->paid_amount); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($suppInv->is_pending == 1 ? 'danger' : 'success'); ?>">
                                            <?php echo e($suppInv->is_pending == 1 ? trans('admin.pending_invoice') : trans('admin.completed_invoice')); ?>

                                        </span>
                                    </td>
                                    
                                    <td><?php echo e(App\Models\User::where('id',$suppInv->created_by)->first()->name); ?></td>

                                    <td>
                                        <a href="<?php echo e(route('suppliers.show_invoice',['id'=> $suppInv->id])); ?>">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>

                                    
                                    
                                    <?php
                                        $status ='';$label='';
                                        if($suppInv->status == 1 ) {
                                            $status = 'غير مسددة';
                                            $label = 'danger';

                                        }elseif($suppInv->status == 2 ) {
                                            $status = 'مسددة ';
                                            $label = 'success';
                                        }
                                        elseif($suppInv->status == 3 ) {
                                            $status = ' مسددة جزئيا';
                                            $label = 'info';
                                        }
                                        elseif($suppInv->status == 4 ) {
                                            $status = 'مستحقة';
                                            $label = 'indigo';
                                        }
                                        elseif($suppInv->status == 5 ) {
                                            $status = 'مسددة مقدما';
                                            $label = 'warning';
                                        }
                                    ?>
                                    <td>
                                        <span class="badge badge-<?php echo e($label); ?>"><?php echo e($status); ?></span>
                                    </td>

                                    <?php
                                        $total = $suppInv->total_after_discount;
                                        $paid = $suppInv->paid_amount;
                                    ?>
                                    <td>
                                        <a href="<?php echo e(route('create_exchange_reciept',['inv_num'=>$suppInv->supp_inv_num])); ?>">
                                            <button type="button" <?php echo e($suppInv->status == 2 || $suppInv->return_status == 10 ? 'disabled' : ''); ?> title="إضافة إيصال دفع" class="btn btn-outline-primary btn-sm mx-1" title="إضافة إيصال دفع">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                        </a>
                                    </td>
                                   


                                    <td>
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($suppInv->return_status == 10): ?>
                                            <?php echo e(trans('admin.return_invoice')); ?>

                                        <?php elseif($suppInv->return_status == 11): ?>
                                            <?php echo e(trans('admin.returned')); ?>

                                        <?php elseif($suppInv->return_status == 12): ?>
                                            <?php echo e(trans('admin.partially_returned')); ?>

                                        <?php elseif($suppInv->deleted_at !== null): ?>
                                            <?php echo e(trans('admin.deleted_invoice')); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-مردودات-فاتورة-مورد')): ?>

                                    <td>
                                        <a href="#" class="modal-effect"
                                            data-toggle="modal"
                                            wire:click="$dispatch('returnInvItems',{id:<?php echo e($suppInv->id); ?>})" title="<?php echo e(trans("admin.return_all_invoice")); ?>">
                                            <button class="btn " <?php echo e($suppInv->return_status == 10 ? 'disabled' : ''); ?>>
                                                <i class="fas fa-undo-alt text-danger"></i>
                                            </button>
                                        </a>
                                        

                                    </td>
                                    <?php endif; ?>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-فاتورة-مورد')): ?>
                                    <td>

                                        <a href="<?php echo e(route('suppliers.edit_invoice',['inv_num'=>$suppInv->supp_inv_num])); ?>">
                                            <button type="button" <?php echo e($suppInv->return_status == 10 ? 'disabled' : ''); ?> title="<?php echo e(trans('admin.edit')); ?>" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </a>
                                        
                                    </td>
                                      <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-فاتورة-مورد')): ?>
                                    <td>
                                        <button type="button" <?php echo e($suppInv->return_status == 10 ? 'disabled' : ''); ?> class="btn btn-outline-danger btn-sm mx-1"  title="<?php echo e(trans('admin.delete')); ?>"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSuppInvoice',{id:<?php echo e($suppInv->id); ?>})">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
                    <?php echo e($suppInvoices->links()); ?>

                </div>
            </div>
        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/supplier-invoices/display-invoices.blade.php ENDPATH**/ ?>