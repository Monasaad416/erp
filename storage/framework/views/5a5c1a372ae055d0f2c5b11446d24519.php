<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة موازين المراجعة</h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-ميزان-مراجعة')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة ميزان مراجعة">
                        <span style="font-weight: bolder; font-size:">إضافة ميزان مراجعة</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <div class="form-group w-25 mx-1">
                            <label for="from_date">رقم الحساب :</label>
                            <input type="text" class="form-control " placeholder="بحث بالحساب" wire:model.live="searchItem">
                        </div>
                        <div class="form-group w-25 mx-1">
                            <label for="from_date">الفرع :</label>
                            <select wire:model.live="branch_id" class="form-control">
                                <option value="">إختر الفرع</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>

                        </div>


                            <div class="form-group w-25 mx-1">
                                <label for="from_date">من تاريخ:</label>
                                <input type="date" id="from_date" class="form-control ml-2" wire:model.live="from_date">
                            </div>



                            <div class="form-group w-25 mx-1">
                                <label for="from_date">إلي تاريخ:</label>
                                <input type="date" id="to_date" class="form-control ml-2"  wire:model.live="to_date">
                            </div>
                        </div>


                <!--[if BLOCK]><![endif]--><?php if($balances->count() > 0): ?>
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                        <?php
                            $debitBalance = 0;
                            $creditBalance = 0;
                            $totalBalance = 0;

                        ?>


                </table>
                <table class="table table-bordered mt-3">
                    <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                    <th colspan="2">اول الفترة</th>

                                    <th colspan="2">خلال الفترة</th>

                                    <th colspan="2">الرصيد الختامي</th>

                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>


                                </tr>
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">الحساب</th>
                                    <th scope="col">رقم الحساب</th>
                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col"> الفرع</th>
                                    <th scope="col"> من تاريخ</th>
                                    <th scope="col"> إلي تاريخ</th>
                                </tr>
                            </thead>
                    <tbody>
                           <?php
                                $debitBalance = 0;
                                $creditBalance = 0;
                            ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $balances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php

                                $debitBalance += $balance->debit;
                                $creditBalance += $balance->credit;
                            ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($balance->name); ?> </td>
                                <td><?php echo e($balance->account_num); ?> </td>

                                <td style="background-color: rgb(189, 236, 189)">0</td>
                                <td style="background-color: rgb(235, 192, 192)">0</td>

                                <td style="background-color: rgb(189, 236, 189)"><?php echo e($balance->debit); ?></td>
                                <td style="background-color: rgb(235, 192, 192)"><?php echo e($balance->credit); ?></td>



                                <td style="background-color: <?php echo e($balance->debit > $balance->credit ? 'rgb(189, 236, 189)' :'rgb(235, 192, 192)'); ?>"><?php echo e($balance->debit > $balance->credit ?  ($balance->debit - $balance->credit) : 0); ?> </td>
                                <td style="background-color: <?php echo e($balance->debit > $balance->credit ? 'rgb(189, 236, 189)' :'rgb(235, 192, 192)'); ?>"><?php echo e($balance->credit > $balance->debit ?  ($balance->credit - $balance->debit) : 0); ?> </td>


                                <td><?php echo e($balance->branch->name); ?></td>
                                <td><?php echo e($balance->start_date); ?></td>
                                <td><?php echo e($balance->end_date); ?></td>


                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <tr>
                            <td colspan="2">الإجمالي</td>
                            <td></td>
                            <td style="background-color: rgb(189, 236, 189)">0</td>
                            <td style="background-color: rgb(235, 192, 192)">0</td>

                            <td style="background-color: rgb(189, 236, 189)"><?php echo e($debitBalance); ?></td>
                            <td style="background-color: rgb(235, 192, 192)"><?php echo e($creditBalance); ?></td>

                                    <td style="background-color: rgb(189, 236, 189)"><?php echo e($debitBalance); ?></td>
                            <td style="background-color: rgb(235, 192, 192)"><?php echo e($creditBalance); ?></td>
                        </tr>

                    </tbody>
                </table>
                
                <?php else: ?>
                     <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



            </div>

        </div>
    </div>

</div>





<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/trail-balances-before/display-trail-balances-before.blade.php ENDPATH**/ ?>