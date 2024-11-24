<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => ''.e(trans('admin.create_shift_type')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="row">
        <div class="col-12 mb-2">
            <div class="form-group">
                <label for="type"><?php echo e(trans('admin.select_shift_type')); ?></label><span class="text-danger">*</span>
                <select wire:model="type" class="form-control mt-1 mb-3 <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option><?php echo e(trans('admin.select_shift_type')); ?></option>
                    <option value="1"><?php echo e(trans('admin.morning_shift_8')); ?></option>
                    <option value="2"><?php echo e(trans('admin.evening_shift_8')); ?></option>
                    <option value="3"><?php echo e(trans('admin.night_shift_8')); ?></option>
                    <option value="4"><?php echo e(trans('admin.morning_shift_12')); ?></option>
                    <option value="5"><?php echo e(trans('admin.night_shift_12')); ?></option>
                </select>
                <?php echo $__env->make('inc.livewire_errors', ['property' => 'type'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
    <div class="row">    
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='shift_start'><?php echo e(trans('admin.shift_start')); ?></label>
                <input type="time" wire:model='start' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['shift_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.shift_start')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'start'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='shift_end'><?php echo e(trans('admin.shift_end')); ?></label>
                <input type="time" wire:model='end' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['shift_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.shift_end')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'end'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='total_hours'><?php echo e(trans('admin.total_hours')); ?></label>
                <input type="number" wire:model='total_hours' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['total_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.total_hours')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'total_hours'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/shifts-types/add-shift-type.blade.php ENDPATH**/ ?>