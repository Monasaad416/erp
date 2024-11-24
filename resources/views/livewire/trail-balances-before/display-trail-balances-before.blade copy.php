<div class="row">
    <div class="col">
        <div class="card">
            <div class="d-flex justify-content-around  my-5">
                <input type="date" class="form-control w-25 search_term" placeholder="من تاريخ"  wire:model.live="from_date">
                <input type="date" class="form-control w-25 search_term" placeholder="الي تاريخ"  wire:model.live="to_date">
                <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_account')}} " wire:model.live="searchItem">

            </div>
            <div>
               <select class="form-control w-25 " multiple wire:model.live="levels">
                    <option value="">إختر المستوي</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option><option value="1">1</option>
                    <option value="5">5</option>
                </select>

                <button type="button" class="btn bg-gradient-success mx-2" wire:click="exportTrailReport">
                    <span>تصدير الي EXCEL</span>
                </button>
            </div>


            <div class="card-body">

                    <div class="my-3">

                    </div>
                        @if($accounts->count() > 0)

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
                                <th scope="col">{{trans('admin.account_num')}}</th>
                                <th scope="col">مدين</th>
                                <th scope="col">دائن</th>
                                <th scope="col">الرصيد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $debitBalance = 0;
                                    $creditBalance = 0;

                            @endphp
                            @foreach ($accounts as $account)
                                @php
                                    $accountsQuery = App\Models\Ledger::select('id',
                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','debit_amount','credit_amount','account_num')
                                    ->where('account_num',$account->account_num)
                                    ->where(function ($query) {
                                        if (!empty($this->searchItem)) {
                                            $query->where('name_'.LaravelLocalization::getCurrentLocale(), 'like', '%'.$this->searchItem.'%')
                                                ->orWhere('account_num', 'like', '%'.$this->searchItem.'%');
                                        }

                                        if ($this->from_date != null && $this->to_date != null) {
                                            $query->where('start_date',$from_date)->where('end_date',$to_date);
                                        }
                                    });

                                    $totalDebit = $accountsQuery->sum('debit_amount');
                                    $totalCredit = $accountsQuery->sum('credit_amount');
                                    $debitBalance += $totalDebit;
                                    $creditBalance += $totalCredit;

                                 
                       
                                if($account->level == 1 ) {
                                    $bg = '#add0f5';
                                }elseif($account->level == 2 ) {
                                    $bg = '#f2eecd';
                                }elseif($account->level == 3 ) {
                                    $bg = '#eff3f8';
                                }elseif($account->level == 4 ) {
                                    $bg = '#e2fae0';
                                }elseif($account->level == 5 ) {
                                    $bg = '#f1e4ea';
                                }
                       


                                @endphp

                                <tr wire:key="account_type-{{$account->id}}" style="background-color: {{ $bg }}" >
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $account->name }}</span> </td>
                                    <td><span class="text-dark">{{ $account->account_num }}</span> </td>
                                    <td><span class="text-dark">{{ $totalDebit  }}</span> </td>
                                    <td><span class="text-dark">{{ $totalCredit }}</span> </td>
                                    <td><span class="text-dark">{{ $totalDebit - $totalCredit }}</span> </td>
                                </tr>

                                @php


                                @endphp

                            @endforeach
                             {{-- {{dd($debitBalance + $creditBalance)}} --}}
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$accounts->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
