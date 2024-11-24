<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => ''.e(trans('admin.edit_account')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $account_types = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();

        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();

        $accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->where('is_parent',1)->get();
    ?>
    <div class="row">
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='name_ar'><?php echo e(trans('admin.name_ar')); ?></label>
                <input type="text" wire:model='name_ar' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.name_ar')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'name_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='name_en'><?php echo e(trans('admin.name_en')); ?></label>
                <input type="text" wire:model='name_en' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.name_en')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'name_en'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>


        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='account_num'><?php echo e(trans('admin.account_num')); ?></label>
                <input type="number" min=0 wire:model='account_num'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.account_num')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='start_balance'><?php echo e(trans('admin.start_balance')); ?></label>
                <input type="number" min="0" step="any" wire:model='start_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['start_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.start_balance')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'start_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='current_balance'><?php echo e(trans('admin.current_balance')); ?></label>
                <input type="number" min="0" step="any" wire:model='current_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['current_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.current_balance')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'current_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='account_type_id'><?php echo e(trans('admin.account_type')); ?> </label>
                <select wire:model='account_type_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_account_type')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account_type->id); ?>" wire::key="account_type-<?php echo e($account_type->id); ?>"><?php echo e($account_type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='parent_id'><?php echo e(trans('admin.parent_account')); ?> </label>
                <select wire:model='parent_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_parent_account')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>" wire::key="account-<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'parent_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='branch_id'><?php echo e(trans('admin.branch')); ?> </label>
                <select wire:model='branch_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_branch')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" wire::key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='notes'><?php echo e(trans('admin.notes')); ?></label>
                <input type="text" wire:model='notes' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.notes')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'notes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>



        <div class="form-group clearfix">
            <div class="d-inline">
                <input type="checkbox" <?php echo e($is_parent == 1 ? 'checked' : ''); ?> wire:model="is_parent">
                <label>
                <?php echo e(trans('admin.is_parent_account')); ?>

                </label>
                <br>
                <small class="text-muted">
                    <?php echo e(trans('admin.is_parent_example')); ?>

                </small>
            </div>
        </div>
            
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f)): ?>
<?php $attributes = $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f; ?>
<?php unset($__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f)): ?>
<?php $component = $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f; ?>
<?php unset($__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/accounts/update-account.blade.php ENDPATH**/ ?>