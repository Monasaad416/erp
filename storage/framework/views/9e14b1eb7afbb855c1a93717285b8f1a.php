<div class="modal" id="change_state_modal" wire:ignore.self>
    <form wire:submit.prevent="toggle">
        <?php echo csrf_field(); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(trans('admin.toggle_state')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <p><?php echo e(trans('admin.sure_change_state')); ?> <span class="text-danger"><?php echo e($storeName); ?></span></p>
                    <p class="text-<?php echo e($is_active == 1 ? 'success' : 'danger'); ?> "> <?php echo e(trans('admin.current_state')); ?> <?php echo e($is_active == 1 ? trans('admin.active') : trans('admin.inactive')); ?></p>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores/toggle-store.blade.php ENDPATH**/ ?>