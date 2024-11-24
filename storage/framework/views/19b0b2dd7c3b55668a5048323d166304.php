<?php $__env->startPush('css'); ?>
    <style>
        @media print {
            /* body {
            -webkit-print-color-adjust: exact !important;
              -webkit-print-color-adjust:exact !important;
            -webkit-print-color-adjust:exact !important;
            } */
            #print_button {
                display: none;
            }
        }
        .table thead th  {
            text-align: center;
        }
    </style>
    <style media="print" type="text/css">
        .inv_total td {
            background-color: gray !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> منتجات العمولة</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('products')); ?>"><?php echo e(trans('admin.products')); ?></a></li>
            <li class="breadcrumb-item active">منتجات العمولة</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('commissions.display-commissions', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-302076308-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </section>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('commissions.add-commission', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-302076308-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('commissions.delete-commission', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-302076308-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('commissions.update-commission', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-302076308-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/products/commissions.blade.php ENDPATH**/ ?>