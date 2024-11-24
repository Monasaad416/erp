<div>
    <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
        <style>
            .select2-container {
                width: 90% !important;
                 border-color:#ced4da !important;
            }
         .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color:#ced4da !important;
            width: 90% !important;
            padding:10px 0;
            height:36px;
        }
        /* .form-control {
            font-size:12px !important;
             font-weight:bold !important;
        } */
        </style>

    <?php $__env->stopPush(); ?>
    <form wire:submit.prevent="create">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-12">
                <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                    <?php
                        $stores = App\Models\Store::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                    ?>

                   
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="trans_num">رقم التحويل</label><span class="text-danger">*</span>
                            <input type="text" readonly wire:model="trans_num" class="form-control <?php $__errorArgs = ['trans_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="رقم التحويل">
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'trans_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="trans_date_time">تاريخ وتوقيت التحويل</label><span class="text-danger">*</span>
                            <input type="datetime-local" wire:model="trans_date_time" class="form-control <?php $__errorArgs = ['trans_date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="تاريخ وتوقيت التحويل">
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'trans_date_time'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="to_store_id"> إختر المخزن المطلوب التحويل منه</label><span class="text-danger">*</span>
                            <select wire:model="from_store_id" <?php echo e(Auth::user()->roles_name != 'سوبر-ادمن' ? 'disabled' :''); ?> class="form-control <?php $__errorArgs = ['from_store_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option>إختر المخزن المطلوب التحويل منه</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'from_store_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="to_store_id"> إختر المخزن المطلوب التحويل إلية</label><span class="text-danger">*</span>
                            <select wire:model="to_store_id" class="form-control <?php $__errorArgs = ['to_store_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option>إختر المخزن المطلوب التحويل إلية</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'to_store_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for="description">وصف التحويل</label>
                            <input type="text" wire:model="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="وصف التحويل">
                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'description'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                </div>

                <hr>
                <div class="row">
                    <div class="col-12 mb-2">
                        <h3 class="text-muted">بنود التحويل</h3>
                    </div>

                    <style>
                        .table thead tr th{
                            text-align:center;
                            font-size: 12px;
                        }
                    </style>

                    <table class="table table-bordered" id="supp_inv">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 120px"><?php echo e(trans('admin.product_code')); ?></th>
                                <th style="width: 200px"><?php echo e(trans('admin.name')); ?></th>
                                <th style="width: 70px"><?php echo e(trans('admin.inventory_balance')); ?></th>
                                <th style="width: 70px"><?php echo e(trans('admin.qty')); ?></th>
                                <th style="width: 70px"><?php echo e(trans('admin.unit')); ?></th>
                                <th style="width: 70px">سعر الوحدة</th>
                                <th style="width: 70px">إجمالي السعر</th>
                                <th style="width: 10px">إلغاء البند</th>

                            </tr>
                        </thead>
                        <tbody>
                           <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width: 10px"><?php echo e($index); ?></td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>
                                            <input type="text" wire:model="rows.<?php echo e($index); ?>.product_code"  wire:keydown.enter.prevent="adjustCode(<?php echo e($index); ?>)" class="form-control <?php $__errorArgs = ['rows.'.$index.'.product_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <?php
                                            $productCode = $rows[$index]['product_code'];
                                            $productId = $rows[$index]['product_id'];
                                        ?>
                                        
                                        <div class="d-flex justify-content-between" wire:ignore>
                                            <select wire:model="rows.<?php echo e($index); ?>.product_name_ar" id="select2<?php echo e($index); ?>" data-row-index=<?php echo e($index); ?> data-live-search="true" class="form-control select2bs4 <?php $__errorArgs = ['product_name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option value="">إختر المنتج</option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Product::where('is_active',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product->id); ?>" <?php echo e($product->name_ar == 'rows.'. $index .'.product_name_ar' ? 'selected' : ''); ?> > <?php echo e($product->name_ar); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_name_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                        
                                    </td>
                                    <td>
                                        <input type="number" wire:model="rows.<?php echo e($index); ?>.inventoryFromBalance" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" wire:change.live="calculateTotalPrice(<?php echo e($index); ?>)" wire:model="rows.<?php echo e($index); ?>.qty" class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="rows.<?php echo e($index); ?>.unit" readonly class="form-control <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>

                                    <td>
                                        <input type="number" min="0" step="any" wire:model="rows.<?php echo e($index); ?>.unit_price" class="form-control <?php $__errorArgs = ['unit_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" wire:model="rows.<?php echo e($index); ?>.total_price"  wire:keydown.tab.prevent="focusNextRowInput($event, <?php echo e($index); ?>)" class="form-control <?php $__errorArgs = ['total_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                            data-toggle="modal" wire:click="removeItem(<?php echo e($loop->iteration); ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                    <script>
                                        window.addEventListener('newRowAdded', event => {
                                            // $('.select2bs4').select2();
                                            $(document).ready(function () {
                                                    $('.select2bs4').select2();

                                                    $(document).on('change', '.select2bs4', function (e) {
                                                        var rowIndex = $(this).data('row-index');
                                                        var selectedProductId = $(this).val();
                                                        console.log(rowIndex);
                                                        if (selectedProductId) {
                                                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByName', rowIndex , selectedProductId);
                                                        }
                                                    });
                                            });
                                        });
                                    </script>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit"  class="btn btn-info mx-2"><?php echo e(trans('admin.save')); ?></button>
        </div>
    </form>


<?php $__env->startPush('scripts'); ?>


<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>





</script>
<?php $__env->stopPush(); ?>



</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/stores-transactions/add-store-transaction.blade.php ENDPATH**/ ?>