<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الأصول الثابتة</h4>
                    @can('اضافة-اصل-ثابت')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة أصل ثابت">
                        <span style="font-weight: bolder; font-size:">إضافة أصل ثابت</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الأصل " wire:model.live="searchItem">
                </div>
                @if($assets->count() > 0)


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
                                <th scope="col">رقم الحساب المالي </th>
                                <th scope="col">تاريخ الشراء</th>
                                <th scope="col">سعر الشراء</th>
                                <th scope="col">السعر الحالي</th>
                                <th scope="col">السعر الخردة</th>
                                <th scope="col">العمر  الإفتراضي</th>
                                <th scope="col">الحساب المالي التابع له</th>
                                <th scope="col">الفرع</th>
                                <th>الإهلاكات</th>
                                <th scope="col">{{trans('admin.edit')}}</th>
                                <th scope="col">{{trans('admin.delete')}}</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr wire:key="bank-{{$asset->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $asset->name }}</td>
                                    <td>{{ $asset->account_num }}</td>
                                    <td>{{ $asset->purchase_date }}</td>
                                    <td>{{ $asset->purchase_price }}</td>
                                    <td>{{ $asset->current_price }}</td>
                                    <td>{{ $asset->scrap_price }}</td>
                                    <td>{{ $asset->life_span }}</td>
                                    <td>{{ $asset->parentAccount->name }}</td>
                                    <td>{{ $asset->branch->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="الإهلاكات"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('showDepreciations',{id:{{$asset->id}}})">
                                            <i class="far fa-eye"></i>

                                        </button>
                                    </td>

                                    @can('تعديل-اصل-ثابت')
                                    <td>
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateAsset',{id:{{$asset->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        
                                    </td>
                                    @endcan
                                    @can('حذف-اصل-ثابت')
                                    <td>
                                        
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                {{-- data-target="#delete_modal"  --}}
                                                title={{trans('admin.delete_bank')}}
                                                wire:click="$dispatch('deleteAsset',{id:{{$asset->id}}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
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
                    {{$assets->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
