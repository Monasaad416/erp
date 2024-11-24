<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة قيود الأقفال</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-قيد-يومية')): ?>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قيد يومية">
                            <span style="font-weight: bolder; font-size:">إضافة/ تعديل<br>  قيود الإقفال لسنة مالية </span>
                        </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                

                    <div class="my-3">
                     <div class="d-flex my-3">
                        
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3 search_term">
                            <option value="">إختر الفرع</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <select class="form-control w-25 search_term mx-3"  wire:model.live="searchItem">
                            <option>إختر السنة المالية </option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\FinancialYear::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($year->year); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <!--[if BLOCK]><![endif]--><?php if($entries->count() > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">رقم القيد</th>
                                <th scope="col">مدين</th>
                                <th scope="col">مبلغ المدين</th>
                                <th scope="col"> الدائن</th>
                                <th scope="col">مبلغ الدائن</th>
                                <th scope="col">من تاريخ</th>
                                <th scope="col">إلي تاريخ</th>
                                
                                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                    <th scope="col">الفرع</th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    

                                <tr wire:key="entry-<?php echo e($entry->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><span class="text-dark">#<?php echo e($entry->entry_num); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->debitAccount->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->debit_amount); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->creditAccount->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($entry->credit_amount); ?></span> </td>
                                    <td><?php echo e($entry->start_date); ?></td>
                                    <td><?php echo e($entry->end_date); ?></td>
                                    

                                    <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                    <td><?php echo e($entry->branch->name); ?></td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/closing-entries/display-entries.blade.php ENDPATH**/ ?>