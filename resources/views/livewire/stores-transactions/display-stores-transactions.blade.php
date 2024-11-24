<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">التحويلات بين المخازن</h4>
                    @can('اضافة-تحويل-مخزن')
                    <a href="{{ route('stores.create_transaction') }}" class="text-white">
                        <button type="button" class="btn bg-gradient-cyan" title="إضافة تحويل">
                            <span style="font-weight: bolder; font-size:">إضافة تحويل</span>
                        </button>
                    </a>
                    @endcan
                </div>

            </div>

            <div class="card-body">
                 <div class="d-flex my-3">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم التحويل" wire:model.live="searchItem">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم الحساب " wire:model.live="accountNum">
                    <select class="form-control ml-3" wire:model.live="branch_id">
                        <option value=" >إختر الفرع</option>
                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach

                    </select>
                    <select class="form-control ml-3" wire:model.live="bank_id">
                        <option value="">إختر البنك</option>
                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="d-flex justify-content-around">
                        <div class="form-group w-50 mx-1">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date" class="form-control ml-2" wire:model.live="from_date">
                        </div>



                        <div class="form-group w-50 mx-1">
                            <label for="from_date">إلي تاريخ:</label>
                            <input type="date" class="form-control ml-2"  wire:model.live="to_date">
                        </div>
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
                                <th>تاريخ الحركة</th>
                                <th>من مخزن</th>
                                <th>إلي مخزن</th>
                                {{-- <th>رصيد المخزن المحول منه</th>
                                <th>رصيد المخزن المحول اليه</th>
                                <th>الكمية</th>
                                <th>تكلفة الوحدة</th>
                                <th>إجمالي التكلفة</th> --}}
                                <td>بنود التحويل</td>

                                @can('قبول-تحويل-مخزن')
                                <td>قبول التحويل</td>
                                @endcan

                                 @can('تعديل-تحويل-مخزن')
                                <td>تعديل</td>
                                @endcan

                                @can('حذف-تحويل-مخزن')
                                <td>حذف</td>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                $transactionItems = App\Models\InventoryTransactionItem::latest()->get();
                            @endphp --}}
                            @if($stores_transactions->count() > 0 )
                                @foreach ($stores_transactions as $transaction)
                                    <tr>
                                        <td style="width:2%">{{$loop->iteration}}</td>
                                        <td>{{ $transaction->trans_num }}</td>
                                        <td>
                                            {{ Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y ') }}
                                            <br>
                                            {{ Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}
                                        </td>
                                        <td>{{ $transaction->fromStore->name }}</td>
                                        <td>{{ $transaction->toStore->name }}</td>
                                        <td>
                                            <a href="{{route('stores.transactions.items',['trans_num' => $transaction->trans_num ])}}">
                                                <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="بنود التحويل">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                        @php
                                            $storeFromBranchId = App\Models\Store::where('id',$transaction->from_store_id)->first()->branch_id;
                                            $storeToBranchId = App\Models\Store::where('id',$transaction->to_store_id)->first()->branch_id;
                                            //dd($storeToBranchId);
                                        @endphp
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
                                        <td>
                                            <a href="{{route('stores.transactions.edit',['trans_num' => $transaction->trans_num ])}}">
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
