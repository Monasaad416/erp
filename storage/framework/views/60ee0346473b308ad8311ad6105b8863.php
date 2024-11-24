<div class="row">
    <div class="col">
        <div class="card">


                                <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">


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
                                                                    <?php echo $__env->make('inc.users.prev_year_salaries', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                                        <?php echo $__env->make('inc.users.prev_year_salaries', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </div>


                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                </div>

                                </div>

                        </div>
        </div>
    </div>








<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/salaries/display-prev-years-salaries.blade.php ENDPATH**/ ?>