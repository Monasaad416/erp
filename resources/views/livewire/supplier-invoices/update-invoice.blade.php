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
                        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                    @endphp

                   <div class="col-12 mb-2">
                        <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                   </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="supp_inv_num">{{ trans('admin.invoice_number') }}</label><span class="text-danger">*</span>
                            <input type="text" readonly wire:model="supp_inv_num" class="form-control @error('supp_inv_num') is-invalid @enderror" placeholder="{{ trans('admin.invoice_number') }}">
                            @include('inc.livewire_errors', ['property' => 'supp_inv_num'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="supplier_id"> {{trans('admin.select_supplier')}}</label><span class="text-danger">*</span>
                            <select wire:model.live="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                <option>{{trans('admin.select_supplier')}}</option>
                                @foreach($suppliers as $supp)
                                    <option value="{{$supp->id}}">{{$supp->name}}</option>
                                @endforeach
                            </select>
                            @include('inc.livewire_errors', ['property' => 'supplier_id'])
                            {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                            </button> --}}
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="supp_inv_date_time">{{ trans('admin.inv_date_time') }}</label><span class="text-danger">*</span>
                            <input type="datetime-local" wire:model="supp_inv_date_time" class="form-control @error('supp_inv_date_time') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                            @include('inc.livewire_errors', ['property' => 'supp_inv_date_time'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="discount_percentage">{{ trans('admin.discount_percentage') }}</label>
                            <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control @error('discount_percentage') is-invalid @enderror" placeholder="{{ trans('admin.discount_percentage') }}">
                            @include('inc.livewire_errors', ['property' => 'discount_percentage'])
                        </div>
                    </div>



                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                            <select wire:model="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                <option>{{trans('admin.select_payment_type')}}</option>
                                <option value="cash">{{trans('admin.cash')}}</option>
                                <option value="by_installments">{{trans('admin.by_installments')}}</option>
                            </select>
                            @include('inc.livewire_errors', ['property' => 'payment_type'])
                        </div>
                    </div>

                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="notes">{{ trans('admin.notes') }}</label>
                            <input type="text" wire:model="notes" class="form-control @error('notes') is-invalid @enderror" placeholder="{{ trans('admin.notes') }}">
                            @include('inc.livewire_errors', ['property' => 'notes'])
                        </div>
                    </div>
                                            <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="transportation_fees">مصروفات النقل (ريال)</label>
                                <input type="number" min="0" step="any" wire:model="transportation_fees" class="form-control @error('transportation_fees') is-invalid @enderror" placeholder="مصروفات النقل">
                                @include('inc.livewire_errors', ['property' => 'transportation_fees'])
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
                        <thead>
                            <tr>
                                <th style="width: 20px">{{ trans('admin.edit') }}</th>
                                <th style="width: 20px">رد جزئي</th>
                                <th style="width: 20px">رد كلي</th>
                                <th style="width: 20px">{{ trans('admin.delete') }}</th>
                                <th style="width: 120px">{{ trans('admin.product_code') }}</th>
                                <th style="width: 200px">{{ trans('admin.name') }}</th>
                                <th style="width: 70px">{{ trans('admin.qty') }}</th>
                                <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                <th style="width: 70px">{{ trans('admin.purchase_price') }}بدون ض</th>
                                <th style="width: 70px">{{ trans('admin.sale_price') }} بدون ض</th>
                                <th style="width: 70px">{{ trans('admin.wholesale_inc_vat') }}</th>
                                <th style="width: 70px">{{ trans('admin.batch_num') }}</th>
                            </tr>
                        </thead>
                        <tbody
                        {{-- @php
                            $suppInv = App\Models\SuppInvoice::where('id',$)
                        @endphp --}}

                            @foreach ($invoice_products as $index => $item)
                                <tr>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل الكمية"
                                            data-toggle="modal"
                                            wire:click="$dispatch('editSuppInvItem',{item_id:{{$item->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>

                                    <td>
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
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSuppInvItem',{item_id:{{$item->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    {{-- <td style="width: 10px">{{ $loop->iteration }}</td> --}}
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
                                        {{$item->purchase_price}}
                                    </td>
                                    <td>
                                        {{$item->sale_price}}
                                    </td>

                                    <td>
                                        {{$item->wholesale_inc_vat ? $item->wholesale_inc_vat : '---' }}
                                    </td>
                                    <td>
                                        {{$item->batch_num ? $item->batch_num : '---'}}
                                    </td>

                                </tr>

                            @endforeach

                            @if($is_pending == 1)
                                @foreach ($rows as $index => $row)
                                    <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model="rows.{{ $index }}.product_code" wire:change="fetchByCode({{ $index }})" wire:keydown.enter.prevent class="form-control inv-fields @error('rows.'.$index.'.product_code') is-invalid @enderror">
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




                                        </td>


                                        <td>

                                            {{-- @if(($productCode == null && $productId == null) ||($productCode== "" && $productId =="")) --}}

                                                <div class="d-flex justify-content-between" wire:ignore>
                                                    <select wire:model="rows.{{ $index }}.product_name_ar" id="select2{{$index}}" data-row-index={{$index}} data-live-search="true" class="form-control inv-fields select2bs4 @error('product_name_ar') is-invalid @enderror">
                                                        <option value="">إختر المنتج</option>
                                                        @foreach(App\Models\Product::where('is_active',1)->get() as $product)
                                                            <option value="{{$product->id}}" > {{$product->name_ar}}</option>
                                                        @endforeach
                                                    </select>
                                                    @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.name_ar'])

                                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                                        data-toggle="modal"
                                                        wire:click="$dispatch('updateProduct', { id: {{ $rows[$index]['product_id'] }} })">
                                                        <i class="far fa-edit"></i>
                                                    </button>
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
                                            @endif --}}
                                        </td>
                                        <td>
                                            <input type="number" min="0"  step="any" wire:model="rows.{{ $index }}.qty" class="form-control inv-fields @error('qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'])
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="rows.{{ $index }}.unit" readonly class="form-control inv-fields @error('unit') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                        </td>

                                        <td>
                                            <input type="number" min="0" step="any"  wire:change.live="getTaxes({{ $index }})" wire:model="rows.{{ $index }}.purchase_price" class="form-control inv-fields @error('purchase_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.purchase_price'])
                                            {{-- <input type="text" wire:model="rows.{{ $index }}.taxes">
                                            <input type="text" wire:model="rows.{{ $index }}.unit_total"> --}}
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.sale_price" class="form-control inv-fields @error('sale_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.sale_price'])
                                        </td>
                                        <td>
                                            <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.wholesale_inc_vat" wire:change.live="calculateUnitPrice({{ $index }})" class="form-control inv-fields @error('wholesale_inc_vat') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.wholesale_inc_vat'])
                                        </td>

                                        {{-- <td>
                                            <input type="text" wire:model="rows.{{ $index }}.batch_num" class="form-control inv-fields @error('batch_num') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.batch_num'])
                                        </td> --}}
                                        <td>
                                            <input type="text" wire:model="rows.{{ $index }}.batch_num" class="form-control @error('rows.'.$index.'.batch_num') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="batch_num_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.batch_num'])
                                        </td>

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
                                                                @this.call('fetchByName', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });
                                        </script>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
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

            @if($is_pending == 1)
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
            @else
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="update" class="btn btn-info mx-2 px-3">تعديل  </button>
                </div>
            @endif

                </div>
            </div>

        </div>


    </form>
{{--
            <livewire:products.update-product/>
            <livewire:products.print-code/> --}}

</div>

