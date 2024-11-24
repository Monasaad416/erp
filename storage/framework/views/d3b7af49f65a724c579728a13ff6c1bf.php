<div class="modal" id="delete_modal" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content tx-size-sm">
           
                <form wire:submit.prevent="delete">
                    <?php echo csrf_field(); ?>
                     
                     <?php echo e($slot); ?>

                </form>
            
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\pharma\resources\views/components/delete-modal-component.blade.php ENDPATH**/ ?>