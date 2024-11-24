<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">  تحويل رقم {{ $transaction->trans_num }}</h4>
                    {{-- @can('إضافة وحدة') --}}

                    {{-- @endcan --}}
                </div>

            </div>

            <div class="card-body">
                <div class="d-flex justify-content-around my-3">
                    {{-- <select class="form-control w-25 search_term" placeholder="من مخزن " wire:model.lazy="from_store">
                        <option value=""> من مخزن</option>
                        @foreach (App\Models\Store::all() as $store)
                            <option value="{{ $store->id }}">{{$store->name_ar}}</option>
                        @endforeach
                    </select>
                    <select class="form-control w-25 search_term" placeholder=" الي مخزن" wire:model.lazy="to_store">
                        <option value="">إلي مخزن </option>
                        @foreach (App\Models\Store::all() as $store)
                            <option value="{{ $store->id }}">{{$store->name_ar}}</option>
                        @endforeach
                    </select> --}}
                </div>
                @if($transaction_items->count() > 0)
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>المنتج</th>
                                <th>الكود</th>
                                <th>من مخزن</th>
                                <th>إلي مخزن</th>
                                <th>رصيد المخزن المحول منه</th>
                                <th>رصيد المخزن المحول اليه</th>
                                <th>الكمية المحولة</th>
                                <th>الكمية المقبولة</th>
                                <th>تكلفة الوحدة غير شامل ض</th>

                                <td>حالة التحويل</td>
                                @can('قبول-تحويل-مخزن')
                                    <td>قبول التحويل</td>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>

                            @if($transaction_items->count() > 0 )
                                @foreach ($transaction_items as $item)
                                    @php
                                        $inventoryFrom = App\Models\Inventory::where('product_id',$item->product_id)->where('store_id',$item->inventoryTransaction->fromStore->id)->latest()->first();
                                        $inventoryto = App\Models\Inventory::where('product_id',$item->product_id)->where('store_id',$item->inventoryTransaction->toStore->id)->latest()->first();
                                    @endphp
                                    <tr>
                                        <td style="width:2%">{{$loop->iteration}}</td>
                                        <td>{{ $item->product->name_ar}}</td>
                                        <td>{{ $item->product_code}}</td>
                                        <td>{{ $item->inventoryTransaction->fromStore->name }}</td>
                                        <td>{{ $item->inventoryTransaction->toStore->name }}</td>
                                        <td>{{ $inventoryFrom->inventory_balance }}</td>
                                        <td>{{ $inventoryto ? $inventoryto->inventory_balance : 0  }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->accepted_qty }}</td>
                                        <td>{{ $item->unit_price }}</td>

                                        <td>
                                            @if($item->approval == 'pending')
                                               <p class="text-muted">معلق</p>
                                            @elseif($item->approval == 'partially_accepted')
                                                <p class="text-info">مقبول جزئيا</p>
                                            @elseif($item->approval == 'accepted')
                                                <p class="text-success">مقبول </p>
                                            @elseif($item->approval == 'rejected')
                                                <p class="text-danger">مرفوض </p>
                                            @endif
                                        </td>
                                        @php
                                            $storeFromBranchId = App\Models\Store::where('id',$transaction->from_store_id)->first()->branch_id;
                                            $storeToBranchId = App\Models\Store::where('id',$transaction->to_store_id)->first()->branch_id;
                                            //dd($storeToBranchId);
                                        @endphp

                                        @can('قبول-تحويل-مخزن')
                                            <td>
                                                @if(Auth::user()->branch_id == $storeToBranchId)

                                                    <a href="{{route('stores.transactions.approve',['trans_num'=> $transaction->trans_num ])}}">
                                                        <button type="button" class="btn btn-secondary btn-sm mx-1">
                                                                <i class="fas fa-star"></i>
                                                        </button>
                                                    </a>

                                                @else
                                                    ---
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            @else
                            <p>لايوجد تحويلات بين المخازن  </p>
                            @endif
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif

                <div class="d-flex justify-content-center my-4">
                    {{$transaction_items->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
