<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قوائم الدخل</h4>
                    @can('اضافة-قائمة-دخل')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_income')}}">
                        <span style="font-weight: bolder; font-size:">إضافة/ تعديل<br> قائمة الدخل للعام المالي</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3 search_term">
                            <option value="">إختر الفرع</option>
                            @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch )
                                <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                        <select class="form-control w-25 search_term mx-3"  wire:model.live="searchItem">
                            <option>إختر السنة المالية </option>
                            @foreach(App\Models\FinancialYear::all() as $year)
                                {{$year->year}}
                            @endforeach
                        </select>
                    </div>


                @if($incomes->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
           <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{trans('admin.name')}}</th>
            <th scope="col">{{trans('admin.account_num')}}</th>
            <th scope="col">الرصيد</th>
            <th scope="col">الفرع</th>
            <th scope="col">النوع</th>
            <th scope="col">من تاريخ</th>
            <th scope="col">إلي تاريخ</th>
            <th>صافي الربح </th>
        </tr>
    </thead>
    <tbody>
        @php
        $balance = 0;
        @endphp
        @foreach ($incomes as $index => $income)
        <tr wire:key="income_type-{{$income->id}}">
            <td>{{$loop->iteration}}</td>
            <td><span class="text-dark">{{ $income->name }}</span></td>
            <td><span class="text-dark">{{ $income->account_num }}</span></td>
            <td  style="background-color:   {{ $income->type == "ايراد"  ? 'rgb(189, 236, 189)' : 'rgb(235, 192, 192)'  }}"><span class="text-dark">{{$income->balance}}</span></td>
            <td><span class="text-dark">{{$income->branch->name}}</span></td>
            <td><span class="text-dark">{{$income->type}}</span></td>
            <td><span class="text-dark">{{$income->start_date}}</span></td>
            <td><span class="text-dark">{{$income->end_date}}</span></td>
            @if ($index === 0)
                <td rowspan="12" style="text-align:center ;font-weight:bold;color:rgb(223, 27, 27)" style="vertical-align: middle;">{{$balance += $income->balance}}</td>
            @endif
        </tr>
        @php
        // Additional logic for calculations
        @endphp
        @endforeach
        {{-- {{dd($debitBalance + $creditBalance)}} --}}
    </tbody>
</table>
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$incomes->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





