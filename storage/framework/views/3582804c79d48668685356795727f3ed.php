<div class="modal" id="change_state_modal" wire:ignore.self>
    <form wire:submit.prevent="changeApprovalState">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(trans('admin.change_approval_state')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <p><?php echo e(trans('admin.sure_change_approval_state')); ?> <span class="text-danger"><?php echo e($suppInvNum); ?></span></p>
                    <p class="text-<?php echo e($is_approved == 1 ? 'success' : 'danger'); ?> "> <?php echo e(trans('admin.current_state')); ?> <?php echo e($is_approved == 1 ? trans('admin.is_approved') : trans('admin.not_approved_yet')); ?></p>
                    <?php echo csrf_field(); ?>
                  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
                        <button type="submit" name="submit" class="btn btn-info"><?php echo e(trans('admin.edit')); ?></button>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/supplier-invoices/approve-invoice.blade.php ENDPATH**/ ?>