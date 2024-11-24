<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1>كشف حساب</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('financial_accounts')); ?>">قائمة الحسابات المالية</a></li>
            <li class="breadcrumb-item active">كشف حساب</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <?php 
            $account = App\Models\Account::where('id',$account_id)->first();
        ?>
        <section class="content">
            <div class="container-fluid">
              <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('account-statement.show-account-statement', ['account' => $account]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3666167914-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </section>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/account_statements/show.blade.php ENDPATH**/ ?>