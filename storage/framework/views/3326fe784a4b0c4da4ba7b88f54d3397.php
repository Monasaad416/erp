<?php if (isset($component)) { $__componentOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5f06eeb2338f5c373a4afa6aa36b0be = $attributes; } ?>
<?php $component = App\View\Components\CreateModalComponent::resolve(['title' => ''.e(trans('admin.create_user')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('create-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CreateModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->whereNot('branch_num',1)->get();
    ?>
        <?php $__env->startPush('css'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
            
        <?php $__env->stopPush(); ?>
    <div class="row">
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='name'><?php echo e(trans('admin.name')); ?></label><span class="text-danger"> *</span>
                <input type="text" wire:model='name' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " <?php echo e(trans('admin.name')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='email'><?php echo e(trans('admin.email')); ?></label><span class="text-danger"> *</span>
                <input type="email"  wire:model='email' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "<?php echo e(trans('admin.email')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='password'> <?php echo e(trans('admin.password')); ?></label><span class="text-danger"> *</span>
                <input type="password" wire:model='password' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " <?php echo e(trans('admin.password')); ?> ">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='password_confirmation'> <?php echo e(trans('admin.password_confirmation')); ?> </label><span class="text-danger"> *</span>
                <input type="password" wire:model='password_confirmation' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " <?php echo e(trans('admin.password_confirmation')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'password_confirmation'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='roles_name'><?php echo e(trans('admin.role')); ?> </label><span class="text-danger"> *</span>
                <select wire:model='roles_name' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['roles_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_role')); ?>  </option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = Spatie\Permission\Models\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'roles_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='branch_id'><?php echo e(trans('admin.branch')); ?> </label><span class="text-danger"> *</span>
                <select wire:model='branch_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value=""><?php echo e(trans('admin.select_branch')); ?>  </option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='gender'> النوع </label><span class="text-danger"> *</span>
                <select wire:model='gender' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">إختر النوع </option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثي</option>
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'gender'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-3">
            <div class="form-group">
                <label for='joining_date'> تاريخ الالتحاق بالعمل </label><span class="text-danger"> *</span>
                <input type="date" wire:model='joining_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['joining_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " تاريخ الالتحاق بالعمل">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'joining_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='age'>العمر </label><span class="text-danger"> *</span>
                <input type="number" wire:model='age' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " العمر">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'age'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='medical_insurance_deduction'>إستقطاعات التأمين الطبي(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='medical_insurance_deduction' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['medical_insurance_deduction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "إستقطاعات التأمين الطبي ">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'medical_insurance_deduction'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='transfer_allowance'>بدل الإنتقالات(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='transfer_allowance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['transfer_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "بدل الإنتقالات">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'transfer_allowance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='housing_allowance'>بدل السكن(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='housing_allowance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['housing_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "بدل السكن">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'housing_allowance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='salary'>الراتب بدون بدلات</label><span class="text-danger"> *</span>
                <input type="number" min='0' step="any" wire:model='salary' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "الراتب بدون بدلات">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'salary'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='overtime_hour_price'>تكلفة ساعة الاضافي</label>
                <input type="number" min='0' step="any" wire:model='overtime_hour_price' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['overtime_hour_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "تكلفة ساعة الإضافي">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'overtime_hour_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='vacation_balance'>رصيد الاجازات</label>
                <input type="number" min='0' step="any" wire:model='vacation_balance' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['vacation_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " رصيد الأجازات">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'vacation_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='working_status'>حالة العمل</label>
                <select wire:model='working_status' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['working_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">إختر  حالة العمل </option>
                    <option value="working">علي رأس العمل</option>
                    <option value="not_working">تم أنهاء العمل لدينا</option>
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'working_status'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='resignation_date'>تاريخ الإستقالة</label>
                <input type="date" wire:model='resignation_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['resignation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = "تاريج الإستقالة">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'resignation_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='fingerprint_code'> كود البصمة </label>
                <input type="text" wire:model='fingerprint_code' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['fingerprint_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " كود البصمة">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'fingerprint_code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='blood_type_id'> فصبلة الدم </label>
                <select wire:model='blood_type_id' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['blood_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">إختر فصبلة الدم  </option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\BloodType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloodType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bloodType->id); ?>"><?php echo e($bloodType->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'blood_type_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='marital_status'> الحالة الاجتماعية </label>
                <select wire:model='marital_status' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['marital_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">إختر الحالة الاجتماعية </option>
                    <option value="married">متزوج</option>
                    <option value="single">أعزب</option>
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'marital_status'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='nationality_id'>الجنسية</label>
                <select wire:model='nationality_id' style="height: 50px;" class='form-control select2bs4 pb-3 <?php $__errorArgs = ['nationality_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                    <option value="">الجنسية</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Nationality::select('id',   'name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($nat->id); ?>"><?php echo e($nat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'nationality_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='job_title'>المسمي الوظيفي</label>
                <input type="text" wire:model='job_title' class='form-control pb-3 <?php $__errorArgs = ['job_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                <?php echo $__env->make('inc.livewire_errors',['property'=>'job_title'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
            


        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='address'><?php echo e(trans('admin.address')); ?></label>
                <input type="text" wire:model='address' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " <?php echo e(trans('admin.address')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'address'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='phone'><?php echo e(trans('admin.phone')); ?></label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " <?php echo e(trans('admin.phone')); ?>">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'phone'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>


        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='date_of_birth'>تاريخ الميلاد</label>
                <input type="date" wire:model='date_of_birth' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " تاريخ الميلاد">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'date_of_birth'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='id_num'>رقم الهوية</label>
                <input type="text" wire:model='id_num' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['id_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " رقم الهوية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'id_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='id_exp_date'>تاريخ انتهاء الهوية</label>
                <input type="date" wire:model='id_exp_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['id_exp_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " تاريخ انتهاء الهوية">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'id_exp_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='passport_num'>رقم جواز السفر</label>
                <input type="text" wire:model='passport_num' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['passport_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " رقم جواز السفر">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'passport_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='passport_exp_date'>تاريج إنتهاء جواز السفر</label>
                <input type="date" wire:model='passport_exp_date' class= 'form-control mt-1 mb-3 <?php $__errorArgs = ['passport_exp_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder = " تاريج إنتهاء جواز السفر">
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'passport_exp_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="has_driving_license">
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="لديه رخصة قيادة" readonly>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'has_driving_license'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="has_medical_insurance">
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="لديه تأمين طبي" readonly>
            </div>
            <?php echo $__env->make('inc.livewire_errors',['property'=>'has_medical_insurance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

    </div>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/users/add-user.blade.php ENDPATH**/ ?>