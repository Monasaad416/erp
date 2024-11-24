<div class="row">
    <div class="col">
        <div class="card">
            @php

            @endphp
            <div class="card-header">
                <div class="d-flex justify-content-end my-2">
                    @can('اضافة-تسوية-خزينة')
                    <a href="{{ route('add_treasury_adjustment') }}">
                        <button type="button" class="btn btn-info mx-1" title="إضافة تسوية خزينة">
                            إضافة تسوية خزينة
                        </button>
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                       <div class="d-flex my-3">
                    <input type="text" class="form-control mx-2" placeholder="بحث بالحساب المدين" wire:model.live="searchItem">
                    <input type="text" class="form-control mx-2" placeholder="بحث بالحساب الدائن " wire:model.live="accountNum">
                    <select class="form-control  mx-2 " wire:model.live="branch_id">
                        <option value="" >إختر الفرع</option>
                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach

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
                @if($adjustments->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>الخزينة</th>
                                <th>رقم الحركة</th>
                                <th>نوع الحركة</th>
                                <th>وصف الحركة</th>
                                <th>تابعة لحساب مالي</th>
                                <th>رقم الحساب</th>
                                <th>رقم الفاتورة</th>
                                <th>قيمة الإيصال</th>
                                <th>وردية الخزينة</th>

                                @can('تعديل-حركة-خزينة')
                                <th>تعديل</th>
                                 @endcan
                                 @can('حذف-حركة-خزينة')
                                <th>حذف</th>
                                 @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjustments as $adjustment)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $adjustment->treasury->name }}</td>
                                    <td>{{ $adjustment->serial_num }}</td>
                                    <td class="text-{{ $adjustment->state =="صرف" ? 'danger' : 'success' }}">{{ $adjustment->state}}</td>
                                    <td>{{ $adjustment->description ? $adjustment->description : '--' }}</td>
                                    <td class="text-{{ $adjustment->is_account ? 'success':'danger'}}">{{ $adjustment->is_account ? trans('admin.yes') : trans('admin.no') }}</td>
                                    <td>{{ $adjustment->account_num ? $adjustment->account_num : '---'}}</td>
                                    <td>{{ $adjustment->inv_num ? $adjustment->inv_num : '---' }}</td>
                                    <td>{{ $adjustment->receipt_amount }}</td>
                                    <td>{{ $adjustment->treasuryShift->deliveredToShiftType->label() }}</td>
                                    @can('تعديل-حركة-خزينة')
                                    <td class="text-center">

                                        <button type="button" {{ $adjustment->state =="تحصيل"  ? 'disabled' : '' }} class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateTransaction',{id:{{$adjustment->id}} })">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                     @endcan
                                     @can('حذف-حركة-خزينة')
                                    <td>

                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteTransaction',{id:{{$adjustment->id}}})">
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
                    {{$adjustments->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
