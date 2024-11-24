<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة البنوك</h4>
                    @can('اضافة-بنك')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة خزنة">
                        <span style="font-weight: bolder; font-size:">إضافة بنك</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم البنك " wire:model.live="searchItem">
                </div>
                @if($banks->count() > 0)


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
                                <th scope="col">اخر  شيك</th>
                                <th scope="col">الرصيد</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                @can('تعديل-بنك')
                                <th scope="col">{{trans('admin.edit')}}</th>
                                @endcan
                                   @can('تعديل-بنك')
                                <th scope="col">{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                                <tr wire:key="bank-{{$bank->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $bank->name }}</td>
                                    <td>{{ $bank->account_num }}</td>
                                    <td>{{ $bank->last_check ? $bank->last_check : '---' }}</td>
                                    <td>{{ $bank->current_balance }}</td>
                                    <td>

                                        <button type="button" class="btn btn-{{$bank->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$bank->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggleBank',{id:{{$bank->id}}})">
                                            <i class="fa fa-toggle-{{$bank->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                     @can('تعديل-بنك')
                                    <td>
                                       
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateBank',{id:{{$bank->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                     
                                    </td>
                                       @endcan
                                       @can('حذف-بنك')
                                    <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                {{-- data-target="#delete_modal"  --}}
                                                title={{trans('admin.delete_bank')}}
                                                wire:click="$dispatch('deleteBank',{id:{{$bank->id}}})">
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
                    {{$banks->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
