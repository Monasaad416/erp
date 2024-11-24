<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('customers.returns')); ?>">إشعارات الدائن</a></li>
            <li class="breadcrumb-item active">تفاصيل إشعار دائن</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <?php
                $invoiceReturn = App\Models\CustomerReturn::where('serial_num',$return_num)->first();
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            

                            <div class="card-body">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('customer-invoices-returns.show-returns', ['invoiceReturn' => $invoiceReturn]);

$__html = app('livewire')->mount($__name, $__params, 'lw-743287582-0', $__slots ?? [], get_defined_vars());

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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/customers_returns/show_invoice_return.blade.php ENDPATH**/ ?>