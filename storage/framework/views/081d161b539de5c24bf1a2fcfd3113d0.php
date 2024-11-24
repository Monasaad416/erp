<?php $__env->startSection('content'); ?>
            <?php
                $invoice = App\Models\SupplierInvoice::where('id',$id)->first();
            ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('suppliers.invoices')); ?>"><?php echo e(trans('admin.suppliers_invoices')); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(trans('admin.supplier_invoice_details')); ?> <?php echo "&nbsp;"; ?><?php echo e($invoice->supp_inv_num); ?></li>
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
[$__name, $__params] = $__split('supplier-invoices.show-invoice', ['invoice' => $invoice]);

$__html = app('livewire')->mount($__name, $__params, 'lw-4028590489-0', $__slots ?? [], get_defined_vars());

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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/suppliers/show_invoice.blade.php ENDPATH**/ ?>