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
            padding:2% 0;
        }
        .inv-fields {
            font-size:12px !important;
            font-weight:bolder !important;
        }
input {
  display: inline-block;
  min-width: fit-content;
  white-space: nowrap;
  overflow-x: hidden;
}

        </style>

    <?php $__env->stopPush(); ?>
        <form>
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:10px ;border-radius:5px ">
                        <?php
                            $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        ?>

                        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'>الفرع</label><span class="text-danger">*</span>

                                    <select wire:model.live='branch_id' class='form-control  <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>'>
                                        <option value="">إختر الفرع</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Branch::whereNot('id',1)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>

                                </div>
                                <?php echo $__env->make('inc.livewire_errors',['property'=>'branch_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن'  ? 3 : 4); ?> mb-2">
                            <div class="form-group">
                                <label for="customer_inv_num">باركود الفاتورة</label>
                                <input type="text" wire:model="customer_inv_num"  wire:keydown.enter.prevent  class="form-control <?php $__errorArgs = ['customer_inv_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="باركود الفاتورة">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_inv_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>

                        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن'  ? 3 :4); ?>  mb-2">
                            <div class="form-group">
                                <label for="customer_inv_date_time">تاريخ وتوقيت الإشعار</label><span class="text-danger">*</span>
                                <input type="datetime-local" wire:model="customer_inv_date_time" class="form-control <?php $__errorArgs = ['customer_inv_date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.inv_date_time')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_inv_date_time'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>


                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for="customer_phone">هاتف العميل</label>
                                    <input type="text" wire:model.live="customer_phone" wire:change.live="getCustomerName" class="form-control <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="هاتف العميل">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_phone'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-muted">البنود</h3>
                        </div>

                        <style>
                            .table thead tr th{
                                text-align:center;
                                font-size: 12px;
                            }
                        </style>



                        <table class="table table-bordered" id="customer_inv">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <td style="width: 10px">حذف البند</td>
                                    <th style="width: 120px"><?php echo e(trans('admin.product_code')); ?></th>
                                    <th style="width: 200px"><?php echo e(trans('admin.name')); ?></th>
                                    <th style="width: 70px"><?php echo e(trans('admin.inventory_balance')); ?></th>
                                    <th style="width: 70px"><?php echo e(trans('admin.qty')); ?></th>
                                    <th style="width: 70px"><?php echo e(trans('admin.unit')); ?></th>
                                    <th style="width: 70px">قابل للتجزئة</th>
                                    <th style="width: 70px"><?php echo e(trans('admin.sale_price')); ?> بدون ض</th>
                                    <th style="width: 70px">الاجمالي بدون ض</th>
                                    <th style="width: 70px">الضريبة</th>
                                    <th style="width: 70px">الإجمالي شامل الضريبة</th>
                                    <th style="width: 70px">مبلغ العمولة</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="width: 10px"><?php echo e($index + 1); ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem(<?php echo e($loop->iteration); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model.live="rows.<?php echo e($index); ?>.product_code"  wire:keydown.enter.prevent="adjustCode(<?php echo e($index); ?>)" class="newCode form-control inv-fields <?php $__errorArgs = ['rows.'.$index.'.product_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </span>
                                                <?php
                                                    $productCode = $rows[$index]['product_code'];
                                                    $productId = $rows[$index]['product_id'];
                                                ?>

                                                <!--[if BLOCK]><![endif]--><?php if($productCode && $productId): ?>
                                                    <a target="_blank" class="mt-1" href="<?php echo e(route('product.print_code',['id'=>$rows[$index]['product_id'] ,'code' => $rows[$index]['product_code'] ])); ?>">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                        </td>
                                        <td>
                                            <?php
                                                $productCode = $rows[$index]['product_code'];
                                                $productId = $rows[$index]['product_id'];
                                            ?>
                                            <div class="d-flex justify-content-between" wire:ignore>
                                                <!--[if BLOCK]><![endif]--><?php if(!$productCode && !$productId): ?>
                                                    <select id="select2<?php echo e($index); ?>" data-row-index="<?php echo e($index); ?>" data-live-search="true" class="form-control inv-fields select2bs4 <?php $__errorArgs = ['rows.'.$index.'.product_name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:keydown.tab.prevent>
                                                        <option value="">إختر المنتج</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Product::where('is_active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($product->id); ?>" <?php echo e($rows[$index]['product_name_ar'] == $product->id ? 'selected' : ''); ?>><?php echo e($product->name_ar); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </select>
                                                <?php else: ?>
                                                    <input type="text" wire:model="rows.<?php echo e($index); ?>.product_name_ar" class="form-control inv-fields <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['product_name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->"?
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.name_ar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                                    
                                            </div>
                                        </td>
                                         <td>
                                            <input type="text" readonly step="any" wire:model="rows.<?php echo e($index); ?>.inventory_balance" class="form-control inv-fields <?php $__errorArgs = ['inventory_balance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.inventory_balance'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>
                                        <td>
                                            <input type="number" min="0"  step="any" wire:model.live="rows.<?php echo e($index); ?>.qty" wire:change.live="getPrices(<?php echo e($index); ?>)"  class="form-control inv-fields <?php $__errorArgs = ['qty'];
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
                                            <input type="text" wire:model.defer="rows.<?php echo e($index); ?>.unit" readonly class="form-control inv-fields <?php $__errorArgs = ['unit'];
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
                                            <input type="checkbox" wire:model.defer="rows.<?php echo e($index); ?>.fraction" disabled <?php echo e($row['fraction'] ==1 ? 'checked':''); ?> class="form-control inv-fields <?php $__errorArgs = ['rows.<?php echo e($index); ?>.fraction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.fraction'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>
                                        <td>
                                            <input type="text" readonly  wire:model="rows.<?php echo e($index); ?>.sale_price" class="form-control inv-fields <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.sale_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>

                                        <td>
                                            <input type="text" readonly wire:model="rows.<?php echo e($index); ?>.total_without_tax" class="form-control <?php $__errorArgs = ['rows.'.$index.'.total_without_tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:keydown.tab.prevent="focusNextRowInput($event, <?php echo e($index); ?>)" id="total_without_tax_<?php echo e($index); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_without_tax'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>

                                        <td>
                                            <input type="text" readonly wire:model="rows.<?php echo e($index); ?>.tax" class="form-control <?php $__errorArgs = ['rows.'.$index.'.tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:keydown.tab.prevent="focusNextRowInput($event, <?php echo e($index); ?>)" id="tax_<?php echo e($index); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.tax'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>

                                        <td>
                                            <input type="text" readonly  wire:model="rows.<?php echo e($index); ?>.total_with_tax" class="form-control <?php $__errorArgs = ['rows.'.$index.'.total_with_tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:keydown.tab.prevent="focusNextRowInput($event, <?php echo e($index); ?>)" id="total_with_tax_<?php echo e($index); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_with_tax'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>
                                        <td>
                                            <input type="text" readonly  wire:model="rows.<?php echo e($index); ?>.total_commission_rate" class="form-control <?php $__errorArgs = ['rows.'.$index.'.total_commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:keydown.tab.prevent="focusNextRowInput($event, <?php echo e($index); ?>)" id="total_commission_rate_<?php echo e($index); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_commission_rate'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>
                                    </tr>



                                        <script>
                                            window.addEventListener('newRowAdded', event => {
                                             $('.select2bs4').select2();
                                                $(document).ready(function () {
                                                        $('.select2bs4').select2();

                                                        $(document).on('change', '.select2bs4', function (e) {
                                                            var rowIndex = $(this).data('row-index');
                                                            var selectedProductId = $(this).val();
                                                            console.log(rowIndex);
                                                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('product_name_ar', selectedProductId);
                                                            if (selectedProductId) {
                                                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByName', rowIndex , selectedProductId);
                                                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByCode', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });
                                        </script>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                            </tbody>
                        </table>



                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalPrices">المبلغ بدون ضريبة</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalPrices" class="form-control <?php $__errorArgs = ['totalPrices'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.invoice_number')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'totalPrices'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalTaxes">الضريبة</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalTaxes" class="form-control <?php $__errorArgs = ['totalTaxes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.invoice_number')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'totalTaxes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalPricesTaxes">المطلوب</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalPricesTaxes" class="form-control <?php $__errorArgs = ['totalPricesTaxes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.invoice_number')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'totalPricesTaxes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>



                    </div>

                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="returnItems" class="btn btn-info mx-2 px-3">إضافة إشعار</button>
                </div>

        </form>
    <?php $__env->startPush('scripts'); ?>

    <?php $__env->stopPush(); ?>
</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices-returns/add-customer-return.blade.php ENDPATH**/ ?>