

<div>

        <form wire:submit.prevent="create">
            <?php echo csrf_field(); ?>
            <div class="d-flex justify-content-between" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                <h5> حسابات راتب - <span class="text-danger"><?php echo e($user->name); ?>  </span> عن شهر <?php echo e(Carbon\Carbon::now()->format('Y F')); ?> </h5>
                <hr>
                <h6> رقم الحساب المالي  - <span class="text-danger"> <?php echo e($user->account_num); ?></span>  </h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mt-6" >
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="from_date">من تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model="from_date" wire:change.live="getValues" class="form-control <?php $__errorArgs = ['from_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="من تاريخ:">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'from_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="to_date">إلي تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model="to_date" wire:change.live="getValues" class="form-control <?php $__errorArgs = ['to_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="إلي تاريخ:">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'to_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='mainSalary'>الراتب الأساسي</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['mainSalary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="mainSalary"  placeholder = "الراتب الأساسي">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'mainSalary'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_overtime'>الإضافي</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['total_overtime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="total_overtime"  placeholder = "الإضافي">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'total_overtime'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_commission_rate'>عمولات المبيعات</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['total_commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="total_commission_rate"  placeholder = "عمولات المبيعات">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'total_commission_rate'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                       <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='rewards'>المكافئات</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['rewards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="rewards"  placeholder = "المكافئات">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'rewards'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='housing_allowance'>بدل السكن</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['housing_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="housing_allowance"  placeholder = "بدل السكن">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'housing_allowance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='transfer_allowance'>بدل  الإنتقال</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['transfer_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="transfer_allowance"  placeholder = "بدل  الإنتقال">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'transfer_allowance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='medical_insurance_deduction'>استقطاع التأمين الصحي</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['medical_insurance_deduction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="medical_insurance_deduction"  placeholder = "استقطاع التأمين الصحي">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'medical_insurance_deduction'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                       <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='advance_payment_deduction'>خصومات السلف</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['advance_payment_deduction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="advance_payment_deduction"  placeholder = "خصومات السلف">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'advance_payment_deduction'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_commission_rate'>خصومات أخري</label><span class="text-danger"> *</span>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['total_commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="total_commission_rate"  placeholder = "خصومات أخري">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'total_commission_rate'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for='delay'>عدد دقائق التأخير</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['delay'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="delay"  placeholder = "عدد دقائق التأخير">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'delay'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for='total_delay'>تكلفة التأخير</label><span class="text-danger"> *</span>
                                <input type="number" min="0" class="form-control <?php $__errorArgs = ['total_delay'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="total_delay"  placeholder = "تكلفة التأخير">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'total_delay'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='required_days'>عدد الأيام المطلوب حضورها</label><span class="text-danger"> *</span>
                                <input type="number" min="0" class="form-control <?php $__errorArgs = ['required_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="required_days"  placeholder = "عدد الأيام المطلوب حضورها">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'required_days'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='actual_days_num'>أيام الحضور الفعلية</label>
                                <input type="number" min="0" readonly class="form-control <?php $__errorArgs = ['actual_days_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="actual_days_num"  placeholder = "أيام الحضور الفعلية">
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'actual_days_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='receiving_type'>طريقة استلام الراتب</label><span class="text-danger"> *</span>
                                <select wire:model.live='receiving_type' style="height: 45px;" class='form-control  pb-3 <?php $__errorArgs = ['receiving_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                                    <option value="">إختر الطريقة</option>

                                    <option value="cash">كاش</option>
                                    <option value="visa">تحويل بنكي</option>


                                </select>
                            </div>
                            <?php echo $__env->make('inc.livewire_errors',['property'=>'receiving_type'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($receiving_type == 'visa'): ?>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label for='bank_id'>البنك</label><span class="text-danger"> *</span>
                                    <select wire:model='bank_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                                        <option value="">إختر البنك</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($partner->id); ?>"><?php echo e($partner->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'bank_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->    
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit"  class="btn btn-success mx-2"> إعتماد الراتب</button>
            </div>
        </form>
    <?php $__env->startPush('scripts'); ?>

    <?php $__env->stopPush(); ?>
</div>


<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/salaries/add-salary.blade.php ENDPATH**/ ?>