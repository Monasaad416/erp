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
        /* .form-control {
            font-size:12px !important;
             font-weight:bold !important;
        } */
        </style>

    @endpush
    <form wire:submit.prevent="create">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                    @php
                        $stores = App\Models\Store::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                    @endphp

                   {{-- <div class="col-12 mb-2">
                        <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                   </div> --}}
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="trans_num">رقم التحويل</label><span class="text-danger">*</span>
                            <input type="text" readonly wire:model="trans_num" class="form-control @error('trans_num') is-invalid @enderror" placeholder="رقم التحويل">
                            @include('inc.livewire_errors', ['property' => 'trans_num'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="trans_date_time">تاريخ وتوقيت التحويل</label><span class="text-danger">*</span>
                            <input type="datetime-local" wire:model="trans_date_time" class="form-control @error('trans_date_time') is-invalid @enderror" placeholder="تاريخ وتوقيت التحويل">
                            @include('inc.livewire_errors', ['property' => 'trans_date_time'])
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="to_store_id"> إختر المخزن المطلوب التحويل منه</label><span class="text-danger">*</span>
                            <select wire:model="from_store_id" {{ Auth::user()->roles_name != 'سوبر-ادمن' ? 'disabled' :''  }} class="form-control @error('from_store_id') is-invalid @enderror">
                                <option>إختر المخزن المطلوب التحويل منه</option>
                                @foreach($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                            @include('inc.livewire_errors', ['property' => 'from_store_id'])
                            {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                            </button> --}}
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-group">
                            <label for="to_store_id"> إختر المخزن المطلوب التحويل إلية</label><span class="text-danger">*</span>
                            <select wire:model="to_store_id" class="form-control @error('to_store_id') is-invalid @enderror">
                                <option>إختر المخزن المطلوب التحويل إلية</option>
                                @foreach($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                            @include('inc.livewire_errors', ['property' => 'to_store_id'])
                            {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                            </button> --}}
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for="description">وصف التحويل</label>
                            <input type="text" wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="وصف التحويل">
                            @include('inc.livewire_errors', ['property' => 'description'])
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
                                <th style="width: 120px">{{ trans('admin.product_code') }}</th>
                                <th style="width: 200px">{{ trans('admin.name') }}</th>
                                <th style="width: 70px">{{ trans('admin.inventory_balance') }}</th>
                                <th style="width: 70px">{{ trans('admin.qty') }}</th>
                                <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                <th style="width: 70px">سعر الوحدة</th>
                                <th style="width: 70px">إجمالي السعر</th>
                                <th style="width: 10px">إلغاء البند</th>

                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($rows as $index => $row)
                                <tr>
                                    <td style="width: 10px">{{ $index }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>
                                            <input type="text" wire:model="rows.{{ $index }}.product_code"  wire:keydown.enter.prevent="adjustCode({{$index}})" class="form-control @error('rows.'.$index.'.product_code') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'])
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $productCode = $rows[$index]['product_code'];
                                            $productId = $rows[$index]['product_id'];
                                        @endphp
                                        {{-- @if(!$productId)           --}}
                                        <div class="d-flex justify-content-between" wire:ignore>
                                            <select wire:model="rows.{{ $index }}.product_name_ar" id="select2{{$index}}" data-row-index={{$index}} data-live-search="true" class="form-control select2bs4 @error('product_name_ar') is-invalid @enderror">
                                                <option value="">إختر المنتج</option>
                                                @foreach(App\Models\Product::where('is_active',1)->get() as $product)
                                                    <option value="{{$product->id}}" {{ $product->name_ar == 'rows.'. $index .'.product_name_ar' ? 'selected' : ''}} > {{$product->name_ar}}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_name_ar'])

                                        </div>
                                        {{-- @else
                                            <input type="text" wire:model="rows.{{ $index }}.product_name_ar" class="form-control @error('product_name_ar') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_name_ar'])
                                        @endif --}}
                                    </td>
                                    <td>
                                        <input type="number" wire:model="rows.{{ $index }}.inventoryFromBalance" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" wire:change.live="calculateTotalPrice({{ $index }})" wire:model="rows.{{ $index }}.qty" class="form-control @error('qty') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.qty'])
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="rows.{{ $index }}.unit" readonly class="form-control @error('unit') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                    </td>

                                    <td>
                                        <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.unit_price" class="form-control @error('unit_price') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit_price'])
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" wire:model="rows.{{ $index }}.total_price"  wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" class="form-control @error('total_price') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.total_price'])
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                            data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
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
                                                            @this.call('fetchByName', rowIndex , selectedProductId);
                                                        }
                                                    });
                                            });
                                        });
                                    </script>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit"  class="btn btn-info mx-2">{{ trans('admin.save') }}</button>
        </div>
    </form>


@push('scripts')

{{-- <script>
    $(document).ready(function () {
        initializeSelect2({{$index}});

        $('#select2' + {{$index}}).on('change', function (e) {
            var selectedProductId = $(this).val();
            console.log(selectedProductId);
            if (selectedProductId) {
                @this.call('fetchByName', {{ $index }}, selectedProductId);
            }
        });

        Livewire.on('element.initialized', function (element, component) {
            if (element.id.startsWith('select2')) {
                var index = element.id.substring(7);
                initializeSelect2(index);
            }
        });
    });

    function initializeSelect2(index) {
        $('#select2' + index).select2();
    }

    // Initialize select2 dropdown for the initial row
    initializeSelect2({{$index}});
</script> --}}
@endpush
@push('scripts')
{{-- <script>
    window.addEventListener('newRowAdded', event => {
        // $('.select2bs4').select2();
           $(document).ready(function () {
                $('.select2bs4').select2();

                $(document).on('change', '.select2bs4', function (e) {
                    var rowIndex = $(this).data('row-index');
                    var selectedProductId = $(this).val();
                    console.log(rowIndex);
                    if (selectedProductId) {
                        @this.call('fetchByName', {{ $index }}, selectedProductId);
                    }
                });
        });
    }); --}}

{{-- //     window.addEventListener('newRowAdded', event => {
//   $(document).ready(function () {
//     $('.select2bs4').select2();

//     $('.select2bs4').each(function (index, element) {
//       var rowIndex = $(element).data('row-index');


//       $(element).on('change', function (e) {
//         var selectedProductId = $(this).val();
//         console.log(rowIndex);
//         if (selectedProductId) {
//           @this.call('fetchByName', rowIndex, selectedProductId);
//         }
//       });
//     });
//   });
// }); --}}


</script>
@endpush



</div>

