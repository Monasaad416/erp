<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قوائم المركز المالي </h4>
                    @can('اضافة-مركز-مالي')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قائمة المركز المالي  ">
                        <span style="font-weight: bolder; font-size:">إضافة قائمة مركز مالي</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 " placeholder="بحث بالحساب" wire:model.live="searchItem">
                        <select wire:model.live="branch_id" class="form-control  w-25 mx-3">
                            <option value="">إختر الفرع</option>
                            @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch )
                                <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>


                @if($balances->count() > 0)
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
                                    <th scope="col">مدين</th>
                                    <th scope="col">دائن</th>
                                    <th scope="col">الرصيد</th>
                                    <th scope="col">الفرع</th>
                                    <th scope="col">من تاريخ</th>
                                    <th scope="col">إلي تاريخ</th>
            
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $debitBalance = 0;
                                        $creditBalance = 0;

                                @endphp
                                @foreach ($balances as $balance)
                                    @php
                                    
                        
                                    if($balance->account->level == 1 ) {
                                        $bg = '#add0f5';
                                    }elseif($balance->account->level == 2 ) {
                                        $bg = '#f2eecd';
                                    }elseif($balance->account->level == 3 ) {
                                        $bg = '#eff3f8';
                                    }elseif($balance->account->level == 4 ) {
                                        $bg = '#e2fae0';
                                    }elseif($balance->account->level == 5 ) {
                                        $bg = '#f1e4ea';
                                    }
                        


                                    @endphp

                                    <tr wire:key="balance_type-{{$balance->id}}" style="background-color: {{ $bg }}" >
                                        <td>{{$loop->iteration}}</td>
                                        <td><span class="text-dark">{{ $balance->name }}</span> </td>
                                        <td><span class="text-dark">{{ $balance->account_num }}</span> </td>
                                        <td><span class="text-dark">{{ $balance->debit  }}</span> </td>
                                        <td><span class="text-dark">{{ $balance->credit }}</span> </td>
                                        <td><span class="text-dark">{{$balance->balance}}</span> </td>
                                        <td><span class="text-dark">{{$balance->branch->name}}</span> </td>
                                        <td><span class="text-dark">{{$balance->start_date}}</span> </td>
                                        <td><span class="text-dark">{{$balance->end_date}}</span> </td>     
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
                    {{$balances->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





