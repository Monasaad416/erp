<div class="row">
    <div class="col">
        <div class="card">
           <div class="card-header p-0 border-bottom-0">
                        <?php
                            $currentYear = Carbon\Carbon::now()->format('Y');
                            $currentMonthNo = Carbon\Carbon::now()->format('m');
                            $currentFinancialYear = App\Models\FinancialYear::where('year',$currentYear)->first();
                            $currentFinancialMonth = App\Models\FinancialMonth::where('month_id',$currentMonthNo)->first();
                            //dd($currentFinancialYear->months);
                        ?>
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentFinancialYear->months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($month->month_id == $currentMonthNo ? 'active' : ''); ?> text-<?php echo e($month->month_id == $currentMonthNo ? 'suceess' : 'cyan'); ?>"  id="custom-tabs-four-<?php echo e($month->month_name); ?>-tab" data-toggle="pill" href="#custom-tabs-four-<?php echo e($month->month_name); ?>" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false"><?php echo e($month->month_name); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                        </div>
             
                            <form wire:submit.prevent="update">
                                <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentFinancialYear->months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentMonth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php echo e($currentMonth->month_id == $currentMonthNo ? 'active show' : ''); ?>" id="custom-tabs-four-<?php echo e($currentMonth->month_name); ?>" role="tabpanel" aria-labelledby="custom-tabs-four-<?php echo e($currentMonth->month_name); ?>-tab">

                                            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::select('id',
                                                        'name_'.LaravelLocalization::getCurrentLocale().' as name')->whereNot('id',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    
                                                            <p>
                                                                <a class="btn btn-block btn-info" data-toggle="collapseBranch" href="#<?php echo e($branch->name); ?>" role="button" aria-expanded="false" aria-controls="<?php echo e($branch->name); ?>">
                                                                    <?php echo e($branch->name); ?>

                                                                </a>
                                                            </p>

                                                            <div class="collapseBranch" id="<?php echo e($branch->name); ?>">
                                                                <div class="card card-body">
                                                                    <?php echo $__env->make('inc.users.current_year_salaries', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            </div>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <?php
                                                    $branch = App\Models\Branch::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',Auth::user()->branch_id)->first();
                                                ?>

                                                <p>
                                                    <a class="btn btn-block btn-info" data-toggle="collapse" href="#<?php echo e($branch->name); ?>" role="button" aria-expanded="false" aria-controls="<?php echo e($branch->name); ?>">
                                                        <?php echo e($branch->name); ?>

                                                    </a>
                                                </p>

                                                <div class="collapse" id="<?php echo e($branch->name); ?>">
                                                    <div class="card card-body">
                                                        <?php echo $__env->make('inc.users.current_year_salaries', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </div>


                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
                                    <button type="submit" name="submit" class="btn btn-info"><?php echo e(trans('admin.edit')); ?></button>
                                </div>
                                </div>
                            </form>
                        </div>
        </div>
    </div>








<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/salaries/display-current-year-salaries.blade.php ENDPATH**/ ?>