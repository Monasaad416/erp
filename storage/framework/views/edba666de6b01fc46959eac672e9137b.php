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
                                                    <h5 class="text"><?php echo e(trans('admin.inv_num')); ?> : <?php echo "&nbsp;"; ?> <?php echo e($supplierInvoiceNum); ?></h5>
                             
                                                    <div class="row">
                                                        <div class="col-<?php echo e($return_payment_type == 'by_check' ? 6 : 12); ?>">
                                                            <select wire:model.live="return_payment_type" class="form-control <?php $__errorArgs = ['return_payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                <option>طريقة إسترداد المبلغ</option>
                                                                <option value="cash">استرداد كامل المبلغ نقدا</option>
                                                                <option value="by_check">استرداد كامل المبلغ بشيك</option>
                                                                <option value="by_installments">اجل</option>
                                                            </select>
                                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'return_payment_type'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                        <!--[if BLOCK]><![endif]--><?php if($return_payment_type == 'by_check'): ?>
                                                        <div class="col">
                                                            <select wire:model.live="bank_id" class="form-control <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                <option>إختر البنك</option>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'bank_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
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
<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/supplier-invoices-returns/return-invoice.blade.php ENDPATH**/ ?>