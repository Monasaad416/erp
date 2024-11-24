<div class="modal" id="create_modal" wire:ignore.self>
    <form wire:submit.prevent="create">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo e($title); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?php echo e($slot); ?>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo e(trans('admin.save')); ?></button>
                </div>
            </div>

        </div>
    </form>
</div><?php /**PATH D:\laragon\www\pharma\resources\views/components/create-modal-component.blade.php ENDPATH**/ ?>