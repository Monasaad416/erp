

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4 text-danger"><?php echo e($product->name); ?></h4>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false"><?php echo e(trans('admin.details')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-codes-tab" data-toggle="pill" href="#custom-tabs-four-codes" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false"><?php echo e(trans('admin.product_codes')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><?php echo e(trans('admin.transaction')); ?></a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="true"><?php echo e(trans('admin.initial_balance')); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                    <?php echo $__env->make('inc.products.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-codes" role="tabpanel" aria-labelledby="custom-tabs-four-codes-tab">
                                    <?php echo $__env->make('inc.products.codes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                    <?php echo $__env->make('inc.products.balance_movements', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                
                                <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                    <?php echo $__env->make('inc.products.initial_balance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>







<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/products/show-product.blade.php ENDPATH**/ ?>