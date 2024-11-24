<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <?php
            $transaction = App\Models\InventoryTransaction::where('trans_num', $trans_num)->first();
        ?>
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h5> قبول بنود التحويل رقم   <?php echo e($transaction->trans_num); ?> من   <?php echo e($transaction->fromStore->name); ?></h5>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stores.transactions')); ?>">تحويلات المخازن</a></li>
            <li class="breadcrumb-item active">قبول التحويل </li>
            </ol>
            </div>
            </div>
            </div>
        </section>

   

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            

                            <div class="card-body">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('stores-transactions.approve-store-transaction', ['transaction' => $transaction]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3670430907-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>



    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/stores/approve_transaction.blade.php ENDPATH**/ ?>