<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4"><?php echo e(trans('admin.categories_list')); ?></h4>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-تصنيف')): ?>
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="<?php echo e(trans('admin.create_category')); ?>">
                        <span style="font-weight: bolder; font-size:"><?php echo e(trans('admin.create_category')); ?></span>
                    </button>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($categories->count() > 0): ?>

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="<?php echo e(trans('admin.search_by_category')); ?> " wire:model.live="searchItem">
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
                                <th scope="col"><?php echo e(trans('admin.name')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.parent_category')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.description')); ?></th>
                                <th scope="col"><?php echo e(trans('admin.status')); ?></th>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-تصنيف')): ?>
                                <th scope="col"><?php echo e(trans('admin.edit')); ?></th>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-تصنيف')): ?>
                                <th scope="col"><?php echo e(trans('admin.delete')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr wire:key="category-<?php echo e($category->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><span class="text-dark"><?php echo e($category->name); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($category->parent_id ? $category->parent->name : '---'); ?></span> </td>

                                    
                                    <td><?php echo e($category->description); ?></td>
                                    <td>

                                        <button type="button" class="btn btn-<?php echo e($category->is_active == 1 ? 'success' : 'secondary'); ?> btn-sm mx-1" title="<?php echo e($category->is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('toggleCategory',{id:<?php echo e($category->id); ?>})">
                                            <i class="fa fa-toggle-<?php echo e($category->is_active== 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-تصنيف')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="<?php echo e(trans('admin.edit')); ?>"
                                            data-toggle="modal"
                                            
                                            wire:click="$dispatch('updateCategory',{id:<?php echo e($category->id); ?>})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>    
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('حذف-تصنيف')): ?>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            
                                            title=<?php echo e(trans('admin.delete_category')); ?>

                                            wire:click="$dispatch('deleteCategory',{id:<?php echo e($category->id); ?>})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <div class="d-flex justify-content-center my-4">
                    <?php echo e($categories->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/categories/display-categories.blade.php ENDPATH**/ ?>