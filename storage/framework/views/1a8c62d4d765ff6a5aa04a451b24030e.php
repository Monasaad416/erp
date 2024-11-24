<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th><?php echo e(trans('admin.initial_balance')); ?></th>
            <th><?php echo e(trans('admin.current_financial_year')); ?></th>
            <th><?php echo e(trans('admin.updated_by')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $inventories = App\Models\Inventory::where('product_id', $product->id)
            ->orderBy('current_financial_year', 'ASC')
            ->get()
            ->groupBy(function ($inventory) {
                return $inventory->current_financial_year;
            })
            ->map(function ($group) {
                return $group->first();
            });
        ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="width:2%"><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($inventory->initial_balance); ?></td>
                <td><?php echo e($inventory->current_financial_year); ?></td>
                <td><?php echo e(App\Models\User::where('id',$inventory->updated_by)->first() ? App\Models\User::where('id',$inventory->updated_by)->first()->name : '----'); ?></td>
            </tr>

            
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </tbody>
</table>
<?php /**PATH D:\laragon\www\pharma\resources\views/inc/products/initial_balance.blade.php ENDPATH**/ ?>