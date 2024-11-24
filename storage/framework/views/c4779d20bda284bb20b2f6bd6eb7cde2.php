<div class="container-fluid">
    <style>
        .modal-dialog {
            width: 500px;
        }
    </style>
    <div class="row my-auto">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>قائمة السنوات المالية</h3>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal"  title="إضافة سنة جديدة">
                           إضافة سنة
                        </button>
                    </div>

                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>السنة المالية</th>
                            
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>الحالة</th>
                            <th>الإضافة بواسطة</th>
                            <th>التعديل بواسطة</th>
                            <th>الشهور المالية</th>
                            <th>الحالة</th>
                            <th>تعديل</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($year->year); ?></td>
                                
                                <td><?php echo e($year->start_date); ?></td>
                                <td><?php echo e($year->end_date); ?></td>
                                <td><?php echo e($year->is_opened); ?></td>
                                <td><?php echo e($year->createdBy ? $year->createdBy->name : '---'); ?></td>
                                <td><?php echo e($year->updatedBy ? $year->createdBy->name : '---'); ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#show_year_<?php echo e($year->id); ?>" class="btn btn-sm btn-warning" title="عرض الشهور المالية للسنة">
                                        <i class="fa fa-eye" style="color: #fff";></i>
                                    </a>

                                    <!-- Show year modal  -->
                                    <div class="modal fade" id="show_year_<?php echo e($year->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="exampleModalLabel" >عرض الشهور للسنة المالية : <span class="text-muted"  ><?php echo e($year->year); ?></span> </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body" style="width: 100%">
                                                <table class="table table-bordered">
                                                    <thead  class="bg_table_head">
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>إسم الشهر</th>
                                                            <th> رقم الشهر </th>
                                                            <th> عدد أيام الشهر </th>
                                                            <th>بداية الشهر</th>
                                                            <th>نهاية الشهر</th>
                                                            <th>الإضافة بواسطة</th>
                                                            <th>التعديل بواسطة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--[if BLOCK]><![endif]--><?php if(isset($year->months)): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $year->months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($loop->iteration); ?></td>
                                                                    <td><?php echo e($month->month_name); ?></td>
                                                                    <td><?php echo e($month->month_id); ?></td>
                                                                    <td><?php echo e($month->no_of_days); ?></td>
                                                                    <td><?php echo e($month->start_date); ?></td>
                                                                    <td><?php echo e($month->end_date); ?></td>
                                                                    <td><?php echo e($month->createdBy ? $month->createdBy->name : '---'); ?></td>
                                                                    <td><?php echo e($month->updatedBy ? $month->createdBy->name : '---'); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#change-state-<?php echo e($year->id); ?>" class="btn btn-sm btn-<?php echo e($year->is_opened == true ? 'success' : 'secondary'); ?> mx-1" title="<?php echo e($year->is_active == 1 ? 'حالية' : 'مغلقة'); ?>">
                                        <i class="fa fa-toggle-<?php echo e($year->is_opened == 1 ? 'on' : 'off'); ?>" style="color: #fff";></i>
                                    </a>
                                    <!-- Change state modal  -->
                                    
                                        <div class="modal fade" id="change-state-<?php echo e($year->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">تغيير حالة الفرع</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                        <p>هل انت متأكد من تغيير حالة السنة المالية </p>
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" value="<?php echo e($year->id); ?>" name="year_id">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                            <button type="submit" name="submit" class="btn btn-info">تعديل</button>
                                                        </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    

                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                        data-toggle="modal"
                                        wire:click="$dispatch('editYear',{id:<?php echo e($year->id); ?>})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>




                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-muted font-weight-bold">لا يوجد بيانات للعرض</td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                    </tbody>
                    </table>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/financial-years/display-years.blade.php ENDPATH**/ ?>