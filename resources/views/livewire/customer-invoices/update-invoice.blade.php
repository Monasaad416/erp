<div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
        .inv-fields {
            font-size:12px !important;
             font-weight:bold !important;
        }
        </style>

    @endpush
    <form wire:submit.prevent="update">
        @csrf
        <div class="row">
            <div class="col-12">
                 <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                        @php
                            $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        @endphp

                        <div class="col-12 mb-2">
                            <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                        </div>
                        <div class="col-2 mb-2">
                            <div class="form-group">
                                <label for="customer_inv_num">{{ trans('admin.invoice_number') }}</label><span class="text-danger">*</span>
                                <input type="text" readonly wire:model="customer_inv_num" class="form-control @error('customer_inv_num') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                                @include('inc.livewire_errors', ['property' => 'customer_inv_num'])
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="payment_type"> نوع الدفع</label><span class="text-danger">*</span>
                                <select wire:model.live="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                    <option value="">إختر نوع الدفع</option>
                                    <option value="cash" >كاش</option>
                                    <option value="by_installments">أجل</option>
                                </select>
                                @include('inc.livewire_errors', ['property' => 'payment_type'])
                            </div>
                        </div>
                        @if($payment_type == 'by_installment')
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="customer_id">إختر العميل</label><span class="text-danger">*</span>
                                    <select wire:model.live="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                                        <option>إختر العميل</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'customer_id'])
                                    {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                    </button> --}}
                                </div>
                            </div>
                        @endif
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="customer_inv_date_time">{{ trans('admin.inv_date_time') }}</label><span class="text-danger">*</span>
                                <input type="datetime" wire:model="customer_inv_date_time" class="form-control @error('customer_inv_date_time') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                                @include('inc.livewire_errors', ['property' => 'customer_inv_date_time'])
                            </div>
                        </div>
                        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن'  ? 2 : 4}} mb-2">
                            <div class="form-group">
                                <label for="discount_percentage">{{ trans('admin.discount_percentage') }} %</label>
                                <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control @error('discount_percentage') is-invalid @enderror" placeholder="{{ trans('admin.discount_percentage') }}">
                                @include('inc.livewire_errors', ['property' => 'discount_percentage'])
                            </div>
                        </div>
                        @if(Auth::user()->roles_name == 'سوبر-ادمن')
                            <div class="col-2 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'>الفرع</label><span class="text-danger">*</span>

                                    <select wire:model.live='branch_id' class='form-control  @error('branch_id') is-invalid @enderror'>
                                        <option value="">إختر الفرع</option>
                                        @foreach (App\Models\Branch::whereNot('id',1)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>
                        @endif



                        <div class="col-{{ $payment_type == 'by_installments' ? 8 :12 }} mb-2">
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
                    <table class="table table-bordered" id="customer_inv">
                        <thead>
                            <tr>
                                <th style="width: 20px">{{ trans('admin.edit') }}</th>
                                <th style="width: 20px">{{ trans('admin.delete') }}</th>
                                {{-- <th style="width: 20px">رد جزئي</th>
                                <th style="width: 20px">رد كلي</th> --}}
                                 <th style="width: 120px">{{ trans('admin.product_code') }}</th>
                                    <th style="width: 200px">{{ trans('admin.name') }}</th>
                                     <th style="width: 70px">{{ trans('admin.inventory_balance') }}</th>
                                    <th style="width: 70px">{{ trans('admin.qty') }}</th>
                                    <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                    <th style="width: 70px">{{ trans('admin.sale_price') }} بدون ض</th>
                                    <th style="width: 70px">الاجمالي بدون ض</th>
                                    <th style="width: 70px">الضريبة</th>
                                    <th style="width: 70px">الإجمالي شامل الضريبة</th>
                                    <th style="width: 70px">مبلغ العمولة</th>



                            </tr>
                        </thead>
                        <tbody

                            @foreach ($invoice_products as $index => $item)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل الكمية"
                                            data-toggle="modal"
                                            wire:click="$dispatch('editSuppInvItem',{item_id:{{$item->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSuppInvItem',{item_id:{{$item->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    {{-- <td>
                                        <a href="#" class="modal-effect"
                                            data-toggle="modal"
                                            wire:click="$dispatch('returnItemPartially',{item_id:{{$item->id}}})" title="رد جزئي للبند">
                                            <button class="btn" {{ $item->return_status == 1 ?  'disabled' : '' }}>
                                                <i class="fas fa-undo-alt text-warning"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="modal-effect"
                                            data-toggle="modal"
                                            wire:click="$dispatch('returnItem',{item_id:{{$item->id}}})" title="رد كلي للبند">
                                            <button class="btn"  {{ $item->return_status == 1 ?  'disabled' : '' }}>
                                                <i class="fas fa-undo-alt text-danger"></i>
                                            </button>
                                        </a>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <p>{{$item->product_code}}</p>
                                            <a target="_blank" href="{{ route('product.print_code', ['id' => $item->product_id ,'code' => $item->product_code ] ) }}">
                                                <button type="button" class="btn btn-outline-success btn-sm mx-1" title="{{trans('admin.print_code')}}">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <p>{{$item->product_name_ar}}</p>
                                            <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                                data-toggle="modal"
                                                wire:click="$dispatch('updateProduct',{id:{{$item->product_id}}})">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        {{$item->qty}}
                                    </td>
                                    {{-- <td>
                                        {{$item->product_name_en}}
                                    </td> --}}
                                    <td>
                                        {{$item->unit}}
                                    </td>
                                    <td>
                                        {{$item->sale_price}}
                                    </td>
                                    <td>
                                        {{$item->total_without_tax}}
                                    </td>
                                    <td>
                                        {{$item->tax}}
                                    </td>
                                    <td>
                                        {{$item->total_with_tax}}
                                    </td>

                                    <td>
                                        {{$item->total_commission_rate}}
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
                                                            if (selectedProductId) {
                                                                @this.call('fetchByName', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });
                                        </script>

                            @endforeach

                            @if($is_pending == 1 && $payment_method == null && $payment_type == null)
                                @foreach ($rows as $index => $row)
                                    <tr wire:key = "row .{{ $index }}">
                                        {{-- <td style="width: 10px">{{ $loop->iteration }}</td> --}}
                                    <td>---</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSuppInvItem',{item_id:{{$item->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                     <td>---</td>
                                    <td>---</td>
                                          <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model="rows.{{ $index }}.product_code" wire:keydown.enter.prevent="adjustCode({{$index}})" class="form-control inv-fields @error('rows.'.$index.'.product_code') is-invalid @enderror">
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

                                            {{-- @else

                                                <div class="d-flex justify-content-between">
                                                    <input type="text" wire:model.defer="rows.{{ $index }}.product_name_ar"  class="form-control inv-fields @error('product_name_ar') is-invalid @enderror">
                                                    @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.name_ar'])
                                                    @if($productCode && $productId)
                                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                                            data-toggle="modal"
                                                        wire:click="$dispatch('updateProduct', { id: {{ $rows[$index]['product_id'] }} })">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                             @endisset --}}





                                        </td>
                                         <td>
                                            <input type="number" min="0" readonly step="any" wire:model="rows.{{ $index }}.inventory_balance" class="form-control inv-fields @error('inventory_balance') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.inventory_balance'])
                                        </td>
                                        <td>
                                            <input type="number" min="0"  step="any" wire:model.live="rows.{{ $index }}.qty" wire:change.live="getPrices({{ $index }})" class="form-control inv-fields @error('qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'])
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="rows.{{ $index }}.unit" readonly class="form-control inv-fields @error('unit') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.sale_price" class="form-control inv-fields @error('sale_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.sale_price'])
                                        </td>

                                        <td>
                                            <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.total_without_tax" class="form-control @error('rows.'.$index.'.total_without_tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_without_tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_without_tax'])
                                        </td>

                                        <td>
                                            <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.tax" class="form-control @error('rows.'.$index.'.tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.tax'])
                                        </td>

                                        <td>
                                            <input type="number" min="0" step="any"  wire:model="rows.{{ $index }}.total_with_tax" class="form-control @error('rows.'.$index.'.total_with_tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_with_tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_with_tax'])
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="any"  wire:model="rows.{{ $index }}.total_commission_rate" class="form-control @error('rows.'.$index.'.total_commission_rate') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_commission_rate_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_commission_rate'])
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>

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
                    {{-- <div class="col-12 my-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="background-color:rgb(221, 58, 58)">
                                    <input type="checkbox" class="" wire:model="is_pending" {{ $is_pending == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{trans('admin.pend_invoice')}}" style="color:white;background-color:rgb(221, 58, 58)">
                        </div>
                        @include('inc.livewire_errors',['property'=>'is_pending'])
                    </div> --}}

                </div>
            </div>
            @if($is_pending == 1)
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
            @else
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="update" class="btn btn-info mx-2 px-3">تعديل  </button>
                </div>

            @endif

        </div>


    </form>
{{--
            <livewire:products.update-product/>
            <livewire:products.print-code/> --}}

</div>

