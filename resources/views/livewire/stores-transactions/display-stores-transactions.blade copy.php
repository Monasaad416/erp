<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">التحويلات بين المخازن</h4>
                    {{-- @can('إضافة وحدة') --}}
                    <a href="{{ route('stores.create_transaction') }}" class="text-white">
                        <button type="button" class="btn bg-gradient-cyan" title="إضافة تحويل">
                            <span style="font-weight: bolder; font-size:">إضافة تحويل</span>
                        </button>
                    </a>
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
                @if($stores_transactions->count() > 0)
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>رقم الحركة</th>
                                <th>المنتج</th>
                                <th>من مخزن</th>
                                <th>إلي مخزن</th>
                                <th>رصيد المخزن المحول منه</th>
                                <th>رصيد المخزن المحول اليه</th>
                                <th>الكمية</th>
                                <th>تكلفة الوحدة</th>
                                <th>إجمالي التكلفة</th>
                                <td>قبول التحويل</td>
                                <td>تعديل</td>
                                <td>حذف</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $transactionItems = App\Models\InventoryTransactionItem::latest()->get();
                            @endphp
                            @if($transactionItems->count() > 0 )
                                @foreach ($transactionItems as $transaction)
                                    @php
                                        $inventoryFrom = App\Models\Inventory::where('product_id',$transaction->product_id)->where('store_id',$transaction->inventoryTransaction->fromStore->id)->latest()->first();
                                        $inventoryto = App\Models\Inventory::where('product_id',$transaction->product_id)->where('store_id',$transaction->inventoryTransaction->toStore->id)->latest()->first();
                                    @endphp
                                    <tr>
                                        <td style="width:2%">{{$loop->iteration}}</td>
                                        <td>{{ $transaction->inventoryTransaction->trans_num }}</td>
                                        <td>{{ $transaction->product->name_ar}}</td>
                                        <td>{{ $transaction->inventoryTransaction->fromStore->name }}</td>
                                        <td>{{ $transaction->inventoryTransaction->toStore->name }}</td>
                                        <td>{{ $inventoryFrom->inventory_balance }}</td>
                                        <td>{{ $inventoryto->inventory_balance  }}</td>
                                        <td>{{ $transaction->qty }}</td>
                                        <td>{{ $transaction->unit_price }}</td>
                                        <td>{{ $transaction->total_price }}</td>
                                        <td>
                                            <a href="{{route('stores.transactions.approve',['trans_num'=> $transaction->inventoryTransaction->trans_num ])}}">
                                                <button type="button" class="btn btn-secondary btn-sm mx-1" title="معلق">
                                                    @if($transaction->approval == 'معلق')
                                                        <i class="fas fa-star"></i>
                                                    @elseif($transaction->approval == 'مقبول جزئيا')
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @elseif($transaction->approval == 'مقبول ')
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="fas fa-star"></i>
                                                    @endif
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('stores.transactions.edit',['trans_num' => $transaction->inventoryTransaction->trans_num ])}}">
                                                <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل التحويل">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                                data-toggle="modal"
                                                wire:click="$dispatch('deleteInvTransaction',{transaction_id:{{$transaction->id}}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        {{-- <td>{{ $transaction->trans_inv_date_time->format('Y-m-d') }}<br>{{ $transaction->trans_inv_date_time->format('H:i:s') }}</td> --}}
                                        {{-- <td>{{ $user->updated_by ? $user->updated_by->name  : '---'}}</td> --}}
                                    </tr>

                                    {{-- <livewire:inventoryoices.update-product :product="$transaction" /> --}}
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
                    {{$stores_transactions->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
