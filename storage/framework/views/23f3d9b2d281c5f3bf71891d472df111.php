<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> <?php echo e(trans('admin.show_product')); ?></h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('products')); ?>"><?php echo e(trans('admin.products')); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(trans('admin.show_product')); ?></li>
            </ol>
            </div>
            </div>
            </div>
        </section>
        <?php
            $product = App\Models\Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','description','category_id','supplier_id','serial_num',
            'unit_id','is_active','size','max_dose','manufactured_date','expiry_date'
            ,'import_date','sale_price','discount_price','fraction','taxes','serial_num','gtin')->where('id',$id)->first();
        ?>

        <section class="content">
            <div class="container-fluid">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('products.show-product', ['product' => $product]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2438353487-0', $__slots ?? [], get_defined_vars());

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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/products/show.blade.php ENDPATH**/ ?>