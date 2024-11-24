<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => 'إضافة قيد يومية'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
        </style>

    <?php $__env->stopPush(); ?>
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
                <thead>
                    <tr>
                        <th scope="col">مدين</th>
                        <th scope="col">مبلغ المدين</th>
                        <th scope="col"> الدائن</th>
                        <th scope="col">مبلغ الدائن</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select wire:model="debit" style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 <?php $__errorArgs = ['debit'];
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


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be)): ?>
<?php $attributes = $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be; ?>
<?php unset($__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be)): ?>
<?php $component = $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be; ?>
<?php unset($__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be); ?>
<?php endif; ?>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/journal-entries/add-entry.blade.php ENDPATH**/ ?>