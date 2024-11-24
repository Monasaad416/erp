<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => ''.e(trans('admin.edit_shift_type')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div>
            <h5 class="text-danger my-3 d-block"><?php echo e(trans('admin.delivered_shift_info')); ?></h5>

            <div class="row">

                <div class="col-3 mb-2">
                    <div class="form-group">
                        <label for="type"><?php echo e(trans('admin.select_shift_type')); ?></label><span class="text-danger">*</span>
                        <select wire:model="delivered_shift_id" class="form-control mt-1 mb-3 <?php $__errorArgs = ['delivered_shift_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option><?php echo e(trans('admin.select_shift_type')); ?></option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $shiftTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliveredShiftType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($deliveredShiftType->id); ?>"><?php echo e($deliveredShiftType->label()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'delivered_shift_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>


                    
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='start_shift_cash_balance'><?php echo e(trans('admin.start_shift_cash_balance')); ?></label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model='start_shift_cash_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['start_shift_cash_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.start_shift_cash_balance')); ?>">
                    </div>
                    <?php echo $__env->make('inc.livewire_errors',['property'=>'start_shift_cash_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='end_shift_cash_balance'><?php echo e(trans('admin.end_shift_cash_balance')); ?></label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model.live='end_shift_cash_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['end_shift_cash_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.end_shift_cash_balance')); ?>">
                    </div>
                    <?php echo $__env->make('inc.livewire_errors',['property'=>'end_shift_cash_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='end_shift_cash_balance'><?php echo e(trans('admin.end_shift_bank_balance')); ?></label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model.live='end_shift_bank_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['end_shift_bank_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.end_shift_bank_balance')); ?>">
                    </div>
                    <?php echo $__env->make('inc.livewire_errors',['property'=>'end_shift_bank_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
               <div class="col-3 mb-2">
                         <div class="form-group">
                                <label for="payment_type">البنك المحول اليه</label><span class="text-danger">*</span>
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
                                        <option value="<?php echo e($bank->id); ?>" <?php echo e($bank->id == $bank_id ? 'selected' : ''); ?>><?php echo e($bank->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                </select>
                            </div>
                    <?php echo $__env->make('inc.livewire_errors',['property'=>'bank_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                 
                
                

            </div>


            <h5 class="text-success my-3 d-block"><?php echo e(trans('admin.delivered_to_shift_info')); ?></h5>

            <div class="row">

                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for='delivered_to_user_id'><?php echo e(trans('admin.delivered_to_user')); ?></label><span class="text-danger">*</span>
                        <select wire:model="delivered_to_user_id" class="form-control mt-1 mb-3 <?php $__errorArgs = ['delivered_to_user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option>إختر مستلم الوردية</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\User::where('branch_id',Auth::user()->branch_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'delivered_to_user_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>


                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for="type"><?php echo e(trans('admin.select_shift_type')); ?></label><span class="text-danger">*</span>
                        <select wire:model="delivered_to_shift_id" class="form-control mt-1 mb-3 <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option><?php echo e(trans('admin.select_shift_type')); ?></option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $shiftTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recievedShiftType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($recievedShiftType->id); ?>"><?php echo e($recievedShiftType->label()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'delivered_to_shift_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-shifts/update-treasury-shift.blade.php ENDPATH**/ ?>