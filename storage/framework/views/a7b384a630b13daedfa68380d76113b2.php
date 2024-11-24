<?php if (isset($component)) { $__componentOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb55b767eda0aa70eb57b69ebc1fd7f = $attributes; } ?>
<?php $component = App\View\Components\UpdateModalComponent::resolve(['title' => 'تعديل بيانات حركة الخزينة'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('update-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UpdateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<!--[if BLOCK]><![endif]--><?php if($state == 'صرف'): ?>
    <?php
        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    ?>
    <!--[if BLOCK]><![endif]--><?php if($is_account == 1): ?>
        <div class="row">
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="account_num"><?php echo e(trans('admin.account_num')); ?></label><span class="text-danger">*</span>
                    <input type="text" readonly wire:model="account_num" class="form-control <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.account_num')); ?>">
                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                    <select wire:model="account_type_id" disabled class="form-control <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option>إختر نوع الحساب المالي  </option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($account_type->id); ?>" <?php echo e($account_type->id == $account_type_id ? 'selected' : ''); ?>><?php echo e($account_type->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                </div>
            </div>
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="supplier_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                    <select wire:model="supplier_id" disabled class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option><?php echo e(trans('admin.select_supplier')); ?></option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($supp->id); ?>" <?php echo e($supp->id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supp->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
            </div>
            <div class="col-3 mb-2">
                        <div class="form-group">
                            <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                            <select wire:model="transaction_type_id" disabled class="form-control <?php $__errorArgs = ['transaction_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option>نوع الحركة المالية</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($trans_type->id); ?>" <?php echo e($transaction_type_id == $trans_type->id ? 'selected' : ''); ?>><?php echo e($trans_type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'transaction_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                        </div>
                    </div>
        </div>

        <div class="row">
       
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="treasury_balance">رصيد الخزينة المتاح</label>
                            <input type="number" min="0" step="any"  wire:model="treasury_balance" class="form-control <?php $__errorArgs = ['treasury_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly>
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'treasury_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                                 <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="deserved_account_amount">المبلغ المستحق للحساب</label>
                                <input type="number" min="0" step="any" wire:model="deserved_account_amount" class="form-control <?php $__errorArgs = ['deserved_account_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly>
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'deserved_account_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>




                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="receipt_amount">المبلغ <?php echo e($receipt_amount_type); ?></label>
                            <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control <?php $__errorArgs = ['receipt_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="المبلغ <?php echo e($receipt_amount_type); ?>">
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'receipt_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col">
                <div class="card">


                    <div class="card-body">
                        <form wire:submit.prevent="create">
                            <?php echo csrf_field(); ?>
                                <div class="card-body">
                                    <style>
                                        tr , .table thead th  {
                                            text-align: center;
                                        }
                                    </style>

                        <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                            <?php
                                $ids = [1,2,12,13];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $account = false;
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);

                                if($desiredSegment == "suppliers/invoices/") {
                                    $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();

                                    $account= true;
                                }
                            ?>

                        
                            <!--[if BLOCK]><![endif]--><?php if($account): ?>
                                <div class="row">
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="account_num"><?php echo e(trans('admin.account_num')); ?></label><span class="text-danger">*</span>
                                                <input type="text" readonly wire:model="account_num" class="form-control <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.account_num')); ?>">
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                                                <select wire:model="account_type_id" class="form-control <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option>إختر نوع الحساب المالي  </option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account_type->id); ?>" <?php echo e($account_type->id == $account_type_id ? 'selected' : ''); ?>><?php echo e($account_type->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="supplier_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                                                <select wire:model="supplier_id" class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option><?php echo e(trans('admin.select_supplier')); ?></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($supp->id); ?>" <?php echo e($supp->id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supp->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="account_num"><?php echo e(trans('admin.account_num')); ?></label><span class="text-danger">*</span>
                                            <input type="text" readonly wire:model="account_num" class="form-control <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.account_num')); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                                            <select wire:model="account_type_id" class="form-control <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option>إختر نوع الحساب المالي  </option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($account_type->id); ?>" <?php echo e($account_type->id == $account_type_id ? 'selected' : ''); ?>><?php echo e($account_type->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="supplier_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                                            <select wire:model="supplier_id" class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option><?php echo e(trans('admin.select_supplier')); ?></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($supp->id); ?>" <?php echo e($supp->id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supp->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                    <select wire:model="transaction_type_id" class="form-control <?php $__errorArgs = ['transaction_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option>نوع الحركة المالية</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trans_type->id); ?>" <?php echo e($transaction_type_id == $trans_type->id ? 'selected' : ''); ?>><?php echo e($trans_type->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'transaction_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>
                            </div>
        
                


                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="treasury_balance">رصيد الخزينة المتاح</label>
                                    <input type="number" min="0" step="any" wire:model="treasury_balance" class="form-control <?php $__errorArgs = ['treasury_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'treasury_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ <?php echo e($receipt_amount_type); ?></label>
                                    <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control <?php $__errorArgs = ['receipt_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="المبلغ <?php echo e($receipt_amount_type); ?>">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'receipt_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                        <label><?php echo e(trans('admin.description')); ?></label>
                                        <textarea wire:model="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.description')); ?>"></textarea>
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                            </div>

                        </div>

                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->    

<?php elseif($state == 'تحصيل'): ?>
    <?php
        $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    ?>
    <!--[if BLOCK]><![endif]--><?php if($is_account == 1): ?>

        
    <?php else: ?>
        <div class="row">
            <div class="col">
                <div class="card">


                    <div class="card-body">
                        <form wire:submit.prevent="create">
                            <?php echo csrf_field(); ?>
                                <div class="card-body">
                                    <style>
                                        tr , .table thead th  {
                                            text-align: center;
                                        }
                                    </style>

                        <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                            <?php
                                $ids = [1,2,12,13];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $account = false;
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);

                                if($desiredSegment == "suppliers/invoices/") {
                                    $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();

                                    $account= true;
                                }
                            ?>

                        
                            <!--[if BLOCK]><![endif]--><?php if($account): ?>
                                <div class="row">
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="account_num"><?php echo e(trans('admin.account_num')); ?></label><span class="text-danger">*</span>
                                                <input type="text" readonly wire:model="account_num" class="form-control <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.account_num')); ?>">
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                                                <select wire:model="account_type_id" class="form-control <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option>إختر نوع الحساب المالي  </option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account_type->id); ?>" <?php echo e($account_type->id === $account_type_id ? 'selected' : ''); ?>><?php echo e($account_type->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <label for="supplier_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                                                <select wire:model="supplier_id" class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option><?php echo e(trans('admin.select_supplier')); ?></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($supp->id); ?>" <?php echo e($supp->id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supp->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="account_num"><?php echo e(trans('admin.account_num')); ?></label><span class="text-danger">*</span>
                                            <input type="text" readonly wire:model="account_num" class="form-control <?php $__errorArgs = ['account_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.account_num')); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                                            <select wire:model="account_type_id" class="form-control <?php $__errorArgs = ['account_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option>إختر نوع الحساب المالي  </option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($account_type->id); ?>" <?php echo e($account_type->id == $account_type_id ? 'selected' : ''); ?>><?php echo e($account_type->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'account_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="form-group">
                                            <label for="supplier_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                                            <select wire:model="supplier_id" class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option><?php echo e(trans('admin.select_supplier')); ?></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($supp->id); ?>" <?php echo e($supp->id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supp->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                    <select wire:model="transaction_type_id" class="form-control <?php $__errorArgs = ['transaction_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option>نوع الحركة المالية</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $transactionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trans_type->id); ?>" <?php echo e($transaction_type_id == $trans_type->id ? 'selected' : ''); ?>><?php echo e($trans_type->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'transaction_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>
                            </div>
        
                


                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="treasury_balance">رصيد الخزينة المتاح</label>
                                    <input type="number" min="0" step="any" wire:model="treasury_balance" class="form-control <?php $__errorArgs = ['treasury_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'treasury_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ <?php echo e($receipt_amount_type); ?></label>
                                    <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control <?php $__errorArgs = ['receipt_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="المبلغ <?php echo e($receipt_amount_type); ?>">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'receipt_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                        <label><?php echo e(trans('admin.description')); ?></label>
                                        <textarea wire:model="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.description')); ?>"></textarea>
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                            </div>

                        </div>

                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-transactions/update-transaction.blade.php ENDPATH**/ ?>