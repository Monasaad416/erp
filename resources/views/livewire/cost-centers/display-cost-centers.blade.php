<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">مراكز التكلفة</h4>
                    @can('اضافة-مركز-تكلفة')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_center')}}">
                        <span style="font-weight: bolder; font-size:">إضافة مركز تكلفة</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($centers->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث إسم مركز التكلفة" wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الكود</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">الحساب الرئيسي</th>
                                   @can('تعديل-مركز-تكلفة')
                                <th scope="col">تعديل</th>
                                  @endcan
                                   @can('حذف-مركز-تكلفة')
                                <th scope="col">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($centers as $center)
                                <tr wire:key="center-{{$center->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $center->code }}</span> </td>
                                    <td><span class="text-dark">{{ $center->name }}</span> </td>
                                    <td><span class="text-dark">{{ $center->parent_id ? $center->parent->name : '---' }}</span> </td>
                      
                                       @can('تعديل-مركز-تكلفة')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateCenter',{id:{{$center->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                      
                                    </td>
                                      @endcan
                                      @endcan
                                       
                                       @can('حذف-مركز-تكلفة')
                                    <td> 
                                    @if($center->id >= 1 && $center->id < 8) 
                                        <i class="fas fa-lock text-muted"></i>
                                    @else 
                                       
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_center')}}
                                            wire:click="$dispatch('deleteCenter',{id:{{$center->id}}})">
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
                    {{$centers->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
