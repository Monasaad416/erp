<?php
    if(Auth::user()->roles_name == 'سوبر-ادمن'){
        $users = App\Models\User::where('branch_id',$branch->id)->get();
    }else {
        $users = App\Models\User::where('branch_id',$branch->id)->get();
    }

?>
<style>
    .custom_button {
        background-color: rgb(198, 193, 193) !important;
    }
</style>


<!--[if BLOCK]><![endif]--><?php if($users->count() > 0): ?>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $href = str_replace(' ', '_', $user->name);
        ?>
        <p>


            <a class="btn btn-block custom_button collapsed" data-toggle="collapse" href="#<?php echo e($href); ?>" role="button" aria-expanded="false" aria-controls="<?php echo e($href); ?>">
                <?php echo e($user->name); ?>

            </a>
        </p>
        <?php
           $currentFinancialYear = App\Models\FinancialYear::where('year',Carbon\Carbon::now()->format('Y'))->first();
            $currentFinancialMonth = App\Models\FinancialMonth::where('month_id',Carbon\Carbon::now()->format('m'))->first();
            $salary = App\Models\Salary::where('user_id', $user->id)->where('financial_year_id',$currentFinancialYear->id)->where('financial_month_id',$currentFinancialMonth->id)->first();
            //dd($user);
        ?>

        <div class="collapse" id="<?php echo e($href); ?>">
            <div class="card card-body">
                <style>
                    .table thead tr th ,tr{
                        text-align:center;
                    }
                </style>

                    <?php echo csrf_field(); ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>الاساسي</th>
                            <th>الاضافي </th>
                            <th>بدل السكن  </th>
                            <th>بدل الانتقالات</th>
                            <th>مكافئات</th>
                            <th>عمولة مبيعات</th>
                            <th>خصومات تأخير</th>
                            <th>خصم التأمين الطبي</th>
                            <th>خصومات السلف </th>
                            <th>خصومات اخري</th>
                            <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>
                                        <?php echo e($salary ?  $salary->salary : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ?  $salary->total_overtime : 0); ?>

                                    </td>
                                    <td>
                                       <?php echo e($salary ? $salary->housing_allowance : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->transfer_allowance : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->rewards : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->total_commission_rate : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->total_delay : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->medical_insurance_deduction : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->advance_payment_deduction : 0); ?>

                                    </td>
                                    <td>
                                        <?php echo e($salary ? $salary->deductions : 0); ?>

                                    </td>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php if($salary): ?>
                                        <?php echo e($salary->salary + $salary->total_overtime + $salary->housing_allowance + $salary->transfer_allowance
                                        +$salary->rewards + $salary->total_commission_rate -$salary->total_delay - $salary->medical_insurance_deduction - $salary->advance_payment_deduction
                                        -$salary->deductions); ?>

                                        <?php else: ?>
                                            0
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                </tr>


                        </tbody>
                    </table>

                </form>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
<?php else: ?>
        <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH D:\laragon\www\pharma\resources\views/inc/users/current_year_salaries.blade.php ENDPATH**/ ?>