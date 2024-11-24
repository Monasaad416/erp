<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('customers.invoices')); ?>">فواتير العملاء</a></li>
            <li class="breadcrumb-item active">الدفع</li>
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
                            

                            <?php
                                // $InvNum_with_prefix = $inv_num;
                                // $InvNum_without_prefix =  str_replace("C-", "", $InvNum_with_prefix);
                                //dd($inv_num);
                                $invoice = App\Models\CustomerInvoice::where('customer_inv_num',$inv_num)->first();
                            ?>

                            <div class="card-body">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('treasury-transactions.add-collection', ['invoice' => $invoice]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2331632769-0', $__slots ?? [], get_defined_vars());

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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/customers/cash_pay_invoice.blade.php ENDPATH**/ ?>