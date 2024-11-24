<?php $__env->startPush('css'); ?>
    <style>
        @media print {
            .barcode {
                width: 200px; /* Adjust the width as desired */
                height: auto; /* Adjust the height proportionally */
            }
        }
    </style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
        <?php
            $product = App\Models\Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','description','category_id','supplier_id','serial_num',
            'unit_id','is_active','size','max_dose','manufactured_date','expiry_date'
            ,'import_date','sale_price','discount_price','fraction','taxes','serial_num','gtin')->where('id',$id)->first();
        ?>
    <div class="content-wrapper" >
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="text-muted"> <?php echo e($product->name); ?></h3>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('product.show',['id' => $product->id])); ?>"><?php echo e($product->name); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(trans('admin.print_code')); ?></li>
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
                                <div class="col-12 mb-2">
                    <div id="print">
                        <div class="d-flex justify-content-center align-items-center barcode">
                            <?php
                                echo DNS1D::getBarcodeSVG($code, 'C39',2,50);
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary float-left mt-3 mr-2" onclick="openPrintPage()">
                            <i class="fas fa-print ml-1"></i>طباعة
                        </button>
                    </div>
                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function openPrintPage() {
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title></head><body>');
            printWindow.document.write(document.getElementById('print').innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/products/print_code.blade.php ENDPATH**/ ?>