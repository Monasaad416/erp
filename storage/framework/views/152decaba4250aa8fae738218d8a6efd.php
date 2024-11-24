<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
  
                    <div class="row mt-3">

                        
                        <div class="col-4">
                            <div class="form-group">
                                <label for='vat'> الضريبة </label><span class="text-danger">*</span> <span class="text-muted" >(مثال 0.15)</span>
                                <input type='text' wire:model='vat'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['vat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "نسبة الضريبة">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'vat'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='percentage_for_pos'>نسبة الفاتورة لحساب نقاط العميل  %</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='percentage_for_pos'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['percentage_for_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "نسبة الفاتورة لحساب نقاط العميل">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'percentage_for_pos'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='point_price'>تكلفة النقطة(ريال) </label><span class="text-danger"> *</span>
                                <input type='text' wire:model='point_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['point_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "تكلفة  النقطة">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'point_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <div class="form-group">
                                <label for='min_exchange_pos'>اقل عدد نقاط للاستبدال</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='min_exchange_pos'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['min_exchange_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "أقل عدد نقاط للاستبدال">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'min_exchange_pos'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='max_exchange_pos'>اقصي عدد نقاط للاستبدال</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='max_exchange_pos'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['max_exchange_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "أقصي عدد نقاط للاستبدال">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'max_exchange_pos'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='expiry_days'>عدد أيام صلاحية نقاط العميل</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='expiry_days' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['expiry_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "عدد أيام صلاحية نقاط العميل">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'expiry_days'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>    
                    </div>
                    <div class="text-center">
                        <button type="button" wire:click="updatSettings" class="btn btn-secondary">
                            <span wire:loading wire:target="updatSettings">
                                <div class="text-center">
                                    <div class="spinner-border text-warning" role="status">
                                        <span class="sr-only">جاري التحميل...</span>
                                    </div>
                                </div>
                            </span>
                            <span wire:loading.remove><?php echo e(trans('admin.edit')); ?></span>
                        </button>
                    </div>
    
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/settings/update-settings.blade.php ENDPATH**/ ?>