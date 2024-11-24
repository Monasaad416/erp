<div class="row">
    <div class="col">
        <div class="card">
            @php

            @endphp
           


            <div class="card-body">
                <div class="d-flex my-3">
                    <input type="text" class="form-control mx-2" placeholder="بحث برقم الفاتورة" wire:model.live="searchItem">
                    <input type="text" class="form-control mx-2" placeholder="بحث برقم الحساب " wire:model.live="accountNum">
                    @if(Auth::user()->roles_name == 'سوبر-ادمن')
                    <select class="form-control  mx-2 " wire:model.live="branch_id">
                        <option value="" >إختر الفرع</option>
                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                        
                    </select>
                    @endif
                    <select class="form-control mx-2" wire:model.live="state">
                        <option value="">إختر نوع الحركة</option>
                        <option value="صرف" {{$state == 'صرف' ? 'selected':''}} >صرف</option>
                        <option value="تحصيل" {{$state == 'تحصيل' ? 'selected':''}}>تحصيل</option>
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
                @if($transactions->count() > 0)
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
                                <th>الفرع</th>
                                <th>رقم الحركة</th>
                                <th>نوع الحركة</th>
                                <th>وصف الحركة</th>
                                <th>تابعة لحساب مالي</th>
                                <th>رقم الحساب</th>
                                <th>رقم الفاتورة</th>
                                <th>قيمة الإيصال</th>
                                <th>وردية الخزينة</th>
                                <th>تاريخ الحركة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $transaction->treasury->name }}</td>
                                    <td>{{ $transaction->branch->name }}</td>
                                    <td>{{ $transaction->serial_num }}</td>
                                    <td class="text-{{ $transaction->state =="صرف" ? 'danger' : 'success' }}">{{ $transaction->state}}</td>
                                    <td>{{ $transaction->description ? $transaction->description : '--' }}</td>
                                    <td class="text-{{ $transaction->is_account ? 'success':'danger'}}">{{ $transaction->is_account ? trans('admin.yes') : trans('admin.no') }}</td>
                                    <td>{{ $transaction->account_num ? $transaction->account_num : '---'}}</td>
                                    <td>{{ $transaction->inv_num ? $transaction->inv_num : '---' }}</td>
                                    <td>{{ $transaction->receipt_amount }}</td>
                                    <td>{{ $transaction->treasuryShift->deliveredToShiftType->label() }}</td>
                                    <td>{{Carbon\Carbon::parse($transaction->date)->format('d M ,Y')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif
                <div class="d-flex justify-content-center my-4">
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
