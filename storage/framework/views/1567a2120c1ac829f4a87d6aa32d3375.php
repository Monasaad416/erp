<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">التحويلات بين المخازن</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-تحويل-مخزن')): ?>
                    <a href="<?php echo e(route('stores.create_transaction')); ?>" class="text-white">
                        <button type="button" class="btn bg-gradient-cyan" title="إضافة تحويل">
                            <span style="font-weight: bolder; font-size:">إضافة تحويل</span>
                        </button>
                    </a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">
                 <div class="d-flex my-3">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم التحويل" wire:model.live="searchItem">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم الحساب " wire:model.live="accountNum">
                    <select class="form-control ml-3" wire:model.live="branch_id">
                        <option value=" >إختر الفرع</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    </select>
                    <select class="form-control ml-3" wire:model.live="bank_id">
                        <option value="">إختر البنك</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

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
                <!--[if BLOCK]><![endif]--><?php if($stores_transactions->count() > 0): ?>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>رقم الحركة</th>
                                <th>تاريخ الحركة</th>
                                <th>من مخزن</th>
                                <th>إلي مخزن</th>
                                
                                <td>بنود التحويل</td>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قبول-تحويل-مخزن')): ?>
                                <td>قبول التحويل</td>
                                <?php endif; ?>

                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-تحويل-مخزن')): ?>
                                <td>تعديل</td>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-تحويل-مخزن')): ?>
                                <td>حذف</td>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if($stores_transactions->count() > 0 ): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stores_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($transaction->trans_num); ?></td>
                                        <td>
                                            <?php echo e(Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y ')); ?>

                                            <br>
                                            <?php echo e(Carbon\Carbon::parse($transaction->created_at)->format('h:i A')); ?>

                                        </td>
                                        <td><?php echo e($transaction->fromStore->name); ?></td>
                                        <td><?php echo e($transaction->toStore->name); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('stores.transactions.items',['trans_num' => $transaction->trans_num ])); ?>">
                                                <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="بنود التحويل">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <?php
                                            $storeFromBranchId = App\Models\Store::where('id',$transaction->from_store_id)->first()->branch_id;
                                            $storeToBranchId = App\Models\Store::where('id',$transaction->to_store_id)->first()->branch_id;
                                            //dd($storeToBranchId);
                                        ?>
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
                                        <td>
                                            <a href="<?php echo e(route('stores.transactions.edit',['trans_num' => $transaction->trans_num ])); ?>">
                                                <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل التحويل">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                                data-toggle="modal"
                                                wire:click="$dispatch('deleteInvTransaction',{transaction_id:<?php echo e($transaction->id); ?>})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        
                                        
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
                    <?php echo e($stores_transactions->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores-transactions/display-stores-transactions.blade.php ENDPATH**/ ?>