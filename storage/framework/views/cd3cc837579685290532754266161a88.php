<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة قيود اليومية</h4>
                    
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($entries->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث برقم القيد " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">رقم القيد</th>
                                <th scope="col">تاريخ القيد</th>
                                <th scope="col">مدين</th>
                                <th scope="col">مبلغ المدين</th>
                                <th scope="col"> الدائن</th>
                                <th scope="col">مبلغ الدائن</th>
                                <th scope="col"><?php echo e(trans('admin.description')); ?></th>
                                
                                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                    <th scope="col">الفرع</th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <th scope="col"> انشاء  من</th>
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $type='';
                                    $name='';
                                    if( $entry->jounralable_type == "App\Models\SupplierInvoice"){
                                        $type ="فاتورة مورد";
                                        $name = App\Models\SupplierInvoice::withTrashed()->where('id',$entry->jounralable_id)->first()->supp_inv_num;

                                    }elseif( $entry->jounralable_type == "App\Models\CustomerInvoice"){
                                        $type ="فاتورة عميل";
                                        $name = App\Models\CustomerInvoice::withTrashed()->where('id',$entry->jounralable_id)->first()->customer_inv_num;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Transaction"){
                                         $trans = App\Models\Transaction::where('id',$entry->jounralable_id)->first();
                                        $type ="إيصال ".$trans->state;
                                        $name='رقم '.$trans->serial_num;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Salary"){
                                        $type ="راتب موظف";
                                        $salary = App\Models\Salary::where('id',$entry->jounralable_id)->first();
                                        $name = $entry->debitAccount->name;
                                    }
                                   elseif( $entry->jounralable_type == "App\Models\Asset"){
                                       $asset = App\Models\Asset::where('id',$entry->jounralable_id)->first();
                                        $type ="شراء أصل ثابت ";
                                        $name = $asset->name_ar;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\CustomerReturn"){
                                        $type ="مردودات  مبيعات -إشعار دائن";
                                        //dd(App\Models\CustomerReturn::where('id',$entry->jounralable_id)->first());
                                        $name = App\Models\CustomerReturn::where('id',$entry->jounralable_id)->first()->serial_num ?? null;

                                    }
                                    elseif( $entry->jounralable_type == "App\Models\CustomerDebitNote"){
                                        $type = "إشعار مدين ";
                                        $name = App\Models\CustomerDebitNote::where('id',$entry->jounralable_id)->first()->serial_num ?? null;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Capital"){
                                        $capital = App\Models\Capital::where('id',$entry->jounralable_id)->first();
                                        
                                        $type = "إضافة رأس مال للشريك";
                                        $name = App\Models\Partner::where('id',$capital->partner_id)->first()->name_ar ?? null;
                                         
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\PartnerWithdrawal"){
                                        $withdrawal = App\Models\PartnerWithdrawal::where('id',$entry->jounralable_id)->first();
                        
                                        $type ="إضافة مسحوبات للشريك";
                                        $name = App\Models\Partner::where('id',$withdrawal->partner_id)->first()->name_ar ?? null;
                                    }
                                ?>

                                <tr wire:key="entry-<?php echo e($entry->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><span class="text-dark">#<?php echo e($entry->entry_num); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->created_at); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->debitAccount->name ?? null); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->debit_amount); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->creditAccount->name ?? null); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->credit_amount); ?></span> </td>
                                    <td><?php echo e($entry->description); ?></td>
                                    

                                    <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                    <td><?php echo e($entry->branch->name); ?></td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <td>
                                        <?php echo e($type ?? null); ?>

                                        <br>
                                        <span class="text-danger"><?php echo e($name ??null); ?></span>
                                    </td>
                                    <td><?php echo e(App\Models\User::where('id',$entry->created_by)->first()->name ?? null); ?></td>
                                    <td><?php echo e(App\Models\User::where('id',$entry->updated_by)->first()->name ?? null); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($entries->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/journal-entries/display-entries.blade.php ENDPATH**/ ?>