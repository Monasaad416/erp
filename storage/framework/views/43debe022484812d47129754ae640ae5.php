<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title text-danger"> إضافة ايصال صرف نقدية <?php echo e($reason); ?> </h4>

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
                                    $ids= [1,2,12,13];

                                    $previousUrl = url()->previous();
                                    $path = parse_url($previousUrl, PHP_URL_PATH);
                                    $segments = explode('/', $path);
                                    $account = false;
                                    $desiredSegment = implode('/', array_slice($segments, 2,2));
                                    //dd($desiredSegment);
                                    // dd($desiredSegment);
                                    $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    if($desiredSegment == "suppliers/invoices") {
                                        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    
                                        $account= true;
                                    } else {
                                        // $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                        // ->whereIn('id',$ids)->get();
                                    }
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
                                            <select wire:model.live="account_type_id" disabled class="form-control <?php $__errorArgs = ['account_type_id'];
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
                                            <select wire:model.live="supplier_id" disabled class="form-control <?php $__errorArgs = ['supplier_id'];
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
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                            <select wire:model.live="transaction_type_id" <?php echo e($account ? 'disabled' : ''); ?> class="form-control <?php $__errorArgs = ['transaction_type_id'];
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

                                    <div class="col-3 mb-2">
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

                                    <div class="col-3 mb-2">
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

                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="remaining_amount">المبلغ المستحق للفاتورة</label>
                                            <input type="number" min="0" step="any" wire:model="remaining_amount" class="form-control <?php $__errorArgs = ['remaining_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" readonly>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'remaining_amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-2">
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

                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label><?php echo e(trans('admin.description')); ?></label>
                                            <input type="text" wire:model="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.description')); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                <!--[if BLOCK]><![endif]--><?php if(!$account): ?>
                                    <table class="table table-bordered">
                                        <?php
                                            if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                                $accounts = App\Models\Account::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                                ->where('is_active',1)->where('is_parent',0)->get();
                                            } else {
                                                $accounts = App\Models\Account::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                                ->where('is_active',1)->where('is_parent',0)->where('branch_id',Auth::user()->branch_id)->get();
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
                                                    <select wire:model="debit" style="width: 100%"  class="form-control select2bs4 <?php $__errorArgs = ['debit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <option value="">إختر الحساب المدين</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                    <select wire:model="credit"  style="width: 100%" data-live-search="true" class="form-control inv-fields  <?php $__errorArgs = ['credit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <option value="">إختر الحساب الدائن</option>
                                                        <?php
                                                            $ids = [16,17,18,19,20,21,22]
                                                        ?>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Account::whereIn('id',$ids)->select('id',
                                                        'name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                            </div>

                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                        </div>

                </form>

            </div>
            <script>
                window.addEventListener('newDebitCredit', event => {
                    $('.select2bs4').select2();
                    $(document).ready(function () {
                            $('.select2bs4').select2();

                            $(document).on('change', '.select2bs4', function (e) {

                                console.log(e.target.value);
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('debit', e.target.value);
                                //window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('credit', e.target.value);

                            });
                    });
                });
            </script>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/treasury-transactions/add-exchange.blade.php ENDPATH**/ ?>