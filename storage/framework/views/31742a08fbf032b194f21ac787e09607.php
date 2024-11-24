<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title"><?php echo e(trans('admin.users_list')); ?> </h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-موظف')): ?>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_user')); ?>">
                            <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_user')); ?></span>
                        </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($users->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25" placeholder="<?php echo e(trans('admin.search_by_name_email')); ?>" wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th><?php echo e(trans('admin.name')); ?></th>
                                <th>رقم حساب الراتب</th>
                                <th>رقم حساب السلف</th>
                                <th> <?php echo e(trans('admin.email')); ?></th>
                                <th><?php echo e(trans('admin.role')); ?></th>
                                <th><?php echo e(trans('admin.address')); ?></th>
                                <th><?php echo e(trans('admin.branch')); ?></th>
                                <th>الرواتب</th>
                                 <th>الورديات</th>
                                <th><?php echo e(trans('admin.show')); ?></th>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-موظف')): ?>
                                    <th><?php echo e(trans('admin.edit')); ?></th>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-موظف')): ?>
                                <th><?php echo e(trans('admin.delete')); ?></th>
                                <?php endif; ?> 
                            </tr>
                        </thead>
                        <tbody>
                     <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->account_num); ?></td>
                            <td><?php echo e($user->advance_payment_account_num); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->roles_name); ?></td>
                            <td><?php echo e($user->address); ?></td>
                            <td><?php echo e($user->branch->name); ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-info btn-sm" title="إضافة الراتب">
                                    <a href="<?php echo e(route('users.salaries.create',['user_id' => $user->id])); ?>" >
                                        <span style="font-weight: bolder; font-size:"> <i class="far fa-money-bill-alt"></i></span>
                                    </a>
                                </button>   
                            </td>
                            <td>
                                 <button type="button" class="btn btn-outline-secondary btn-sm" title="إضافة الورديات">
                                    <a href="<?php echo e(route('users.shifts.create',['user_id' => $user->id])); ?>" >
                                        <span style="font-weight: bolder; font-size:"><i class="fas fa-sync-alt"></i></span>  
                                    </a>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm" title="بيانات الموظف"
                                    data-toggle="modal"
                                    wire:click="$dispatch('showUser',{id:<?php echo e($user->id); ?>})">
                                    <i class="far fa-eye"></i>
                                </button>
                            </td>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-موظف')): ?>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                        data-toggle="modal"
                                        wire:click="$dispatch('editUser',{id:<?php echo e($user->id); ?>})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-موظف')): ?>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="<?php echo e(trans('admin.delete')); ?>"
                                    data-toggle="modal"
                                    wire:click="$dispatch('deleteUser',{id:<?php echo e($user->id); ?>})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center">لا يوجد موظفين للعرض</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($users->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/users/display-users.blade.php ENDPATH**/ ?>