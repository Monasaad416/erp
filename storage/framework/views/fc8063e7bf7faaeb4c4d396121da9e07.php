<div>
    <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">


    <?php $__env->stopPush(); ?>

            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                        <?php
                            $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        ?>

                        <div class="col-12 mb-2">
                            <h3 class="text-muted"><?php echo e(trans('admin.invoice_info')); ?></h3>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supp_inv_num"><?php echo e(trans('admin.invoice_number')); ?></label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="supp_inv_num" class="form-control <?php $__errorArgs = ['supp_inv_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.invoice_number')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'supp_inv_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supplier_id"> <?php echo e(trans('admin.select_supplier')); ?></label><span class="text-danger">*</span>
                                <select wire:model="supplier_id" class="form-control  <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option><?php echo e(trans('admin.select_supplier')); ?></option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($supp->id); ?>"><?php echo e($supp->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'supplier_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supp_inv_date_time"><?php echo e(trans('admin.inv_date_time')); ?></label><span class="text-danger">*</span>
                                <input type="datetime-local" wire:model="supp_inv_date_time" class="form-control <?php $__errorArgs = ['supp_inv_date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(trans('admin.inv_date_time')); ?>">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'supp_inv_date_time'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-3 mb-2">
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
                                <label for="transportation_fees">مصروفات النقل (ريال)</label>
                                <input type="number" min="0" step="any" wire:model="transportation_fees" class="form-control <?php $__errorArgs = ['transportation_fees'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="مصروفات النقل">
                                <?php echo $__env->make('inc.livewire_errors', ['property' => 'transportation_fees'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-9 mb-2">
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

                        <table class="table table-bordered" id="supp_inv">
                            <thead class="sticky-top top-0">
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th style="width: 2%"><?php echo e(trans('admin.remove_item')); ?></th>
                                    <th style="width: 9%"><?php echo e(trans('admin.batch_num')); ?></th>
                                    <th style="width: 18%"><?php echo e(trans('admin.product_code')); ?></th>
                                    <th style="width: 18%"><?php echo e(trans('admin.name')); ?></th>
                                    <th style="width: 6%"><?php echo e(trans('admin.unit')); ?></th>
                                    <th style="width: 8%"><?php echo e(trans('admin.sale_price')); ?> بدون ض</th>
                                    <th style="width: 7%"><?php echo e(trans('admin.qty')); ?></th>
                                    <th style="width: 8%"><?php echo e(trans('admin.purchase_price')); ?>للوحدة بدون ض</th>
                                    <th style="width: 8%">الضريبة</th>
                                    <th style="width: 7%">نسبة الربح %</th>
                                    <th style="width: 8%"><?php echo e(trans('admin.wholesale_inc_vat')); ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="width: 10px"><?php echo e($index +1); ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem(<?php echo e($loop->iteration); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                       <td>
                                            <input type="text" wire:model="rows.<?php echo e($index); ?>.batch_num" class="form-control <?php $__errorArgs = ['rows.'.$index.'.batch_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="batch_num_<?php echo e($index); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.batch_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model="rows.<?php echo e($index); ?>.product_code"  wire:keydown.enter.prevent="adjustCode(<?php echo e($index); ?>)" class="form-control inv-fields <?php $__errorArgs = ['rows.'.$index.'.product_code'];
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

                                                    <a target="_blank" href="<?php echo e(route('product.print_code',['id'=>$rows[$index]['product_id'] ,'code' => $rows[$index]['product_code'] ])); ?>">
                                                        <button type="button" class="btn btn-outline-success btn-sm mx-1" title="<?php echo e(trans('admin.print_code')); ?>">
                                                            <i class="fas fa-print"></i>
                                                        </button>
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
                                            <input type="text" wire:model="rows.<?php echo e($index); ?>.unit" readonly class="form-control inv-fields <?php $__errorArgs = ['unit'];
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
                                            <input type="number" min="0" step="any" readonly wire:model="rows.<?php echo e($index); ?>.sale_price" class="form-control inv-fields <?php $__errorArgs = ['sale_price'];
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
    <input type="number" min="0" step="any" wire:model.live="rows.<?php echo e($index); ?>.qty"
           wire:input.blur.debounce.700ms="getTaxes(<?php echo e($index); ?>)" class="form-control inv-fields <?php $__errorArgs = ['qty'];
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
    <input type="number" min="0" step="any" wire:model.defer="rows.<?php echo e($index); ?>.purchase_price"
          <?php echo e($rows[$index]['qty'] == null || $rows[$index]['qty'] == 0 ? 'disabled' :''); ?> 
           wire:input.blur.debounce.700ms="getTaxes(<?php echo e($index); ?>)" class="form-control inv-fields <?php $__errorArgs = ['purchase_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.purchase_price'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <input type="hidden" wire:model="rows.<?php echo e($index); ?>.unit_total">
</td>
                                        <td>
                                            <input type="text" readonly wire:model="rows.<?php echo e($index); ?>.taxes" readonly class="form-control inv-fields <?php $__errorArgs = ['taxes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.taxes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>
                                        <td>
                                            <input type="text" readonly wire:model="rows.<?php echo e($index); ?>.profit_percentage" readonly class="form-control inv-fields <?php $__errorArgs = ['profit_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.profit_percentage'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>


                                        <td>
                                            <input type="number" min="0" step="any" wire:model.live="rows.<?php echo e($index); ?>.wholesale_inc_vat" wire:input.blue.debounce.700ms="calculateUnitPrice(<?php echo e($index); ?>)"
                                            <?php echo e($rows[$index]['qty'] == null || $rows[$index]['qty'] == 0 ? 'disabled' :''); ?> 
                                            wire:change.live="calculateUnitPrice(<?php echo e($index); ?>)" wire:keydown.tab.prevent="focusNextRowInput( <?php echo e($index); ?>)" class="form-control inv-fields <?php $__errorArgs = ['wholesale_inc_vat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php echo $__env->make('inc.livewire_errors', ['property' => 'rows.'.$index.'.wholesale_inc_vat'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </td>

                                        

                                        <script>
                                            window.addEventListener('newRowAdded', event => {
                                             $('.select2bs4').select2();
                                                $(document).ready(function () {
                                                        $('.select2bs4').select2();

                                                        $(document).on('change', '.select2bs4', function (e) {
                                                            var rowIndex = $(this).data('row-index');
                                                            var selectedProductId = $(this).val();
                                                            //console.log(rowIndex);
                                                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('product_name_ar', selectedProductId);
                                                            if (selectedProductId) {
                                                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByName', rowIndex , selectedProductId);
                                                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('fetchByCode', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });

                                            // Livewire.on('cancelKeyUp', () => {
                                            //     clearTimeout(window.keyupTimer);
                                            // });

                                        </script>

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

                <!--[if BLOCK]><![endif]--><?php if($showModal == 1): ?>
                    <?php if (isset($component)) { $__componentOriginal8f022172314b8d99b7c12afc9292b997 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f022172314b8d99b7c12afc9292b997 = $attributes; } ?>
<?php $component = App\View\Components\BankPaymentComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bank-payment-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BankPaymentComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <div class="row">

                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label for="payment_type">إختر البنك</label>
                                    <select wire:model="bank_id" class="form-control <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">إختر البنك</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                    </select>
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'bank_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>

                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label for="check_num">رقم الشيك</label>
                                    <input type="text" wire:model="check_num" class="form-control <?php $__errorArgs = ['check_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="رقم الشيك">
                                    <?php echo $__env->make('inc.livewire_errors', ['property' => 'check_num'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>

                        </div>


                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f022172314b8d99b7c12afc9292b997)): ?>
<?php $attributes = $__attributesOriginal8f022172314b8d99b7c12afc9292b997; ?>
<?php unset($__attributesOriginal8f022172314b8d99b7c12afc9292b997); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f022172314b8d99b7c12afc9292b997)): ?>
<?php $component = $__componentOriginal8f022172314b8d99b7c12afc9292b997; ?>
<?php unset($__componentOriginal8f022172314b8d99b7c12afc9292b997); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="installmentsPayment" class="btn btn-warning mx-2 px-3">دفع أجل </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="cashPayment" class="btn btn-success mx-2 px-3">دفع كاش  </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="bankPayment" class="btn btn-info mx-2 px-3">دفع بشيك   </button>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="pendInvoice" class="btn btn-danger mx-2 px-3">تعليق الفاتورة </button>
                </div>
            </div>


</div>

<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/supplier-invoices/add-invoice222.blade.php ENDPATH**/ ?>