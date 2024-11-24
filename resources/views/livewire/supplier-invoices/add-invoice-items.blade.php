<div>
    <form wire:submit.prevent="create">
        @csrf
        <div class="row">

            <div class="col-12">
{{-- 
                <div class="row">
                    <div class="col-12 mb-2">
                        <h3 class="text-muted">{{trans('admin.invoice_items')}}</h3>
                   </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="code">{{ trans('admin.product_code') }}</label><span class="text-danger">*</span>
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

           
                </div> --}}

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 100px">{{ trans('admin.product_code') }}</th>
                                <th style="width: 30px">{{ trans('admin.qty') }}</th>
                                <th style="width: 100px">{{ trans('admin.name_ar') }}</th>
                                <th style="width: 100px">{{ trans('admin.name_en') }}</th>
                                <th style="width: 30px">{{ trans('admin.unit') }}</th>
                                
                                <th style="width: 50px">{{ trans('admin.purchase_price') }}</th>
                                <th style="width: 50px">{{ trans('admin.wholesale_inc_vat') }}</th>
                                <th style="width: 20px">{{ trans('admin.discount_percentage') }}</th>
                                <th style="width: 50px">{{ trans('admin.discount_value') }}</th>
                                <th style="width: 70px">{{ trans('admin.batch_num') }}</th>
                            </tr>
                        </thead>
                                <th style="width: 10px">#</th>
                                <th>
                                    <input type="text" wire:model.lazy="product_code" wire:change="fetchProductName" wire:keydown.enter.prevent class="form-control mt-1 mb-3 @error('product_code') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'product_code'])
                                </th>
                                <th>
                                    <input type="number" min="0" step="any" wire:model="qty" class="form-control mt-1 mb-3 @error('qty') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'qty'])
                                </th>
                                <th>
                                    <input type="text" wire:model.defer="product_name_ar" readonly class="form-control mt-1 mb-3 @error('product_name_ar') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'product_name_ar'])
                                </th>
                                <th>
                                    <input type="text" wire:model.defer="product_name_en" readonly class="form-control mt-1 mb-3 @error('product_name_en') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'product_name_en'])
                                </th>
                                <th>
                                    <input type="text" wire:model.defer="unit" readonly class="form-control mt-1 mb-3 @error('unit') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'unit'])
                                </th>
                             
                        
                                <th>
                                    <input type="number" min="0" step="any" wire:model="purchase_price" class="form-control mt-1 mb-3 @error('purchase_price') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'purchase_price'])
                                </th>
                                <th>
                                    <input type="number" min="0" step="any" wire:model="wholesale_inc_vat" class="form-control mt-1 mb-3 @error('wholesale_inc_vat') is-invalid @enderror">
                                    @include('inc.livewire_errors', ['property' => 'wholesale_inc_vat'])
                                </th>
                                <th>
                                    <input type="number" min="0" step="any" wire:model="discount_percentage" class="form-control mt-1 mb-3 @error('discount_percentage') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'discount_percentage'])
                                </th>
                                <th>
                                    <input type="number" min="0" step="any" wire:model="discount_value" class="form-control mt-1 mb-3 @error('discount_value') is-invalid @enderror" >
                                    @include('inc.livewire_errors', ['property' => 'discount_value'])
                                </th>
                                <th>
                                    <input type="text" wire:model="batch_num" class="form-control mt-1 mb-3 @error('batch_num') is-invalid @enderror">
                                    @include('inc.livewire_errors', ['property' => 'batch_num'])
                                </th>
                        <tbody>
                    </table>
         <div class="d-flex justify-content-center align-content-center">
                        <button class="btn btn-warning mt-1">{{ trans('admin.add_item') }} </button>
                    </div>


            </div>
 

        </div>

        @if($invoice_products->count() > 0)
            <div class="card-body">
                <style>
                    tr , .table thead th  {
                        text-align: center;
                    }
                    .form-control{
                        font-size: 14px;
                        width: 200;
                        overflow-x: scroll !important;
           
                    }
                </style>
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
                            <th>{{ trans('admin.discount_percentage') }}</th>
                            <th>{{ trans('admin.discount_value') }}</th>
                            <th>{{ trans('admin.batch_num') }}</th>
                            {{-- <th>{{ trans('admin.delete') }}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_products as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><p>{{ $item['product_code'] }}</p>
                                   
                                    <button type="button" class="btn btn-outline-success btn-sm mx-1 my-0" title="{{trans('admin.print_product_code')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('printProductCode',{id:{{$item['product_id']}}})">
                                            <i class="fas fa-print"></i>
                                    </button>
                                </td>
                                <td><p>{{ $item['product_name_ar'] }}</p>
                                  
                                <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل الكمية"
                                    data-toggle="modal"
                                    wire:click="$dispatch('updateProduct',{id:{{$item->product_id}}})">
                                    <i class="far fa-edit"></i>
                                </button>
                                </td>
                                <td>{{ $item['product_name_en'] ?? null }}</td>
                                <td>{{ $item['unit']}}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['purchase_price'] }}</td>
                                <td>{{ $item['wholesale_inc_vat'] }}</td>
                                <td>{{ $item['discount_percentage'] }}</td>
                                <td>{{ $item['discount_value'] }}</td>
                                <td>{{ $item['batch_num'] }}</td>
                                {{-- <td>
                                <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                        data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
                                        <i class="fas fa-trash"></i>
                                </button>
                                </td> --}}
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
            </div>
            {{-- <div class="d-flex justify-content-center">
                <button type="submit"  class="btn btn-success mx-2">{{ trans('admin.save_invoice') }}</button>
            </div> --}}

        @endif
    </form>



</div>
