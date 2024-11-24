<div>
    <form wire:submit.prevent="update">
        @csrf

        <h3 class="text-danger my-4">{{trans('admin.edit_supplier_invoice_num')}} {!! "&nbsp;" !!} {{ $invoice->supp_inv_num }}</h3>
            @if($invoice_products->count() == 0 && App\Models\SupplierInvoiceItem::onlyTrashed()->where('supplier_invoice_id',$invoice->id)->count() >=1  && ($invoice->return_status == 10 || $invoice->return_status == 11 ))

            <p>{{ trans('admin.all_items_deleted_or_returned') }}</p>
        @else

        @if($invoice->is_pending == 1)
            <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row">
                    @php
                        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                        $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                    @endphp

                   <div class="col-12 mb-2">
                        <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                   </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="supplier"> {{trans('admin.select_supplier')}}</label><span class="text-danger">*</span>
                            <select wire:model="supplier_id" class="form-control mt-1 mb-3 @error('supplier') is-invalid @enderror">
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
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="supp_inv_date_time">{{ trans('admin.inv_date_time') }}</label><span class="text-danger">*</span>
                            <input type="datetime-local" wire:model="supp_inv_date_time" class="form-control mt-1 mb-3 @error('supp_inv_date_time') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                            @include('inc.livewire_errors', ['property' => 'supp_inv_date_time'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="invoice_discount_percentage">{{ trans('admin.invoice_discount_percentage') }}</label>
                            <input type="number" min="0" step="any" wire:model="invoice_discount_percentage" class="form-control mt-1 mb-3 @error('invoice_discount_percentage') is-invalid @enderror" placeholder="{{ trans('admin.invoice_discount_percentage') }}">
                            @include('inc.livewire_errors', ['property' => 'invoice_discount_percentage'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="invoice_discount_value">{{ trans('admin.invoice_discount_value') }}</label>
                            <input type="number" min="0" step="any" wire:model="invoice_discount_value" class="form-control mt-1 mb-3 @error('invoice_discount_value') is-invalid @enderror" placeholder="{{ trans('admin.invoice_discount_value') }}">
                            @include('inc.livewire_errors', ['property' => 'invoice_discount_value'])
                        </div>
                    </div>
                    {{-- <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="status">{{ trans('admin.select_status') }}</label><span class="text-danger">*</span>
                            <select wire:model="status" class="form-control mt-1 mb-3 @error('status') is-invalid @enderror">
                                <option>{{trans('admin.select_status')}}</option>
                                <option value="1">{{trans('admin.unpaid')}}</option>
                                <option value="2">{{trans('admin.paid')}}</option>
                                <option value="3">{{trans('admin.partially_paid')}}</option>
                                <option value="4">{{trans('admin.returned')}}</option>
                                <option value="5">{{trans('admin.partially_returned')}}</option>

                            </select>
                            @include('inc.livewire_errors', ['property' => 'status'])
                        </div>
                    </div> --}}


                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                            <select wire:model="payment_type" class="form-control mt-1 mb-3 @error('payment_type') is-invalid @enderror">
                                <option value="">{{trans('admin.select_payment_type')}}</option>
                                <option value="cash" {{$payment_type === "cash" ? 'slected':''}}>{{trans('admin.cash')}}</option>
                                <option value="by_installments" {{$payment_type == "by_installments" ? 'slected':''}}">{{trans('admin.by_installments')}}</option>
                            </select>
                            @include('inc.livewire_errors', ['property' => 'status'])
                        </div>
                    </div>

                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="notes">{{ trans('admin.notes') }}</label>
                            <input type="text" wire:model="notes" class="form-control mt-1 mb-3 @error('notes') is-invalid @enderror" placeholder="{{ trans('admin.notes') }}">
                            @include('inc.livewire_errors', ['property' => 'notes'])
                        </div>
                    </div>

                </div>


              <div class="row">
                    <div class="col-12 mb-2">
                        <h3 class="text-muted">{{trans('admin.invoice_items')}}</h3>
                     </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="product_code">{{ trans('admin.product_code') }}</label><span class="text-danger">*</span>
                            <input type="text" wire:model.lazy="product_code" wire:change="fetchProductName" wire:keydown.enter.prevent class="form-control mt-1 mb-3 @error('product_code') is-invalid @enderror" placeholder="{{ trans('admin.product_code') }}">
                            @include('inc.livewire_errors', ['property' => 'product_code'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="qty">{{ trans('admin.qty') }}</label><span class="text-danger">*</span>
                            <input type="number" min="0" step="any" wire:model="qty" class="form-control mt-1 mb-3 @error('qty') is-invalid @enderror" placeholder="{{ trans('admin.qty') }}">
                            @include('inc.livewire_errors', ['property' => 'qty'])
                        </div>
                    </div>

                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="product_name_ar">{{ trans('admin.name_ar') }}</label>
                            <input type="text" wire:model.defer="product_name_ar" class="form-control mt-1 mb-3 @error('product_name_ar') is-invalid @enderror" placeholder="{{ trans('admin.name_ar') }}" readonly>
                            @include('inc.livewire_errors', ['property' => 'product_name_ar'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="product_name_en">{{ trans('admin.name_en') }}</label>
                            <input type="text" wire:model.defer="product_name_en" class="form-control mt-1 mb-3 @error('product_name_en') is-invalid @enderror" placeholder="{{ trans('admin.name_en') }}" readonly>
                            @include('inc.livewire_errors', ['property' => 'product_name_en'])
                        </div>
                    </div>

                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="discount_percentage">{{ trans('admin.discount_percentage') }}</label>
                            <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control mt-1 mb-3 @error('discount_percentage') is-invalid @enderror" placeholder="{{ trans('admin.discount_percentage') }}">
                            @include('inc.livewire_errors', ['property' => 'discount_percentage'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="discount_value">{{ trans('admin.discount_value') }}</label>
                            <input type="number" min="0" step="any" wire:model="discount_value" class="form-control mt-1 mb-3 @error('discount_value') is-invalid @enderror" placeholder="{{ trans('admin.discount_value') }}">
                            @include('inc.livewire_errors', ['property' => 'discount_value'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="purchase_price">{{ trans('admin.purchase_price') }}</label>  {!! "&nbsp;" !!}
                            <input type="number" min="0" step="any" wire:model="purchase_price" class="form-control mt-1 mb-3 @error('purchase_price') is-invalid @enderror" placeholder="{{ trans('admin.purchase_price') }}">
                            @include('inc.livewire_errors', ['property' => 'purchase_price'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="purchase_price_including_vat">{{ trans('admin.wholesale_inc_vat') }}</label>
                            <input type="number" min="0" step="any" wire:model="wholesale_inc_vat" class="form-control mt-1 mb-3 @error('wholesale_inc_vat') is-invalid @enderror" placeholder="{{ trans('admin.wholesale_inc_vat') }}">
                            @include('inc.livewire_errors', ['property' => 'wholesale_inc_vat'])
                        </div>
                    </div>

                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="batch_num">{{ trans('admin.batch_num') }}</label>
                            <input type="text" wire:model="batch_num" class="form-control mt-1 mb-3 @error('batch_num') is-invalid @enderror" placeholder="{{ trans('admin.batch_num') }}">
                            @include('inc.livewire_errors', ['property' => 'batch_num'])
                        </div>
                    </div>

                    {{-- <div class="d-flex justify-content-center align-content-center">
                        <button wire:click.prevent="update" class="btn btn-warning mt-1">{{ trans('admin.add_item') }} </button>
                    </div> --}}
                </div>
            </div>
            <div class="col-2"></div>
            </div>

        @endif



            <div class="card-body">



                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ trans('admin.product_code') }}</th>
                        <th>{{ trans('admin.name_ar') }}</th>
                        <th>{{ trans('admin.name_en') }}</th>
                        <th>{{ trans('admin.unit') }}</th>
                        <th>{{ trans('admin.qty') }}</th>
                        <th>{{ trans('admin.purchase_price') }}</th>
                        <th>{{ trans('admin.wholesale_inc_vat') }}</th>
                        <th>{{ trans('admin.item_discount_percentage') }} %</th>
                        <th>{{ trans('admin.batch_num') }}</th>
                        <th>{{ trans('admin.returns_operations') }}</th>
                        <th>{{ trans('admin.edit') }}</th>
                        <th>{{ trans('admin.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($invoice_products as $item)
                            <tr>
                                {{-- {{ dd($item) }}  --}}
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$item->product_code}}
                                </td>
                                <td>{{ $item->product_name_ar }}</td>
                                <td>{{ $item->product_name_en }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->purchase_price ?  $item->purchase_price : 0}}</td>
                                <td>{{ $item->wholesale_inc_vat ?  $item->wholesale_inc_vat : 0}}</td>
                                <td>{{ $item->item_discount_percentage ?  $item->item_discount_percentage : 0}}</td>
                                <td>{{ $item->batch_num ?  $item->batch_num : '---'}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" {{ $item->is_pending == 1 ? "disabled" : "" }} type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            {{ trans('admin.operations') }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a class="dropdown-item" href="#" class="modal-effect text-danger btn-sm"
                                            wire:click="$dispatch('returnItem',{id:{{$item->id}}})" title="{{ trans("admin.trans_to_returns") }}">
                                                <i class="fas fa-undo-alt text-danger mx-1"></i>   {{trans('admin.trans_item_to_returns')}}
                                            </a>
                                            <a class="dropdown-item" href="#" class="modal-effect text-danger btn-sm"
                                            wire:click="$dispatch('returnItemPartially',{id:{{$item->id}}})" title="{{ trans("admin.partially_trans_item_to_returns") }}">
                                                <i class="fas fa-undo-alt text-muted mx-1"></i>   {{trans('admin.partially_trans_item_to_returns')}}
                                            </a>


                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل الكمية"
                                        data-toggle="modal"
                                        wire:click="$dispatch('edititemItem',{item_id:{{$item->id}}})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                        data-toggle="modal"
                                        wire:click="$dispatch('deleteitemItem',{item_id:{{$item->id}}})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="col-12 my-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color:rgb(221, 58, 58)">
                                <input type="checkbox" class="" wire:model="is_pending" >
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{trans('admin.pend_invoice')}}" style="color:white;background-color:rgb(221, 58, 58)">
                    </div>
                    @include('inc.livewire_errors',['property'=>'is_pending'])
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-secondary mx-2">{{ trans('admin.edit_invoice') }}</button>
            </div>
        @endif


    </form>
</div>
