<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة المخازن</h4>
                    @can('اضافة-مخزن')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة مخزن">
                        <span style="font-weight: bolder; font-size:">إضافة مخزن</span>
                    </button>
                    @endcan

                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم المخزن " wire:model.live="searchItem">
                </div>
                @if($stores->count() > 0)


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
                                <th scope="col">نوع المخزن</th>
                                <th scope="col">اخر ايصال دفع</th>
                                <th scope="col">اخر ايصال تحصيل</th>
                                <th scope="col">{{trans('admin.status')}}</th>

                                @can('تعديل-مخزن')
                                <th scope="col">{{trans('admin.edit')}}</th>
                                @endcan
                                @can('حذف-مخزن')
                                <th scope="col">{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                                <tr wire:key="store-{{$store->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $store->name }}</span> </td>
                                    <td>{{ $store->branch->name }}</span> </td>
                                    <td class="text-{{ $store->is_parent == 1 ? 'success': 'primary' }}">{{ $store->is_parent == 1 ? 'رئيسي': 'فرعي' }}</td>
                                    <td>{{ $store->last_exchange_reciept ? $store->last_exchange_reciept : '---' }}</span> </td>
                                    <td>{{ $store->last_collection_reciept ? $store->last_collection_reciept : '---' }}</span> </td>
                                        
                                    @can('تغيير-حالة-مخزن')
                                    <td>
                                        <button type="button" class="btn btn-{{$store->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$store->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('togglestore',{id:{{$store->id}}})">
                                            <i class="fa fa-toggle-{{$store->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('تعديل-مخزن')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateStore',{id:{{$store->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-مخزن')
                                    <td>
                                        @if($store->id >= 1 && $store->id < 8)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                {{-- data-target="#delete_modal"  --}}
                                                title={{trans('admin.delete_store')}}
                                                wire:click="$dispatch('deleteStore',{id:{{$store->id}}})">
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
                    {{$stores->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
