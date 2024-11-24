<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => 'تعديل المخزون'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="row">
         <div class="col-6 mb-2">
            <div class="form-group">
                <label for='latest_purchase_price'>أخر سعر شراء</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='latest_purchase_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['latest_purchase_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "أخر سعر شراء">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'latest_purchase_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='main_branch_inv'>رصيد المخزن الرئيسي</label>
                <input type="number" min="0" step="any" wire:model='main_branch_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['main_branch_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون المخزن الرئيسي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'main_branch_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch1_inv'>رصيد فرع1 </label>
                <input type="number" min="0" step="any" wire:model='branch1_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch1_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 1">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch1_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch2_inv'>رصيد فرع2 </label>
                <input type="number" min="0" step="any" wire:model='branch2_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch2_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 2">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch2_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch3_inv'>رصيد فرع3 </label>
                <input type="number" min="0" step="any" wire:model='branch3_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch3_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 3">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch3_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch4_inv'>رصيد فرع4 </label>
                <input type="number" min="0" step="any" wire:model='branch4_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch4_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 4">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch4_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch5_inv'>رصيد فرع5 </label>
                <input type="number" min="0" step="any" wire:model='branch5_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch5_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 5">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch5_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch6_inv'>رصيد فرع6 </label>
                <input type="number" min="0" step="any" wire:model='branch6_inv' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch6_inv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "مخزون فرع 6">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch6_inv'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/inventories/update-inventory.blade.php ENDPATH**/ ?>