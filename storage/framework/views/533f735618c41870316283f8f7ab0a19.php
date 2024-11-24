<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => 'إضافة أصل ثابت'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                <label for='life_span'>العمر الإفتراضي بالسنوات</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='life_span' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['life_span'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "العمر الإفتراضي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'life_span'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='purchase_price'>سعر الشراء</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='purchase_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['purchase_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "سعر الشراء">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'purchase_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='scrap_price'> قيمة الخردة</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='scrap_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['scrap_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "سعر البيع خردة">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'scrap_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='purchase_date'>تاريخ الشراء</label><span class="text-danger"> *</span>
                <input type="date" id="date"  wire:model='purchase_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['purchase_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "تاريخ الشراء">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'purchase_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for='branch_id'>الفرع</label>

                    <select wire:model='branch_id' style="height: 45px;" class='form-control pb-3 <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                        <option value="">إختر الفرع</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>

                </div>
                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php else: ?>
        <?php
            $branch_id = Auth::user()->branch_id;
        ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6); ?> mb-2">
            <div class="form-group">
                <label for='supplier_id'><?php echo e(trans('admin.select_supplier')); ?></label><span class="text-danger"> *</span>
                <select wire:model='supplier_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_supplier')); ?></option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php
            $mainAssetsAccount = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('name_ar',"الاصول الغير متداولة")->first()->account_num;
            $assetsAccounts = [1111,1121 ,1131,1141,1151];
            $accounts =  App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('account_num',$assetsAccounts)->get();
        //     foreach($accounts as $account ){
        //         $childAccounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('parent_id',$account->id)->get();
        //     }
        //     // if(Auth::user()->roles_name == 'سوبر-ادمن'){
        //     //     $child_accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('account_num', 'like', '11%')->get();
        //     // } else {
        //     //     $accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('account_num', 'like', '11%')
        //     //     ->where('branch_id' , Auth::user()->branch_id)->get();
        //     // }
        ?>
        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6); ?> mb-2">
            <div class="form-group">
                <label for='parent_parent_account_id'>إختر الحساب الأب التابع له  الأصل</label><span class="text-danger"> *</span>
                <select wire:model='parent_parent_account_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['parent_parent_account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">إختر الحساب الأب</option>

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'parent_parent_account_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>


        <div class="col-<?php echo e($payment_type == "by_check" ? '4':'12'); ?>  mb-2">
            <div class="form-group">
                <label for="payment_type"><?php echo e(trans('admin.select_payment_type')); ?></label><span class="text-danger">*</span>
                <select wire:model.live="payment_type" class="form-control <?php $__errorArgs = ['payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option><?php echo e(trans('admin.select_payment_type')); ?></option>
                    <option value="cash">دفع كامل المبلغ نقدا</option>
                    <option value="by_check">دفع كامل المبلغ بشيك</option>
                    <option value="by_installments">اجل</option>
                </select>
                <?php echo $__env->make('inc.livewire_errors', ['property' => 'payment_type'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($payment_type == "by_check"): ?>
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for="payment_type">إختر البنك</label><span class="text-danger">*</span>
                    <select wire:model="bank_id" class="form-control <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">إختر البنك</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    </select>
                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'bank_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for="check_num">رقم الشيك</label>
                    <input type="text" wire:model="check_num" class="form-control <?php $__errorArgs = ['check_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="رقم الشيك">
                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'check_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/asset/add-asset.blade.php ENDPATH**/ ?>