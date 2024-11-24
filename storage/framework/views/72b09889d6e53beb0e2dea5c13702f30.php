<div class="modal" id="statistics_modal" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo e(trans('admin.statistics_product')); ?> <?php echo "&nbsp;"; ?>

                    <span class="text-muted" class="text-muted"><?php echo e($name); ?></spn>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo e(trans('admin.item')); ?></th>
                            <th><?php echo e(trans('admin.details')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e(trans('admin.name')); ?></td>
                            <td><?php echo e($name); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.description')); ?></td>
                            <td><?php echo e($description ? $description : '---'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.serial_num')); ?></td>
                            <td><?php echo e($serial_num); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.unit')); ?></td>
                            <td><?php echo e($unit); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.category')); ?></td>
                            <td><?php echo e($category); ?></td>
                        </tr>

                       <tr>
                            <td><?php echo e(trans('admin.size')); ?></td>
                            <td><?php echo e($size); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.max_dose')); ?></td>
                            <td><?php echo e($max_dose); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.manufactured_date')); ?></td>
                            <td><?php echo e($manufactured_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.expiry_date')); ?></td>
                            <td><?php echo e($expiry_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.import_date')); ?></td>
                            <td><?php echo e($import_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.purchase_price')); ?></td>
                            <td><?php echo e($purchase_price); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.sale_price')); ?></td>
                            <td><?php echo e($sale_price); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.discount_price')); ?></td>
                            <td><?php echo e($discount_price); ?></td>
                        </tr>
                                   <tr>
                            <td><?php echo e(trans('admin.inventory_balance')); ?></td>
                            <td><?php echo e($inventory_balance); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.status')); ?></td>
                            <td class="text-<?php echo e($is_active == 1 ? 'success' : 'danger'); ?>"><?php echo e($is_active == 1 ? trans('admin.active') :  trans('admin.inactive')); ?></td>
                        </tr>
                        <tr>
                            <td ><?php echo e(trans('admin.fraction_available')); ?></td>
                            <td class="text-<?php echo e($fraction == 1 ? 'success' : 'danger'); ?>" ><?php echo e($fraction == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                                   <tr>
                            <td><?php echo e(trans('admin.taxable')); ?></td>
                            <td class="text-<?php echo e($taxes == 1 ? 'success' : 'danger'); ?>"> <?php echo e($taxes == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/products/statistics-of-product.blade.php ENDPATH**/ ?>