<?php if (isset($component)) { $__componentOriginaldff28b3aa87c5f2402f1751261e8a88f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldff28b3aa87c5f2402f1751261e8a88f = $attributes; } ?>
<?php $component = App\View\Components\DeleteModalComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('delete-modal-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DeleteModalComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="modal-header">
            <h5 class="tx-danger mg-b-20 mx-3 my-3"><?php echo e(trans('admin.delete_customer_from_list')); ?></h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>


        </div>
        <div class="modal-body">

            <p><?php echo e(trans('admin.confirm_delete')); ?> <?php echo "&nbsp;"; ?><?php echo e($customerName); ?> </p>

                <div class="form-row">
                    <div class="col">
                        <input type="hidden" wire:model="productId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
                    <button type="submit" class="btn btn-danger">
                        <span wire:loading.remove>
                            <?php echo e(trans('admin.delete')); ?>

                        </span>

                        <div class="text-center" wire:loading wire:target="delete">
                            <div class="spinner-border text-warning" role="status">
                                <span class="sr-only">جاري التنفيذ ...</span>
                            </div>
                        </div>
                    </button>
                </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldff28b3aa87c5f2402f1751261e8a88f)): ?>
<?php $attributes = $__attributesOriginaldff28b3aa87c5f2402f1751261e8a88f; ?>
<?php unset($__attributesOriginaldff28b3aa87c5f2402f1751261e8a88f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldff28b3aa87c5f2402f1751261e8a88f)): ?>
<?php $component = $__componentOriginaldff28b3aa87c5f2402f1751261e8a88f; ?>
<?php unset($__componentOriginaldff28b3aa87c5f2402f1751261e8a88f); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customers/delete-customer.blade.php ENDPATH**/ ?>