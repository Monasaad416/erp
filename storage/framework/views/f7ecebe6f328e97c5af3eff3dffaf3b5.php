<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => ''.e(trans('admin.create_branch')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="row">
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch_num'><?php echo e(trans('admin.branch_num')); ?></label><span class="text-danger"> *</span>
                <input type="number" min="0" wire:model='branch_num' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.branch_num')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='name_ar'><?php echo e(trans('admin.name_ar')); ?></label><span class="text-danger"> *</span>
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
        <div class="col-4 mb-2">
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
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='email'><?php echo e(trans('admin.email')); ?></label>
                <input type="email" wire:model='email' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.email')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='gln'><?php echo e(trans('admin.gln')); ?></label>
                <input type="text" wire:model='gln' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['gln'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.gln')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'gln'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='phone'><?php echo e(trans('admin.phone')); ?></label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.phone')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'phone'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='building_number'>رقم المبني</label><span class="text-danger"> *</span>
                <input type="text" wire:model='building_number' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['building_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "رقم المبني">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'building_number'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='plot_identification'>الرقم الفرعي</label><span class="text-danger"> *</span>
                <input type="text" wire:model='plot_identification' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['plot_identification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الرقم الفرعي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'plot_identification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='postal_code'>الرقم البريدي</label><span class="text-danger"> *</span>
                <input type="text" wire:model='postal_code' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الرقم البريدي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'postal_code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='street_name_ar'>إسم الشارع باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='street_name_ar' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['street_name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم الشارع باللغة العربية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'street_name_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='street_name_en'>إسم الشارع باللغة الإنجليزية</label>
                <input wire:model='street_name_en' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['street_name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم الشارع باللغة الإنجليزية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'street_name_en'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='region_ar'>إسم المنطقة باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='region_ar' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['region_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم المنطقة باللغة العربية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'region_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='region_en'>إسم المنطقة باللغة الإنجليزية</label>
                <input wire:model='region_en' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['region_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم الشارع باللغة الإنجليزية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'region_en'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='city_ar'>إسم المدينة باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='city_ar' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['city_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم المدينة باللغة العربية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'city_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='city_en'>إسم المدينة باللغة الإنجليزية</label>
                <input wire:model='city_en' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['city_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم المدينة باللغة الإنجليزية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'city_en'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

    </div>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be)): ?>
<?php $attributes = $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be; ?>
<?php unset($__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be)): ?>
<?php $component = $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be; ?>
<?php unset($__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/branches/add-branch.blade.php ENDPATH**/ ?>