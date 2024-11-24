<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.accounts_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-حساب-مالي')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_account_type')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_account')); ?></span>
                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                    <div class="d-flex my-3">
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3">
                            <option value="">إختر الفرع</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <input type="text" class="form-control w-25 mx-3" placeholder="<?php echo e(trans('admin.search_by_account')); ?> " wire:model.live="searchItem">

                        <input type="text" class="form-control w-25 mx-3" placeholder="بحث بالمستوي" wire:model.live="level">
                    </div>
                <!--[if BLOCK]><![endif]--><?php if($accounts->count() > 0): ?>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?php echo e(trans('admin.name')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.account_num')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.start_balance')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.current_balance')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.branch')); ?></th>
                                <th scope="col">القائمة</th>
                                <th scope="col"><?php echo e(trans('admin.parent_account')); ?></th>
                                <th scope="col">المستوي</th>
                                 <th scope="col">نوع  الحساب</th>
                                <th scope="col">طبيعة الحساب</th>
                                <th scope="col"><?php echo e(trans('admin.status')); ?></th>
                                <th scope="col">دفتر الاستاذ العام</th>
                                <th scope="col"> كشف حساب</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تفاصيل-حساب-مالي')): ?>
                                    <th scope="col"><?php echo e(trans('admin.edit')); ?></th>
                                    <th scope="col"><?php echo e(trans('admin.delete')); ?></th>
                                    <th scope="col">إسترجاع</th>
                                    <th scope="col">حذف نهائي</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $bg='';
                                if($account->level == 1 ) {
                                    $bg = '#add0f5';
                                }elseif($account->level == 2 ) {
                                    $bg = '#f2eecd';
                                }elseif($account->level == 3 ) {
                                    $bg = '#eff3f8';
                                }elseif($account->level == 4 ) {
                                    $bg = '#e2fae0';
                                }elseif($account->level == 5 ) {
                                    $bg = '#f1e4ea';
                                }
                            ?>
                                <tr wire:key="account_type-<?php echo e($account->id); ?>" style="background-color: <?php echo e($bg); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><span class="text-dark"><?php echo e($account->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->account_num); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->start_balance); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->current_balance); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->branch->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->list); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->parent->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->level); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($account->accountType->name); ?></span> </td>
                                    <td><span class="text-<?php echo e($account->nature == 'مدين' ? 'green' : ($account->nature == 'دائن' ? 'red' : 'blue')); ?>">
    <?php echo e($account->nature); ?>

</span></td>
                                    <td>

                                        <button type="button" class="btn btn-<?php echo e($account->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($account->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>" data-toggle="modal"
                                            wire:click="$dispatch('toggleAccount',{id:<?php echo e($account->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($account->is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>

                                    </td>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تفاصيل-حساب-مالي')): ?>
                                    <td>

                                        <a href="<?php echo e(route('ledgers.show',['account_id'=> $account->id])); ?>">
                                            <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                                <i class="fas fa-book"></i>
                                            </button>
                                        </a>

                                    </td>

                                    <td>
                                        <a href="<?php echo e(route('account_statements.show',['account_id'=> $account->id])); ?>">
                                            <button type="button" class="btn btn-outline-success btn-sm mx-1" title="<?php echo e(trans('admin.show')); ?>">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <?php endif; ?>


                                    <td>

                                        

                                        <button type="button" <?php echo e($account->trashed() ? 'disabled' : ''); ?> class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>" data-toggle="modal"
                                            wire:click="$dispatch('updateAccount',{id:<?php echo e($account->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        
                                    </td>

                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($account->id >= 1 && $account->id < 596): ?>
                                            <i class="fas fa-lock text-muted"></i>
                                        <?php else: ?>

                                        <button type="button" <?php echo e($account->trashed()  ? 'disabled' : ''); ?> class="btn btn-outline-danger btn-sm mx-1" data-toggle="modal"
                                            title=<?php echo e(trans('admin.delete_account_type')); ?>

                                            wire:click="$dispatch('deleteAccount',{id:<?php echo e($account->id); ?>})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                   <td>
                                        <!--[if BLOCK]><![endif]--><?php if($account->id >= 1 && $account->id < 596): ?>
                                            <i class="fas fa-lock text-muted"></i>
                                        <?php else: ?>
                                        <button type="button" <?php echo e($account->trashed()  ? '' : 'disabled'); ?> class="btn btn-outline-success btn-sm mx-1" title="إستعادة الحساب" data-toggle="modal"
                                            wire:click="dispatch('restoreAccount',{id:<?php echo e($account->id); ?>})">
                                            <i class="fa fa-trash-restore"></i>

                                        </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>

                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($account->id >= 1 && $account->id < 596): ?>
                                            <i class="fas fa-lock text-muted"></i>
                                        <?php else: ?>
                                        <button type="button" <?php echo e($account->deleted_at ? '' : 'disabled'); ?> class="btn btn-outline-dark btn-sm mx-1" title="حذف نهائي" data-toggle="modal"
                                            wire:click="$dispatch('destroyAccount',{id:<?php echo e($account->id); ?>})">
                                            <i class="fa fa-trash-alt"></i>

                                        </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($accounts->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/accounts/display-accounts.blade.php ENDPATH**/ ?>