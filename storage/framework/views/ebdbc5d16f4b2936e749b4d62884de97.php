<div>
    <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
        <style>
     

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
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color:red !important;
        }
        </style>
  

    <?php $__env->stopPush(); ?>
        <form wire:submit.prevent="create">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                        <?php
                            $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        ?>


                        <div class="col-12 mb-2">
                            <h3 class="text-muted"><?php echo e(trans('admin.invoice_info')); ?></h3>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'>الفرع</label><span class="text-danger">*</span>

                                    <select wire:model.live='branch_id' wire:change.live="getNextCustomerInvNum" class='form-control  <?php $__errorArgs = ['branch_id'];
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
                                <label for="customer_inv_num"><?php echo e(trans('admin.invoice_number')); ?></label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="customer_inv_num" class="form-control <?php $__errorArgs = ['customer_inv_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.invoice_number')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_inv_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        
                        
                        <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن'  ? 3 :4); ?>  mb-2">
                            <div class="form-group">
                                <label for="customer_inv_date_time"><?php echo e(trans('admin.inv_date_time')); ?></label><span class="text-danger">*</span>
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
                         <div class="col-<?php echo e(Auth::user()->roles_name == 'سوبر-ادمن'  ? 3 :4); ?> mb-2">
                            <div class="form-group">
                                <label for="discount_percentage"><?php echo e(trans('admin.discount_percentage')); ?> %</label>
                                <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control <?php $__errorArgs = ['discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.discount_percentage')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'discount_percentage'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for="customer_name">إسم العميل</label>
                                    <input type="text" wire:model="customer_name" class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="إسم العميل">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'customer_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

                        <div class="col-<?php echo e($payment_type == 'by_installments' ? 6 :6); ?> mb-2">
                            <div class="form-group">
                                <label for="notes"><?php echo e(trans('admin.notes')); ?></label>
                                <input type="text" wire:model="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.notes')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'notes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-muted"><?php echo e(trans('admin.invoice_items')); ?></h3>
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
                                    <th style="width: 1%">#</th>
                                    <td style="width: 2%">حذف البند</td>
                                    <th style="width: 17%"><?php echo e(trans('admin.product_code')); ?></th>
                                    <th style="width: 17%"><?php echo e(trans('admin.name')); ?></th>
                                    <th style="width: 8%"><?php echo e(trans('admin.inventory_balance')); ?></th>
                                    <th style="width: 8%"><?php echo e(trans('admin.qty')); ?></th>
                                    <th style="width: 7%"><?php echo e(trans('admin.unit')); ?></th>
                                    <th style="width: 2%">قابل للتجزئة</th>
                                    <th style="width: 8%"><?php echo e(trans('admin.sale_price')); ?> بدون ض</th>
                                    <th style="width: 8%">الاجمالي بدون ض</th>
                                    <th style="width: 8%">الضريبة</th>
                                    <th style="width: 8%">الإجمالي شامل الضريبة</th>
                                    <th style="width: 6%">مبلغ العمولة</th>
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

                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="installmentsPayment" class="btn btn-warning mx-2 px-3">دفع أجل </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="cashPayment" class="btn btn-success mx-2 px-3">دفع كاش  </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="visaPayment" class="btn btn-info mx-2 px-3">دفع بالفيزا  </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="pendInvoice" class="btn btn-danger mx-2 px-3">تعليق الفاتورة </button>
                </div>
        </form>
    <?php $__env->startPush('scripts'); ?>
        <script>
            window.addEventListener('newRowAdded', event => {
                $('.select2bs4').select2();
                $(document).ready(function () {
                        $('.select2bs4').select2();

                        $(document).on('change', '.select2bs4', function (e) {
                            var rowIndex = $(this).data('row-index');
                            var selectedProductId = $(this).val();
                            console.log(selectedProductId);
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('product_id', selectedProductId);
                            if (selectedProductId) {
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByName', rowIndex , selectedProductId);
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByCode', rowIndex , selectedProductId);
                            }
                        });
                });
            });
            // window.addEventListener('load', event => {

            //     $(document).ready(function () {
            //         $(document).on('change', '.new_code', function (e) {
            //             var rowIndex = $(this).data('row-index');
            //             console.log(rowIndex);

            //             window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByCode', rowIndex );

            //         });
            //     });
            // });
        </script>

    <?php $__env->stopPush(); ?>
</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices/add-invoice.blade.php ENDPATH**/ ?>