<div class="row" >
         <style>
        .calc table {
            border: none;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .calc input[type="button"] {
            width: 100%;
            padding: 10px 5px;
            background-color: #9a9ca0;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
        }

        /* .calc input[type="text"] {
            padding: 20px 30px;
            font-size: 24px;
            font-weight: bold;
            border: none;
            border-radius: 5px;

        }  */
            .table thead th  {
            text-align: center;
        }
    </style>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title text-danger"> إضافة ايصال تحصيل نقدية </h4>

                </div>
            </div>

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

                                $ids= [3,11];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);
                                $account = false;
                                if ($desiredSegment == "customers/invoices") {
                                    $account = true;
                                    $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                }
                                $minExchangePoints = App\Models\Setting::find(1)->min_exchange_pos;

                                //  dd($posNum);
                            ?>

                            
                            <!--[if BLOCK]><![endif]--><?php if($account): ?>
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
                                        <select wire:model.live="account_type_id" class="form-control <?php $__errorArgs = ['account_type_id'];
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
                                        <label for="customer_id"> <?php echo e($type); ?></label><span class="text-danger">*</span>
                                        <select wire:model.live="customer_id" class="form-control <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option><?php echo e(trans('admin.select_customer')); ?></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($customer->id); ?>" <?php echo e($customer->id == $customer->id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    </div>
                                </div>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="date">تاريخ الحركة</label><span class="text-danger">*</span>
                                    <input type="date" wire:model="date" class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.inv_date_time')); ?>">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
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
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trans_type->id); ?>" <?php echo e($transaction_type_id == $trans_type->id ? 'selected' : ''); ?>><?php echo e($trans_type->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'transaction_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ <?php echo e($receipt_amount_type); ?></label>
                                    <input type="number" disabled min="0" step="any" wire:model.live="receipt_amount" class="form-control <?php $__errorArgs = ['receipt_amount'];
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
                            <!--[if BLOCK]><![endif]--><?php if($account): ?>
                                <div class="col-6 mb-2">
                                    <div class="col-12 mb-2 calc">
                                        <div class="form-group">
                                            <label for='unit'>المبلغ المدفوع</label><span class="text-danger"> *</span>
                                            <table id="calcu" >
                                                <tr>
                                                    <td colspan="9">
                                                        <input type="text"  wire:model.live="paid"  class="form-control" readonly id="result">
                                                        <?php echo $__env->make('inc.livewire_errors',['property'=>'paid'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="1" wire:click.live="addDigit('1')"> </td>
                                                    <td><input type="button" value="2" wire:click.live="addDigit('2')"> </td>
                                                    <td><input type="button" value="3" wire:click.live="addDigit('3')"> </td>
                                                    <td><input type="button" value="." wire:click.live="addDigit('.')"> </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="4" wire:click.live="addDigit('4')"> </td>
                                                    <td><input type="button" value="5" wire:click.live="addDigit('5')"> </td>
                                                    <td><input type="button" value="6" wire:click.live="addDigit('6')"> </td>
                                                    <td><input type="button" value="c" wire:click.live="clearQty()" /> </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="7" wire:click.live="addDigit('7')"> </td>
                                                    <td><input type="button" value="8" wire:click.live="addDigit('8')"> </td>
                                                    <td><input type="button" value="9" wire:click.live="addDigit('9')"> </td>
                                                    <td><input type="button" value="0" wire:click.live="addDigit('0')"> </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <?php echo $__env->make('inc.livewire_errors',['property'=>'unit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label for="remaining">المتبقي</label>
                                        <input type="number" disabled min="0" step="any" wire:model.live="remaining" class="form-control <?php $__errorArgs = ['remaining'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="المبلغ المتبقي">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'remaining'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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


                         <!--[if BLOCK]><![endif]--><?php if($account): ?>
                                <div class="col-2 mb-2">
                                    <div class="form-group">
                                        <label for="posNum">عدد نقاط الفاتورة</label>
                                        <input type="number" min="0" readonly wire:model="posNum"  class="form-control <?php $__errorArgs = ['posNum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="عدد النقاط الفاتورة">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'posNum'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-2 mb-2">
                                    <div class="form-group">
                                        <label for="points_price">تكلفة النقاط</label>
                                        <input type="text" readonly wire:model="points_price" class="form-control <?php $__errorArgs = ['points_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="تكلفة النقاط">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'points_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-<?php echo e($is_exchange==1?3:4); ?>" >
                                    <label for="is_available" class="text-<?php echo e($this->is_available == 1 ? 'green' :'danger'); ?>"> <?php echo e($this->is_available == 1 ? 'متاحة للاستبدال' :'غير متاحة للاستبدال'); ?> </label>
                                    <div class="input-group mb-3">

                                    <div class="input-group-prepend " >
                                        <div class="input-group-text" >
                                        <input type="checkbox" wire:model="is_available" disabled style="opacity:1;" <?php echo e($this->is_available == 1 ? 'checked' :''); ?>>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox"  value="متاحة للاستبدال" readonly>
                                    </div>
                                    <?php echo $__env->make('inc.livewire_errors',['property'=>'taxes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                               
                                    <div class="col-<?php echo e($is_exchange==1?3:4); ?>"">
                                        <label for="is_exchange">إستبدال النقاط</label>
                                        <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox"  wire:model.live="is_exchange" <?php echo e($is_available == 0 ? 'disabled':''); ?> wire:click.live="recalculateReceiptAmount">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox"  value="إستبدال النقاط" readonly>
                                        </div>
                                        <?php echo $__env->make('inc.livewire_errors',['property'=>'is_exchange'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($is_exchange == 1): ?>
                                    <div class="col-2 mb-2">
                                        <div class="form-group">
                                            <label for="points_to_exchange">عدد النقاط للاستبدال</label>
                                            <input type="number" max="posNum" min="0" wire:model.live="points_to_exchange" class="form-control <?php $__errorArgs = ['points_to_exchange'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="عدد النقاط لاستبدال">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'points_to_exchange'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>

                    </div>


                    <!--[if BLOCK]><![endif]--><?php if(!$account): ?>
                        <table class="table table-bordered">
                            <?php
                                if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                    $accounts = App\Models\Account::select('id',
                                    'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                } else {
                                    $accounts = App\Models\Account::select('id',
                                    'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->where('branch_id',Auth::user()->branch_id)->get();
                                }
                            ?>
                            <h4 class="card-title text-danger my-3"> إضافة قيد اليومية   </h4>
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
                                    <td>
                                        <select wire:model="debit" style="width: 100%"  class="form-control <?php $__errorArgs = ['debit'];
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
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'debit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    <td>
                                        <input type="number" min="0"  step="any" wire:model="debit_amount" class="form-control inv-fields <?php $__errorArgs = ['debit_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'debit_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                        <select wire:model="credit"  style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">إختر الحساب الدائن</option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($account->id); ?>" > <?php echo e($account->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'credit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    <td>
                                        <input type="number" min="0"  step="any" wire:model="credit_amount" class="form-control inv-fields <?php $__errorArgs = ['credit_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'credit_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    

                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                    <div class="d-flex justify-content-center">
                        <button id="saveWithoutPrint" wire:click="saveWithoutPrint" type="button" class="btn btn-success mx-2">حفظ الإيصال</button>
                        
                        <!--[if BLOCK]><![endif]--><?php if($is_account): ?>
                        <button wire:click="saveAndPrintReceipt" type="button" class="btn btn-secondary mx-2">حفظ و طباعة</button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>

        window.addEventListener('newDebitCredit', event => {
            $('.select2bs4').select2();
            $(document).ready(function () {
                    $('.select2bs4').select2();

                    $(document).on('change', '.select2bs4', function (e) {

                        console.log(e.target.value);
                        // window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('debit', e.target.value);
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('credit', e.target.value);
                    });
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'F10') {
            event.preventDefault();
            document.getElementById('saveWithoutPrint').click();

            }
        });


    </script>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-transactions/add-collection.blade.php ENDPATH**/ ?>