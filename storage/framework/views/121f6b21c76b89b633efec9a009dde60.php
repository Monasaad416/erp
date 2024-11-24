

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mt-6">
                    <div class="col-6">
                        <div class="form-group">
                            <label for='commercial_register'>السجل التجاري </label><span class="text-danger">*</span>
                            <input type='text' wire:model='commercial_register'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['commercial_register'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "السجل التجاري">
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'commercial_register'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='tax_num'>الرقم الضريبي </label><span class="text-danger">*</span>
                            <input type='text' wire:model='tax_num'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['tax_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الرقم الضريبي">
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'tax_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='name'>إسم المتجر(المستخدم في طباعة الفواتير)</label><span class="text-danger">*</span>
                            <input type='text' wire:model='name'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إسم المتجر">
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='otp'>كود التحقق</label><span class="text-danger">*</span>
                            <input type='text' wire:model='otp'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "كود التحقق">
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'otp'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" wire:click="update"  class="btn btn-secondary">
                        <span wire:loading wire:target="update">
                            <div class="text-center">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="sr-only">جاري التنفيذ ...</span>
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

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/zatca-setting/create-integration-keys.blade.php ENDPATH**/ ?>