<?php if (isset($component)) { $__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c = $attributes; } ?>
<?php $component = App\View\Components\ShowModalComponent::resolve(['title' => ' إهلاكات الأصل الثابت'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('show-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ShowModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

            <div class="card-body">

                <!--[if BLOCK]><![endif]--><?php if($depreciations): ?>


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <h5 class="text-success"><?php echo e($assetName); ?></h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">تاريخ الإهلاك</th>
                                <th scope="col">قيمة الإهلاك</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $depreciations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr wire:key="entry-<?php echo e($dep->id); ?>">
                                    <td><?php echo e($loop->iteration); ?></td>
                                    
                                    <td><span class="text-dark"><?php echo e($dep->date); ?></span> </td>
                                    <td><span class="text-dark"><?php echo e($dep->amount); ?></span> </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                

            </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c)): ?>
<?php $attributes = $__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c; ?>
<?php unset($__attributesOriginal2c1395ed2b81e2b254faecc6e70bb50c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c)): ?>
<?php $component = $__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c; ?>
<?php unset($__componentOriginal2c1395ed2b81e2b254faecc6e70bb50c); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\pharma\resources\views/livewire/asset/show-asset.blade.php ENDPATH**/ ?>