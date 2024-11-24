
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25"><?php echo e(trans('admin.item')); ?></th>
                            <th class="w-75"><?php echo e(trans('admin.details')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.name')); ?></td>
                            <td class="w-75"><?php echo e($product->name); ?></td>
                        </tr>

                        
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.description')); ?></td>
                            <td class="w-75"><?php echo e($product->description ? $product->description : '---'); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.serial_num')); ?></td>
                            <td class="w-75"><?php echo e($product->serial_num); ?></td>
                        </tr>

                              <tr>
                            <td class="w-25"><?php echo e(trans('admin.unit')); ?></td>
                            <td class="w-75"><?php echo e($product->unit->name); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.category')); ?></td>
                            <td class="w-75"><?php echo e($product->category->name); ?></td>
                        </tr>

                       <tr>
                            <td class="w-25"><?php echo e(trans('admin.size')); ?></td>
                            <td class="w-75"><?php echo e($product->size); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.max_dose')); ?></td>
                            <td class="w-75"><?php echo e($product->max_dose); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.manufactured_date')); ?></td>
                            <td class="w-75"><?php echo e($product->manufactured_date); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.expiry_date')); ?></td>
                            <td class="w-75"><?php echo e($product->expiry_date); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.import_date')); ?></td>
                            <td class="w-75"><?php echo e($product->import_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.purchase_price')); ?></td>
                            <td class="w-75"><?php echo e($product->purchase_price); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(trans('admin.sale_price')); ?></td>
                            <td class="w-75"><?php echo e($product->sale_price); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.discount_price')); ?></td>
                            <td class="w-75"><?php echo e($product->discount_price); ?></td>
                        </tr>

                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.status')); ?></td>
                            <td class="w-75 text-<?php echo e($product->is_active == 1 ? 'success' : 'danger'); ?>"><?php echo e($product->is_active == 1 ? trans('admin.active') :  trans('admin.inactive')); ?></td>
                        </tr>
                        <tr>
                            <td class="w-25"><?php echo e(trans('admin.fraction_available')); ?></td>
                            <td class="w-75 text-<?php echo e($product->fraction == 1 ? 'success' : 'danger'); ?>" ><?php echo e($product->fraction == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                                   <tr>
                            <td class="w-25"><?php echo e(trans('admin.taxable')); ?></td>
                            <td class="w-75 text-<?php echo e($product->taxes == 1 ? 'success' : 'danger'); ?>"> <?php echo e($product->taxes == 1 ? trans('admin.yes') :  trans('admin.no')); ?></td>
                        </tr>
                    </tbody>
                </table>

<?php /**PATH D:\laragon\www\pharma\resources\views/inc/products/details.blade.php ENDPATH**/ ?>