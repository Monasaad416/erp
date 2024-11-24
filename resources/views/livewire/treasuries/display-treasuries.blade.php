<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الخزن</h4>
                    @can('اضافة-خزينة')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة خزنة">
                        <span style="font-weight: bolder; font-size:">إضافة خزنة</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الخزينة " wire:model.live="searchItem">
                </div>
                @if($treasuries->count() > 0)


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('admin.name')}}</th>
                                <th scope="col">{{trans('admin.branch')}}</th>
                                <th scope="col">النوع </th>
                                <th scope="col">رقم الحساب </th>
                                <th scope="col">الرصيد </th>
                                <th scope="col">اخر ايصال دفع</th>
                                <th scope="col">اخر ايصال تحصيل</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                @can('تعديل-خزينة')
                                <th scope="col">{{trans('admin.edit')}}</th>
                                @endcan

                                @can('حذف-خزينة')
                                <th scope="col">{{trans('admin.delete')}}</th>
                                 @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treasuries as $treasury)
                                <tr wire:key="treasury-{{$treasury->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $treasury->name }}</span> </td>
                                    <td>{{ $treasury->branch->name }}</span> </td>
                                    <td class="text-{{ $treasury->is_parent == 1 ? 'success': 'primary' }}">{{ $treasury->is_parent == 1 ? 'رئيسية': 'فرعية' }}</td>
                                    <td>{{ $treasury->account_num }}</td>
                                    <td>{{ $treasury->current_balance }}</td>
                                    <td>{{ $treasury->last_exchange_reciept ? $treasury->last_exchange_reciept : '---' }}</span> </td>
                                    <td>{{ $treasury->last_collection_reciept ? $treasury->last_collection_reciept : '---' }}</span> </td>
                                    <td>

                                        <button type="button" class="btn btn-{{$treasury->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$treasury->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggletreasury',{id:{{$treasury->id}}})">
                                            <i class="fa fa-toggle-{{$treasury->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    @can('تعديل-خزينة')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateTreasury',{id:{{$treasury->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    @endcan

                                    @can('حذف-خزينة')
                                    <td>
                                        @if($treasury->id >= 1 && $treasury->id < 8)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                {{-- data-target="#delete_modal"  --}}
                                                title={{trans('admin.delete_treasury')}}
                                                wire:click="$dispatch('deleteTreasury',{id:{{$treasury->id}}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$treasuries->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
