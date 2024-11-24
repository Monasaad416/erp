<?php if (isset($component)) { $__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c = $attributes; } ?>
<?php $component = App\View\Components\ShowModalComponent::resolve(['title' => 'بيانات الموظف'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('show-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ShowModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25"><?php echo e(trans('admin.item')); ?></th>
                            <th class="w-75"><?php echo e(trans('admin.details')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.name')); ?></td>
                            <td class="w-75"><?php echo e($name); ?></td>
                        </tr>

                        <tr>
                            <td>النوع</td>
                            <td class="w-75"><?php echo e($gender ? $gender : '---'); ?></td>
                        </tr>
                        <tr>
                            <td>تاريخ الميلاد</td>
                            <td class="w-75"><?php echo e($date_of_birth ? $date_of_birth : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">المهمة</td>
                            <td class="w-75"><?php echo e($roles_name); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">البريد الالكتروني</td>
                            <td class="w-75"><?php echo e($email ? $email : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">الهاتف</td>
                            <td class="w-75"><?php echo e($phone ? $phone : '---'); ?></td>
                        </tr>

                              <tr>
                            <td class="w-25">العنوان</td>
                            <td class="w-75"><?php echo e($address ? $address : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">العمر</td>
                            <td class="w-75"><?php echo e($age ? $age : '---'); ?></td>
                        </tr>

                       <tr>
                            <td class="w-25">الجنسية</td>
                            <td class="w-75"><?php echo e($nationality ? $nationality : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">فصيلة الدم</td>
                            <td class="w-75"><?php echo e($bloodType ? $bloodType : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">الكود</td>
                            <td class="w-75"><?php echo e($code ? $code : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">كود البصمة</td>
                            <td class="w-75"><?php echo e($fingerprint_code ? $fingerprint_code : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">تاريخ الاإلتحاق بالعمل</td>
                            <td class="w-75"><?php echo e($joining_date ? $joining_date : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">الفرع</td>
                            <td class="w-75"><?php echo e($branch ? $branch : '---'); ?></td>
                        </tr>
          
                        <tr>
                            <td class="w-25">علي رأس العمل </td>
                            <td class="w-75 text-<?php echo e($working_status == 'working' ? 'success' : 'danger'); ?>"><?php echo e($working_status == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>

                        <tr>
                            <td class="w-25">لديه تأمين طبي</td>
                            <td class="w-75 text-<?php echo e($has_medical_insurance == 1 ? 'success' : 'danger'); ?>"><?php echo e($has_medical_insurance == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">لديه رخصة قيادة</td>
                            <td class="w-75 text-<?php echo e($has_driving_license == 1 ? 'success' : 'danger'); ?>" ><?php echo e($has_driving_license == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">الراتب</td>
                            <td class="w-75"> <?php echo e($salary  ? $salary :  0); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25">تكلفةة ساعة الإضافي</td>
                            <td class="w-75"> <?php echo e($overtime_hour_price ? $overtime_hour_price:  0); ?></td>
                        </tr>
                                
                        <tr>
                            <td class="w-25">علي رأس العمل </td>
                            <td class="w-75 text-<?php echo e($working_status == 'working' ? 'success' : 'danger'); ?>"><?php echo e($working_status == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                                
                        <tr>
                            <td class="w-25"> تاريخ الاستقالة - في حالة إنهاء العمل </td>
                            <td class="w-75 ><?php echo e($resignation_date  ? $resignation_date  : 0); ?></td>
                        </tr>
                    </tbody>
                </table>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c)): ?>
<?php $attributes = $__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c; ?>
<?php unset($__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c)): ?>
<?php $component = $__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c; ?>
<?php unset($__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\pharma\resources\views/livewire/users/show-user.blade.php ENDPATH**/ ?>