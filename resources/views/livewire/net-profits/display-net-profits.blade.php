<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">الأرباح والخسائر</h4>
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


                @if($profits->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
           <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">الربح أو الخسارة</th>
            <th scope="col">الفرع</th>
            <th scope="col">من تاريخ</th>
            <th scope="col">إلي تاريخ</th>
        </tr>
    </thead>
    <tbody>
        @php
        $balance = 0;
        @endphp
        @foreach ($profits as $index => $profit)
        <tr wire:key="income_type-{{$profit->id}}">
            <td>{{$loop->iteration}}</td>
            <td><span class="text-dark">{{ $profit->profit }}</span></td>
            <td><span class="text-dark">{{ $profit->branch->name }}</span></td>
            <td><span class="text-dark">{{ $profit->start_date }}</span></td>
            <td><span class="text-dark">{{ $profit->end_date }}</span></td>
            @if ($index === 0)
                <td rowspan="12" style="text-align:center ;font-weight:bold;color:rgb(223, 27, 27)" style="vertical-align: middle;">{{$balance += $profit->balance}}</td>
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
                    {{$profits->links()}}
                </div>

            </div>
        </div>
    </div>

</div>






