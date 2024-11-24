<div class="modal" id="edit_modal" wire:ignore.self>
    <form wire:submit.prevent="update">
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
                    <button type="submit" class="btn btn-secondary" wire:loading.attr="disabled">
                        <span wire:loading wire:target="update">
                            <div class="text-center">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="sr-only">جاري التنفيذ ...</span>
                                </div>
                            </div>
                        </span>
                        <span wire:loading.remove><?php echo e(trans('admin.edit')); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div><?php /**PATH D:\laragon\www\pharma\resources\views/components/update-modal-component.blade.php ENDPATH**/ ?>