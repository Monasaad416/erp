<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة مسحوبات الشركاء</h4>
                    @can('اضافة-شريك')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_partner')}}">
                        <span style="font-weight: bolder; font-size:">إضافة مسحوبات للشريك</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الشريك" wire:model.live="searchItem">
                    </div>


                @if($partnersWithdrawals->count() > 0)
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
                            <th>المبلغ</th>
                            <th>تاريخ السحب</th>
                            <th>الغرض</th>
                            <th>المصدر</th>
                            @can('تعديل-شريك')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                            @can('حذف-شريك')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partnersWithdrawals as $withdrawal)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $withdrawal->partner->name }}</td>
                                    {{-- <td>{{ $withdrawal->account_num }}</td> --}}
                                    <td >{{ $withdrawal->amount}}</td>
                                     <td >{{ $withdrawal->date}}</td>
                                    <td >{{ $withdrawal->type}}</td>

                                    <td >{{ $withdrawal->sourcable_type == "App\Models\Bank" ? App\Models\Bank::where('id',$withdrawal->sourcable_id)->first()->name_ar : App\Models\Treasury::where('id',$withdrawal->sourcable_id)->first()->name_ar}}</td>

                                    @can('تعديل-شريك')
                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updatePartner',{id:{{$withdrawal->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-شريك')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deletePartner',{id:{{$withdrawal->id}}})">
                                            <i class="fas fa-trash"></i>
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
                    {{$partnersWithdrawals->links()}}
                </div>

            </div>
        </div>
    </div>
</div>