<div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">


    @endpush

            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                        @php
                            $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        @endphp

                        <div class="col-12 mb-2">
                            <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supp_inv_num">{{ trans('admin.invoice_number') }}</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="supp_inv_num" class="form-control @error('supp_inv_num') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                                @include('inc.livewire_errors', ['property' => 'supp_inv_num'])
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supplier_id"> {{trans('admin.select_supplier')}}</label><span class="text-danger">*</span>
                                <select wire:model="supplier_id" class="form-control  @error('supplier_id') is-invalid @enderror">
                                    <option>{{trans('admin.select_supplier')}}</option>
                                    @foreach($suppliers as $supp)
                                        <option value="{{$supp->id}}">{{$supp->name}}</option>
                                    @endforeach
                                </select>
                                @include('inc.livewire_errors', ['property' => 'supplier_id'])
                                {{-- <button type="button" class="btn bg-gradient-success" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                    <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                </button> --}}
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="supp_inv_date_time">{{ trans('admin.inv_date_time') }}</label><span class="text-danger">*</span>
                                <input type="datetime-local" wire:model="supp_inv_date_time" class="form-control @error('supp_inv_date_time') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                                @include('inc.livewire_errors', ['property' => 'supp_inv_date_time'])
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="discount_percentage">{{ trans('admin.discount_percentage') }} %</label>
                                <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control @error('discount_percentage') is-invalid @enderror" placeholder="{{ trans('admin.discount_percentage') }}">
                                @include('inc.livewire_errors', ['property' => 'discount_percentage'])
                            </div>
                        </div>
                        {{-- {{ $payment_type == "by_check" ? '4':'10' }} --}}
                        {{-- <div class="col-4  mb-2">
                            <div class="form-group">
                                <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                                <select wire:model="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                    <option>{{trans('admin.select_payment_type')}}</option>
                                    <option value="cash">دفع كامل المبلغ نقدا</option>
                                    <option value="by_check">دفع كامل المبلغ بشيك</option>
                                    <option value="by_installments">اجل</option>
                                </select>
                                @include('inc.livewire_errors', ['property' => 'payment_type'])
                            </div>
                        </div> --}}
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="transportation_fees">مصروفات النقل (ريال)</label>
                                <input type="number" min="0" step="any" wire:model="transportation_fees" class="form-control @error('transportation_fees') is-invalid @enderror" placeholder="مصروفات النقل">
                                @include('inc.livewire_errors', ['property' => 'transportation_fees'])
                            </div>
                        </div>
                        <div class="col-9 mb-2">
                            <div class="form-group">
                                <label for="notes">{{ trans('admin.notes') }}</label>
                                <input type="text" wire:model="notes" class="form-control @error('notes') is-invalid @enderror" placeholder="{{ trans('admin.notes') }}">
                                @include('inc.livewire_errors', ['property' => 'notes'])
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-muted">{{trans('admin.invoice_items')}}</h3>
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
                                    <th style="width: 2%">{{ trans('admin.remove_item') }}</th>
                                    <th style="width: 9%">{{ trans('admin.batch_num') }}</th>
                                    <th style="width: 18%">{{ trans('admin.product_code') }}</th>
                                    <th style="width: 18%">{{ trans('admin.name') }}</th>
                                    <th style="width: 6%">{{ trans('admin.unit') }}</th>
                                    <th style="width: 8%">{{ trans('admin.sale_price') }} بدون ض</th>
                                    <th style="width: 7%">{{ trans('admin.qty') }}</th>
                                    <th style="width: 8%">{{ trans('admin.purchase_price') }}للوحدة بدون ض</th>
                                    <th style="width: 8%">الضريبة</th>
                                    <th style="width: 7%">نسبة الربح %</th>
                                    <th style="width: 8%">{{ trans('admin.wholesale_inc_vat') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td style="width: 10px">{{ $index +1 }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                       <td>
                                            <input type="text" wire:model="rows.{{ $index }}.batch_num" class="form-control @error('rows.'.$index.'.batch_num') is-invalid @enderror" id="batch_num_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.batch_num'])
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model="rows.{{ $index }}.product_code"  wire:keydown.enter.prevent="adjustCode({{ $index }})" class="form-control inv-fields @error('rows.'.$index.'.product_code') is-invalid @enderror">
                                                @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'])
                                                </span>
                                                @php
                                                    $productCode = $rows[$index]['product_code'];
                                                    $productId = $rows[$index]['product_id'];
                                                @endphp

                                                @if($productCode && $productId)

                                                    <a target="_blank" href="{{ route('product.print_code',['id'=>$rows[$index]['product_id'] ,'code' => $rows[$index]['product_code'] ]) }}">
                                                        <button type="button" class="btn btn-outline-success btn-sm mx-1" title="{{trans('admin.print_code')}}">
                                                            <i class="fas fa-print"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>



                                            {{-- <input type="hidden" wire:model="rows.{{ $index }}.product_id"> --}}
                                            {{-- <button type="button" class="btn btn-outline-success btn-sm mx-1" title="{{ trans('admin.print_product_code') }}"
                                                data-toggle="modal"
                                                wire:click="$dispatch('printProductCode', { id: {{ $rows[$index]['product_id'] }}, code: {{ $rows[$index]['product_code'] }}})">
                                                <i class="fas fa-print"></i>
                                            </button> --}}


                                            {{-- <button type="button" class="btn btn-outline-success btn-sm mx-1" title="{{ trans('admin.print_product_code') }}"
                                                data-toggle="modal"
                                                wire:click="$dispatch('printProductCode', { id: {{ $rows[$index]['product_id'] }}, code: {{ $rows[$index]['product_code'] }}})">
                                                <i class="fas fa-print"></i>
                                            </button> --}}
                                        </td>


                                        <td>
                                            @php
                                                $productCode = $rows[$index]['product_code'];
                                                $productId = $rows[$index]['product_id'];
                                            @endphp
                                            <div class="d-flex justify-content-between" wire:ignore>
                                                @if(!$productCode && !$productId)
                                                    <select id="select2{{$index}}" data-row-index="{{$index}}" data-live-search="true" class="form-control inv-fields select2bs4 @error('rows.'.$index.'.product_name_ar') is-invalid @enderror" wire:keydown.tab.prevent>
                                                        <option value="">إختر المنتج</option>
                                                        @foreach(App\Models\Product::where('is_active', 1)->get() as $product)
                                                            <option value="{{$product->id}}" {{ $rows[$index]['product_name_ar'] == $product->id ? 'selected' : '' }}>{{$product->name_ar}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" wire:model="rows.{{ $index }}.product_name_ar" class="form-control inv-fields @error('product_name_ar') is-invalid @enderror"?
                                                @endif

                                                    @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.name_ar'])

                                                    {{-- <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}" data-toggle="modal" wire:click="$emit('updateProduct', {{ $rows[$index]['product_id'] }})">
                                                        <i class="far fa-edit"></i>
                                                    </button> --}}
                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" wire:model="rows.{{ $index }}.unit" readonly class="form-control inv-fields @error('unit') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="any" readonly wire:model="rows.{{ $index }}.sale_price" class="form-control inv-fields @error('sale_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.sale_price'])
                                        </td>
<td>
    <input type="number" min="0" step="any" wire:model.live="rows.{{ $index }}.qty"
           wire:input.blur.debounce.700ms="getTaxes({{ $index }})" class="form-control inv-fields @error('qty') is-invalid @enderror">
    @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'])
</td>
<td>
    <input type="number" min="0" step="any" wire:model.defer="rows.{{ $index }}.purchase_price"
          {{  $rows[$index]['qty'] == null || $rows[$index]['qty'] == 0 ? 'disabled' :''}} 
           wire:input.blur.debounce.700ms="getTaxes({{ $index }})" class="form-control inv-fields @error('purchase_price') is-invalid @enderror">
    @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.purchase_price'])
    <input type="hidden" wire:model="rows.{{ $index }}.unit_total">
</td>
                                        <td>
                                            <input type="text" readonly wire:model="rows.{{ $index }}.taxes" readonly class="form-control inv-fields @error('taxes') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.taxes'])
                                        </td>
                                        <td>
                                            <input type="text" readonly wire:model="rows.{{ $index }}.profit_percentage" readonly class="form-control inv-fields @error('profit_percentage') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.profit_percentage'])
                                        </td>


                                        <td>
                                            <input type="number" min="0" step="any" wire:model.live="rows.{{ $index }}.wholesale_inc_vat" wire:input.blue.debounce.700ms="calculateUnitPrice({{ $index }})"
                                            {{  $rows[$index]['qty'] == null || $rows[$index]['qty'] == 0 ? 'disabled' :''}} 
                                            wire:change.live="calculateUnitPrice({{ $index }})" wire:keydown.tab.prevent="focusNextRowInput( {{ $index }})" class="form-control inv-fields @error('wholesale_inc_vat') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.wholesale_inc_vat'])
                                        </td>

                                        {{-- <td>
                                            <input type="text" wire:model="rows.{{ $index }}.batch_num" class="form-control inv-fields @error('batch_num') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.batch_num'])
                                        </td> --}}

                                        <script>
                                            window.addEventListener('newRowAdded', event => {
                                             $('.select2bs4').select2();
                                                $(document).ready(function () {
                                                        $('.select2bs4').select2();

                                                        $(document).on('change', '.select2bs4', function (e) {
                                                            var rowIndex = $(this).data('row-index');
                                                            var selectedProductId = $(this).val();
                                                            //console.log(rowIndex);
                                                            @this.set('product_name_ar', selectedProductId);
                                                            if (selectedProductId) {
                                                                @this.call('fetchByName', rowIndex , selectedProductId);
                                                                @this.call('fetchByCode', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });

                                            // Livewire.on('cancelKeyUp', () => {
                                            //     clearTimeout(window.keyupTimer);
                                            // });

                                        </script>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- <div class="col-12 my-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:rgb(221, 58, 58)">
                                        <input type="checkbox" class="" wire:model="is_pending" >
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{trans('admin.pend_invoice')}}" style="color:white;background-color:rgb(221, 58, 58)">
                            </div>
                            @include('inc.livewire_errors',['property'=>'is_pending'])
                        </div> --}}

                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalPrices">المبلغ بدون ضريبة</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalPrices" class="form-control @error('totalPrices') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                                @include('inc.livewire_errors', ['property' => 'totalPrices'])
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalTaxes">الضريبة</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalTaxes" class="form-control @error('totalTaxes') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                                @include('inc.livewire_errors', ['property' => 'totalTaxes'])
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="totalPricesTaxes">المطلوب</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="totalPricesTaxes" class="form-control @error('totalPricesTaxes') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                                @include('inc.livewire_errors', ['property' => 'totalPricesTaxes'])
                            </div>
                        </div>

                    </div>
                </div>

                @if ($showModal == 1)
                    <x-bank-payment-component>
                        <div class="row">

                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label for="payment_type">إختر البنك</label>
                                    <select wire:model="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                        <option value="">إختر البنك</option>
                                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                        @endforeach

                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'bank_id'])
                                </div>
                            </div>

                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label for="check_num">رقم الشيك</label>
                                    <input type="text" wire:model="check_num" class="form-control @error('check_num') is-invalid @enderror" placeholder="رقم الشيك">
                                    @include('inc.livewire_errors', ['property' => 'check_num'])
                                </div>
                            </div>

                        </div>


                    </x-bank-payment-component>
                @endif

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

