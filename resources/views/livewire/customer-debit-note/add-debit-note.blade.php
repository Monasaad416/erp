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

    @endpush
        <form>
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:10px ;border-radius:5px ">
                        @php
                            $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                            $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        @endphp

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
                        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن'  ? 2 : 3}} mb-2">
                            <div class="form-group">
                                <label for="customer_inv_num">باركود الفاتورة</label>
                                <input type="text" wire:model="customer_inv_num"  wire:keydown.enter.prevent  class="form-control @error('customer_inv_num') is-invalid @enderror" placeholder="باركود الفاتورة">
                                @include('inc.livewire_errors', ['property' => 'customer_inv_num'])
                            </div>
                        </div>

                        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن'  ? 3 :4}}  mb-2">
                            <div class="form-group">
                                <label for="customer_inv_date_time">تاريخ وتوقيت الإشعار</label><span class="text-danger">*</span>
                                <input type="datetime-local" wire:model="customer_inv_date_time" class="form-control @error('customer_inv_date_time') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                                @include('inc.livewire_errors', ['property' => 'customer_inv_date_time'])
                            </div>
                        </div>


                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="customer_phone">هاتف العميل</label>
                                <input type="text" wire:model.live="customer_phone" wire:change.live="getCustomerName" class="form-control @error('customer_phone') is-invalid @enderror" placeholder="هاتف العميل">
                                @include('inc.livewire_errors', ['property' => 'customer_phone'])
                            </div>
                        </div>
                          <div class="col-2 mb-2">
                            <div class="form-group">
                                <label for="code"> طريقة الدفع</label><span class="text-danger">*</span>
                                <select  wire:model="payment_method" class="form-control mt-1 mb-3 @error('payment_method') is-invalid @enderror">
                                    <option value="">إختر طريقة الدفع</option>
                                    <option value="cash"> كاش</option>
                                    <option value="visa"> شبكة</option>
                                </select>
                                @include('inc.livewire_errors', ['property' => 'payment_method'])
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-muted">البنود </h3>
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
                                    <th style="width: 120px">{{ trans('admin.product_code') }}</th>
                                    <th style="width: 200px">{{ trans('admin.name') }}</th>
                                    <th style="width: 70px">{{ trans('admin.inventory_balance') }}</th>
                                    <th style="width: 70px">{{ trans('admin.qty') }}</th>
                                    <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                    <th style="width: 70px">قابل للتجزئة</th>
                                    <th style="width: 70px">{{ trans('admin.sale_price') }} بدون ض</th>
                                    <th style="width: 70px">الاجمالي بدون ض</th>
                                    <th style="width: 70px">الضريبة</th>
                                    <th style="width: 70px">الإجمالي شامل الضريبة</th>
                                    <th style="width: 70px">مبلغ العمولة</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td style="width: 10px">{{ $index + 1}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model.live="rows.{{ $index }}.product_code"  wire:keydown.enter.prevent="adjustCode({{$index}})" class="newCode form-control inv-fields @error('rows.'.$index.'.product_code') is-invalid @enderror">
                                                @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'])
                                                </span>
                                                @php
                                                    $productCode = $rows[$index]['product_code'];
                                                    $productId = $rows[$index]['product_id'];
                                                @endphp

                                                @if($productCode && $productId)
                                                    <a target="_blank" class="mt-1" href="{{ route('product.print_code',['id'=>$rows[$index]['product_id'] ,'code' => $rows[$index]['product_code'] ]) }}">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                @endif
                                            </div>

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
                                            <input type="text" readonly step="any" wire:model="rows.{{ $index }}.inventory_balance" class="form-control inv-fields @error('inventory_balance') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.inventory_balance'])
                                        </td>
                                        <td>
                                            <input type="number" min="0"  step="any" wire:model.live="rows.{{ $index }}.qty" wire:change.live="getPrices({{ $index }})"  class="form-control inv-fields @error('qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'])
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="rows.{{ $index }}.unit" readonly class="form-control inv-fields @error('unit') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                        </td>
                                        <td>
                                            <input type="checkbox" wire:model.defer="rows.{{ $index }}.fraction" disabled {{ $row['fraction'] ==1 ? 'checked':'' }} class="form-control inv-fields @error('rows.{{ $index }}.fraction') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.fraction'])
                                        </td>
                                        <td>
                                            <input type="text" readonly  wire:model="rows.{{ $index }}.sale_price" class="form-control inv-fields @error('sale_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.sale_price'])
                                        </td>

                                        <td>
                                            <input type="text" readonly wire:model="rows.{{ $index }}.total_without_tax" class="form-control @error('rows.'.$index.'.total_without_tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_without_tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_without_tax'])
                                        </td>

                                        <td>
                                            <input type="text" readonly wire:model="rows.{{ $index }}.tax" class="form-control @error('rows.'.$index.'.tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.tax'])
                                        </td>

                                        <td>
                                            <input type="text" readonly  wire:model="rows.{{ $index }}.total_with_tax" class="form-control @error('rows.'.$index.'.total_with_tax') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_with_tax_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_with_tax'])
                                        </td>
                                        <td>
                                            <input type="text" readonly  wire:model="rows.{{ $index }}.total_commission_rate" class="form-control @error('rows.'.$index.'.total_commission_rate') is-invalid @enderror" wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="total_commission_rate_{{ $index }}">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_commission_rate'])
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
                                                            @this.set('product_name_ar', selectedProductId);
                                                            if (selectedProductId) {
                                                                @this.call('fetchByName', rowIndex , selectedProductId);
                                                                @this.call('fetchByCode', rowIndex , selectedProductId);
                                                            }
                                                        });
                                                });
                                            });
                                        </script>

                                @endforeach

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



                    </div>

                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="addDebitNote" class="btn btn-info mx-2 px-3">إضافة إشعار</button>
                </div>

        </form>
    @push('scripts')

    @endpush
</div>

