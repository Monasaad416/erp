<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة المخزون المجرود</h4>
                   @can('اضافة-جرد-مخزون')
                   <div class="d-flex">
                        <a href="{{route('stores.create_inventory_count')}}" class="text-white mx-2">
                            <button type="button" class="btn bg-gradient-cyan" title="إضافة جرد كلي">
                                <span style="font-weight: bolder; font-size:">إضافة جرد كلي</span>
                            </button>
                        </a>
                        <a href="{{route('stores.create_selected_inventory_count')}}" class="text-white mx-2">
                            <button type="button" class="btn bg-gradient-success" title="إضافة جرد اصناف محددة">
                                <span style="font-weight: bolder; font-size:">إضافة جرد أصناف محددة</span>
                            </button>
                        </a>
                   </div>
       
                    @endcan

                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control mx-1" placeholder="بحث بإسم المنتج" wire:model.live="searchItem">

                        @if(auth()->user()->roles_name == 'سوبر-ادمن')
                            <select class="form-control mx-1" placeholder="{{trans('admin.search_by_customer_inv_completed')}}" wire:model.live="branch_id">
                                <option value="" >{{trans('admin.select_branch')}}</option>
                                @foreach(App\Models\Branch::get() as $branch)
                                <option value="{{ $branch->id }}">{{$branch->name_ar}}</option>
                                @endforeach
                            </select>
                        @endif


                        <select class="form-control mx-1" placeholder="تسوية جرد المخزون" wire:model.live="is_settled">
                            <option value="" >التسوية</option>
                            <option value="1" {{$is_settled === 1 ? 'selected':''}}>تمت</option>
                            <option value="0" {{$is_settled === 0 ? 'selected':''}}>لم تتم</option>
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

                @if($invCounts->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>          
                                <th style="width: 100px">{{ trans('admin.name') }}</th>
                                <th style="width: 100px">{{ trans('admin.product_code') }}</th>
                                <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                @if(auth()->user()->roles_name == 'سوبر-ادمن')
                                <th style="width: 70px">{{ trans('admin.branch') }}</th>
                                @endif
                                <th style="width: 70px">التكلفة الفعلية</th>
                                <th style="width: 70px">العدد الفعلي</th>
                                <th style="width: 70px">العدد بالبرنامج</th>
                                <th style="width: 70px">عجز/زياد</th>
                                <th style="width: 70px">كمية العجز/ الزيادة</th>
                                <th style="width: 70px">من تاريخ</th>
                                <th style="width: 70px">إلي تاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invCounts as $count)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $count->name_ar }}</td>
                                    <td>{{ $count->product_code }}</td>
                                    <td>{{ $count->unit }}</td>
                                    @if(auth()->user()->roles_name == 'سوبر-ادمن')
                                    <td>{{ $count->branch->name }}</td>
                                    @endif
                                    <td>{{ $count->latest_purchase_price * $count->actual_qty }}</td>
                                    <td>{{ $count->actual_qty }}</td>
                                    <td>{{ $count->system_qty }}</td>
                                    <td>{{ $count->state }}</td>
                                    <td>{{ $count->state_qty}}</td>
                                    <td>{{ $count->from_date }} </td>
                                    <td>{{ $count->to_date }} </td>
     


                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{ trans('admin.not_found') }}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$invCounts->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





