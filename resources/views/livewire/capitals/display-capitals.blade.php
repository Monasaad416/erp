<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة رأ س المال</h4>
                    @can('اضافة-راس-مال')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_capital')}}">
                        <span style="font-weight: bolder; font-size:">إضافة رأس مال</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الشريك" wire:model.live="searchItem">
                    </div>


                @if($capitals->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>إسم الشريك</th>
                            <th>{{trans('admin.account_num')}}</th>
                            <th>المبلغ</th>
                            <th>تاريخ الإضافة</th>
                            {{-- <th>{{trans('admin.start_balance')}}</th>
                            <th>{{trans('admin.current_balance')}}</th> --}}
                             @can('تعديل-راس-مال')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                             {{-- @can('حذف-راس-مال')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($capitals as $capital)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $capital->partner->name }}</td>
                                    <td>{{ $capital->account_num }}</td>
                                    <td >{{ $capital->amount}}</td>
                                    <td>{{ Carbon\Carbon::parse($capital->start_date)->format('Y-m-d') }}</td>

                                    @can('تعديل-راس-مال')
                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateCapital',{id:{{$capital->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    {{-- @can('حذف-راس-مال')
                                    <td>

                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteCapital',{id:{{$capital->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>


                                    </td>
                                    @endcan --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$capitals->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





