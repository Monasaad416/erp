
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> حركات نقدية الخزينة</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('treasury.transactions')); ?>">حركات نقدية الخزينة</a></li>
            <li class="breadcrumb-item active"> إضافة حركة  </li>
            </ol>
            </div>
            </div>
            </div>
        </section>


        <?php
            $previousUrl = url()->previous();
            $path = parse_url($previousUrl, PHP_URL_PATH);
            $segments = explode('/', $path);
            $desiredSegment = implode('/', array_slice($segments, 2,2));
            if ($desiredSegment == "suppliers/invoices") {
                $invoice = App\MOdels\SupplierInvoice::where('supp_inv_num',$inv_num)->first();
            }elseif ($desiredSegment == "customers/invoices") {
                $invoice = App\MOdels\CustomerInvoice::where('customer_inv_num',$inv_num)->first();
            }
        ?>    

        <section class="content">
            <div class="container-fluid">
                <?php
                    $segment = request()->segment(3);
                    $exchange = false;
                    $collection = false;
                    if($segment == 'exchange-receipts') {
                        $exchange = true;
                    }
                    if($segment == 'collection-receipts') {
                        $collection = true;
                    }

                ?>
                <?php if($exchange == true): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('treasury-transactions.add-exchange', ['invoice' => $invoice ?? '']);

$__html = app('livewire')->mount($__name, $__params, $invoice ?? '', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php elseif($collection == true): ?>   
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('treasury-transactions.add-collection', ['invoice' => $invoice ?? '']);

$__html = app('livewire')->mount($__name, $__params, $invoice ?? '', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php endif; ?>
            </div>
        </section>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/treasury_transactions/create.blade.php ENDPATH**/ ?>