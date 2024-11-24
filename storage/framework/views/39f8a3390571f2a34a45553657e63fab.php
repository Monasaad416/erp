
<div>
    <div class="modal" id="create_modal_first" wire:ignore.self>
        <form wire:submit.prevent="create">
            <?php echo csrf_field(); ?>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة ضرائب الربع المالي <?php echo "&nbsp;"; ?></h4>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                            $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
                        ?>
                        <div class="row">
                            <div class="col-3 mb-2">
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

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for="quarter"> إختر الربع المالي لحساب الضرائب</label><span class="text-danger">*</span>
                                    <select wire:model="quarter" wire:change.live ="quarterChanged" class="form-control <?php $__errorArgs = ['quarter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option>إختر الربع</option>
                                        <option value="1">الربع الأول</option>
                                        <option value="2">الربع الثاني</option>
                                        <option value="3">الربع الثالث</option>
                                        <option value="4">الربع الرابع</option>
                                    </select>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'quarter'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>
                            </div>

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='start_date' readonly class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['start_date'];
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

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='end_date'>إلي تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='end_date' readonly class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['end_date'];
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

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
                        <button type="submit" class="btn btn-info"><?php echo e(trans('admin.save')); ?></button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/taxes/add-tax.blade.php ENDPATH**/ ?>