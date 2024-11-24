<div>
    <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
        <style>
     

                    .inv-fields {
            font-size:12px !important;
            font-weight:bolder !important;
        }
        input {
        display: inline-block;
        min-width: fit-content;
        white-space: nowrap;
        overflow-x: hidden;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color:red !important;
        }
        </style>
  

    <?php $__env->stopPush(); ?>
    <div class="row">
        <div class="col">
            <div class="card">
                <form wire:submit.prevent="create">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                                <?php
                                    $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                ?>

                                <?php
                                    $treasuries = App\Models\Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                    $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                ?>
                                
                                <fieldset>
                                    <legend>تسجيل العجز / الزيادة</legend>
                                    <div class="row">
                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label for="type">نوع التسوية </label><span class="text-danger">*</span>
                                            <select wire:model.live="type"  class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option value="عجز" selected >عجز</option>
                                                <option value="زيادة">زيادة</option>
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'type'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label for='branch_id'> الفرع</label>
                                            <select wire:model.live="branch_id" class="form-control">
                                                <option value="">إختر الفرع</option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($branch->id); ?>" wire:key="branch-<?php echo e($branch->id); ?>" <?php echo e($branch->id == Auth::user()->branch_id ? 'selected' :''); ?> ><?php echo e($branch->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>

                                        </div>
                                        <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    
                                        <table class="table table-bordered">
                                            <?php
                                                $parentUpnormalShortageAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('is_active',1)->where('account_num',1237)->first();// عجز غير طبيعي
                                                $parentNormalShortageAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('is_active',1)->where('account_num',515)->first();// عجز طبيعي

                                                    //dd($parentNormalShortageAccount);
                                                if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                    
                                                    $shortageUpnormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentUpnormalShortageAccount->account_num)
                                                    ->where('branch_id',$this->branch_id)->first();//عجز غير طبيعي للفرع

                                    
                                                    $shortageNormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentNormalShortageAccount->account_num)
                                                    ->where('branch_id',$this->branch_id)->first();//عجز طبيعي للفرع
                                                } else {
                                                    $shortageUpnormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentUpnormalShortageAccount->account_num)
                                                    ->where('branch_id',Auth::user()->branch_id)->first();//عجز غير طبيعي للفرع

                                                    $shortageNormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentNormalShortageAccount->account_num)
                                                    ->where('branch_id',Auth::user()->branch_id)->first();//عجز طبيعي للفرع
                                                }
                                            ?>
                                            <h4 class="card-title text-danger my-3"> إضافة قيد العجز / الزيادة   </h4>
                                            <thead>
                                                <tr>
                                                    <th scope="col">مدين</th>
                                                    <th scope="col">مبلغ المدين</th>
                                                    <th scope="col"> الدائن</th>
                                                    <th scope="col">مبلغ الدائن</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr wire:ignore>
                                                    <!--[if BLOCK]><![endif]--><?php if($type = "عجز" && $branch_id != null): ?>
                                                        <td>
                                                            <select wire:model="credit1"  style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 <?php $__errorArgs = ['credit1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                <option value="">إختر الحساب المدين</option>
                                                                
                                                                <option value="<?php echo e($shortageUpnormalAccount->id); ?>" > <?php echo e($shortageUpnormalAccount->name); ?></option>
                                                                <option value="<?php echo e($shortageNormalAccount->id); ?>" > <?php echo e($shortageNormalAccount->name); ?></option>
                                                                
                                                            </select>
                                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'credit1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </td>
                                                    <?php elseif($type = "زيادة"): ?>
                                                        <td>
                                                            <select wire:model="debit1" style="width: 100%"  class="form-control <?php $__errorArgs = ['debit1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                <option value="">إختر الحساب المدين</option>
                                                                <?php
                                                                    $ids = [16,17,18,19,20,21,22]
                                                                ?>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Account::whereIn('id',$ids)->select('id',
                                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($account->id); ?>" > <?php echo e($account->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'debit1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </td>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <td>
                                                        <input type="number" min="0"  step="any" wire:model="debit_amount1" class="form-control inv-fields <?php $__errorArgs = ['debit_amount1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'debit_amount1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" readonly  class="form-control">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0"  step="any" wire:model="credit_amount1" class="form-control inv-fields <?php $__errorArgs = ['credit_amount1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'credit_amount1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </td>
                                                    

                                                </tr>
                                            </tbody>
                                        </table>


                                                <hr>
                            


                                    </div>
                                </fieldset>    
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" wire:submit="submit" class="btn btn-danger mx-2 px-3">إضافة تسوية الخزينة</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>                     


   

</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-adjustments/add-treasury-adjustment.blade.php ENDPATH**/ ?>