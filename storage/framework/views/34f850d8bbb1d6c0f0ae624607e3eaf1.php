<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5>دفتر الاستاذ العام - <span class="text-danger"><?php echo e($account_name); ?>  </span>  </h5>
                    <hr>
                    <h6> رقم الحساب المالي  - <span class="text-danger"> <?php echo e($account_num); ?></span>  </h6>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($ledgers->count() > 0): ?>


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">المرجع</th>
                                <th scope="col">مدين</th>
                                <th scope="col"> دائن</th>
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr wire:key="entry-<?php echo e($ledger->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <!--[if BLOCK]><![endif]--><?php if($ledger->type == 'journal_entry'): ?>
                                        <td><?php echo e($ledger->JournalEntry ? 'قيد يومية# '.$ledger->JournalEntry->entry_num  : '---'); ?></td>
                                    <?php elseif($ledger->type == 'closing_entry'): ?>
                                        <td><?php echo e('قيد إغلاق#'.$ledger->closingEntry->entry_num); ?></td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <td><span class="text-dark"><?php echo e($ledger->debit_amount ?  $ledger->debit_amount : 0.00); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($ledger->credit_amount ? $ledger->credit_amount : 0.00); ?></span> </td>
                                    <td><?php echo e(App\Models\User::where('id',$ledger->created_by)->first()->name ?? null); ?></td>
                                    <td><?php echo e(App\Models\User::where('id',$ledger->updated_by)->first()->name ?? null); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($ledgers->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/ledgers/show-ledger.blade.php ENDPATH**/ ?>