<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => 'إضافة  ميزان مراجعة'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
    ?>
    <div class="row">
        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch_id'> الفرع</label>
                <select wire:model="branch_id" class="form-control">
                    <option value="">إختر الفرع</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6); ?> mb-2">
            <div class="form-group">
                <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='start_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.start_date')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'start_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6); ?> mb-2">
            <div class="form-group">
                <label for='end_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='end_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.end_date')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'end_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/financial-positions/add-financial-position.blade.php ENDPATH**/ ?>