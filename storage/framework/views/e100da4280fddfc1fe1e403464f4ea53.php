<div class="modal" id="return_modal"  wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"><?php echo e(trans('admin.return_all_invoice')); ?></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <form wire:submit.prevent="returnInvoice">
                                                    <?php echo csrf_field(); ?>
                                                        
                                                    <p class="text-danger font-weight-bold my-3">  <?php echo e(trans('admin.sure_return_invoice')); ?></p>
                                                    <h5 class="text"><?php echo e(trans('admin.inv_num')); ?> : <?php echo "&nbsp;"; ?> <?php echo e($customerInvoiceNum); ?></h5>
                             
                                                    
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button"><?php echo e(trans('admin.close')); ?></button>
                                                        <button type="submit" class="btn btn-danger pd-x-20"><?php echo e(trans('admin.confirm')); ?></button>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices-returns/return-invoice.blade.php ENDPATH**/ ?>