<div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>المخزن</th>
                <th>ملاحظات</th>
                <th>الكمية الموردة</th>
                <th>الكمية المنصرفة</th>
                <th>تاريخ وتوقيت الحركة</th>
                <th>رصيد المخزن الحالي </th>
                <th>تكلفة الوحدة</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $inventories = App\Models\Inventory::where('product_id',$product->id)->latest()->get();
            ?>
            <!--[if BLOCK]><![endif]--><?php if($inventories->count() > 0 ): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                 
                <tr>
                    <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($inventory->store->name); ?></td>
                    <td><?php echo e($inventory->notes); ?></td>
                    <td><?php echo e($inventory->in_qty); ?></td>
                    <td><?php echo e($inventory->out_qty); ?></td>
                    <td><?php echo e(Carbon\Carbon::parse($inventory->created_at)->format('Y-m-d')); ?> 
                        <br/>
                        <?php echo e(Carbon\Carbon::parse($inventory->created_at)->format('H:i:s')); ?>

                    </td>
                    <td><?php echo e($inventory->inventory_balance); ?></td>
                    <td><?php echo e($product->sale_price); ?></td>
                    
                    
                    
                </tr>

                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php else: ?>
            <p>لايوجد تحويلات بين المخازن لهذا المنتج</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </tbody>
    </table>
</div><?php /**PATH D:\laragon\www\pharma\resources\views/inc/products/balance_movements.blade.php ENDPATH**/ ?>