<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الخصومات</h4>
                    @can('اضافة-خصم')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة خصم ">
                        <span style="font-weight: bolder; font-size:">إضافة خصم </span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($deductions->count() > 0)

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
                                @can('تعديل-خصم')
                                <th scope="col">تعديل</th>
                                @endcan
                                @can('حذف-خصم')

                                <th scope="col">حذف</th>
                                @endcan

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deductions as $deduction)
                                <tr wire:key="deduction-{{$deduction->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $deduction->user->name }}</span> </td>
                                    <td><span class="text-dark">{{ $deduction->user->account_num }}</span> </td>
                                    <td><span class="text-dark">{{ $deduction->branch->name }}</span> </td>
                                    <td>{{ $deduction->financialMonth->month_name }}</td>
                                    <td>{{ Carbon\Carbon::parse($deduction->created_at)->format('Y') }}</td>
                                    <td>{{ $deduction->amount }}</td>
                                    <td>{{ $deduction->notes }}</td>

                                     @can('تعديل-خصم')
                                    <td>
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateDeduction',{id:{{$deduction->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        
                                    </td>
                                    @endcan
                                    @can('حذف-خصم')
                                     <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_deduction')}}
                                            wire:click="$dispatch('deleteDeduction',{id:{{$deduction->id}}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button
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
                    {{$deductions->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
