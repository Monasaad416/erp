<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الخصومات</h4>
                    @can('اضافة-مكافأة')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة مكافاءة ">
                        <span style="font-weight: bolder; font-size:">إضافة مكافاءة </span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($rewards->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="قائمة الخصومات " wire:model.live="searchItem">
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
                                <th scope="col">الموظف</th>
                                <th scope="col">رقم الحساب المالي</th>
                                <th scope="col">الفرع</th>
                                <th scope="col">الشهر المالي</th>
                                <th scope="col">السنة المالية</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">ملاحظات</th>
                                @can('تعديل-مكافأة')
                                <th scope="col">تعديل</th>
                                @endcan
                                @can('حذف-مكافأة')
                                <th scope="col">حذف</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rewards as $reward)
                                <tr wire:key="reward-{{$reward->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $reward->user->name }}</span> </td>
                                    <td><span class="text-dark">{{ $reward->user->account_num }}</span> </td>
                                    <td><span class="text-dark">{{ $reward->branch->name }}</span> </td>
                                    <td>{{ $reward->financialMonth->month_name }}</td>
                                    <td>{{ Carbon\Carbon::parse($reward->created_at)->format('Y') }}</td>
                                    <td>{{ $reward->amount }}</td>
                                    <td>{{ $reward->notes }}</td>
                                      @can('تعديل-مكافأة')

                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateReward',{id:{{$reward->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    @endcan

                                    @can('حذف-مكافأة')
                                     <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_reward')}}
                                            wire:click="$dispatch('deleteReward',{id:{{$reward->id}}})">
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
                    {{$rewards->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
