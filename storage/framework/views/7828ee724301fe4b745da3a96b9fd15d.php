<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => ''.e(trans('admin.create_category')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $categories = App\Models\Category::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
    ?>
    <div class="col-12 mb-2">
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
    <div class="col-12 mb-2">
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
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='description_ar'><?php echo e(trans('admin.description_ar')); ?></label>
            <textarea wire:model='description_ar' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['description_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.description_ar')); ?>"></textarea>
        </div>
        <?php echo $__env->make('inc.livewire_errors',['property'=>'description_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='description_en'><?php echo e(trans('admin.description_en')); ?></label>
            <textarea wire:model='description_en' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['description_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.description_en')); ?>"></textarea>
        </div>
        <?php echo $__env->make('inc.livewire_errors',['property'=>'description_en'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='parent_id'><?php echo e(trans('admin.parent_category')); ?></label>
            <select wire:model="parent_id" class="form-control">
                <option value=""><?php echo e(trans('admin.select_category')); ?></option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" wire:key="category-<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>

        </div>
        <?php echo $__env->make('inc.livewire_errors',['property'=>'parent_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/categories/add-category.blade.php ENDPATH**/ ?>