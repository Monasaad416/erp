<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                    <div class="row mt-3">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for='parent_id'>إختر طريقة التقسيم</label> <span class="text-danger"> *</span>
                                <select wire:model="parent_id" class="form-control">
                                    <option value="">---</option>
                                    <option value="percentage" wire:key="type-1">نسبة مئوية</option>
                                    <option value="amount" wire:key="type-2">مبلغ(ريال)</option>
                                </select>

                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'parent_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch1'>حصة المركز الرئيسي </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch1'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة المركز الرئيسي">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch2'>حصة فرع مشعل </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch2'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع مشعل">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch2'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                         <div class="col-3">
                            <div class="form-group">
                                <label for='branch3'>حصة فرع الوديعة البلدية  </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch3'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع الوديعة البلدية">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch3'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                         <div class="col-3">
                            <div class="form-group">
                                <label for='branch4'>حصة فرع سعود الوديعة  </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch4'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع سعود الوديعة">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch4'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch5'>حصة فرع بن علا </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch5'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch5'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع بن علا">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch5'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch6'>حصة فرع السوق </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch6'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch6'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع السوق">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch6'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                       <div class="col-3">
                            <div class="form-group">
                                <label for='branch'>حصة فرع 6 </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch'  class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "حصة فرع 6">
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/capital-settings/update-settings.blade.php ENDPATH**/ ?>