<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => ''.e(trans('admin.edit_product')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <?php
        $categories = App\Models\Category::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
        $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    ?>

    <style>
        .add_onother {
            top: 36px;
            left: 0;
        }
    </style>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="form-group">
                <label for="product_codes"><?php echo e(trans('admin.product_code')); ?></label><span class="text-danger">*</span>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" id="codeInput<?php echo e($index); ?>" wire:model="product_codes.<?php echo e($index); ?>" wire:change.live="adjustCode(<?php echo e($index); ?>)" wire:keydown.enter.prevent
                     class="position relative form-control mt-1 mb-3
                     <?php $__errorArgs = ['product_codes.'.$index];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.product_code')); ?>"
                     >
                    <button class="btn btn-primary add_onother"
                    title="<?php echo e(trans('admin.add_code')); ?>" wire:click.prevent="addOnotherCode(<?php echo e($index); ?>)">+</button>
                    <button class="btn btn-danger removeCode" wire:model="removeButtons.<?php echo e($index); ?>" id="remove<?php echo e($index); ?>"
                    title="<?php echo e(trans('admin.remove_code')); ?>" wire:click.prevent="removeCode(<?php echo e($index); ?>)">-</button>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('inc.livewire_errors', ['property' => 'product_codes.'.$index], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="col-3 mb-2">
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
        <div class="col-3 mb-2">
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

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='unit_id'><?php echo e(trans('admin.unit')); ?> </label>
                <select wire:model='unit_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['unit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_unit')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>" wire::key="unit-<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'unit_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='sale_price'><?php echo e(trans('admin.sale_price')); ?></label>
                <input type="number" min="0" step="any" wire:model='sale_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.sale_price')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'sale_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='supplier_id'><?php echo e(trans('admin.supplier')); ?> </label>
                <select wire:model='supplier_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_supplier')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($supplier->id); ?>" wire::key="supplier-<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='category_id'><?php echo e(trans('admin.category')); ?> </label>
                <select wire:model='category_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_category')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" wire::key="cat-<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'category_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-8 mb-2">
            <div class="form-group">
                <label for='description'><?php echo e(trans('admin.description')); ?></label>
                <input type="text" wire:model='description' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.description')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='initial_balance'><?php echo e(trans('admin.initial_balance')); ?></label>
                <input type="number" min="0" step="any" wire:model='initial_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['initial_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.initial_balance')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'initial_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='inventory_balance'><?php echo e(trans('admin.inventory_balance')); ?></label>
                <input type="number" min="0" step="any" wire:model='inventory_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['inventory_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.inventory_balance')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'inventory_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='latest_purchase_price'><?php echo e(trans('admin.latest_purchase_price')); ?></label>
                <input type="number" min="0" step="any" wire:model='latest_purchase_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['latest_purchase_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.latest_purchase_price')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'latest_purchase_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='alert_main_branch'>تنبيه نقص الكمية بالمركز الرئيسي</label>
                <input type="number" min="0" step="any" wire:model='alert_main_branch' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['alert_main_branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الكمية التي يتم بعدها التنبيه بالمركز الرئيسي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'alert_main_branch'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='alert_branch'>تنبية نقص الكمية في الفرع</label>
                <input type="number" min="0" step="any" wire:model='alert_branch' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['alert_branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الكمية التي يتم بعدها التنبيه بالفرع ">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'alert_branch'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='manufactured_date'><?php echo e(trans('admin.manufactured_date')); ?></label>
                <input type="date" wire:model='manufactured_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['manufactured_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.manufactured_date')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'manufactured_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='expiry_date'><?php echo e(trans('admin.expiry_date')); ?></label>
                <input type="date" wire:model='expiry_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.expiry_date')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'expiry_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='import_date'><?php echo e(trans('admin.import_date')); ?></label>
                <input type="date" wire:model='import_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['import_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.import_date')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'import_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='size'><?php echo e(trans('admin.size')); ?></label>
                <input type="number" min="0" step="any" wire:model='size' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.size')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'size'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='max_dose'><?php echo e(trans('admin.max_dose')); ?></label>
                <input type="number" min="0" step="any" wire:model='max_dose' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['max_dose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.max_dose')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'max_dose'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='gtin'><?php echo e(trans('admin.gtin')); ?></label>
                <input type="text" wire:model='gtin' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['gtin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.gtin')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'gtin'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="fraction" <?php echo e($fraction == 1 ? 'checked' : ''); ?>>
                </div>
            </div>
            <input type="text" class="form-control"  value="<?php echo e(trans('admin.fraction_available')); ?>" readonly>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'fraction'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="taxes" <?php echo e($taxes == 1 ? 'checked' : ''); ?>>
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="<?php echo e(trans('admin.taxable')); ?>" readonly>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'taxes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/products/update-product.blade.php ENDPATH**/ ?>