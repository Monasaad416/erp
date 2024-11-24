<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5>دفتر الاستاذ العام - <span class="text-danger">{{ $account_name }}  </span>  </h5>
                    <hr>
                    <h6> رقم الحساب المالي  - <span class="text-danger"> {{ $account_num }}</span>  </h6>
                </div>

            </div>

            <div class="card-body">

                @if($ledgers->count() > 0)


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">المرجع</th>
                                <th scope="col">مدين</th>
                                <th scope="col"> دائن</th>
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ledgers as $ledger)

                                <tr wire:key="entry-{{$ledger->id}}">
                                    <td>{{ $loop->iteration}}</td>
                                    @if($ledger->type == 'journal_entry')
                                        <td>{{ $ledger->JournalEntry ? 'قيد يومية# '.$ledger->JournalEntry->entry_num  : '---' }}</td>
                                    @elseif($ledger->type == 'closing_entry')
                                        <td>{{ 'قيد إغلاق#'.$ledger->closingEntry->entry_num }}</td>
                                    @endif
                                    
                                    <td><span class="text-dark">{{ $ledger->debit_amount ?  $ledger->debit_amount : 0.00 }}</span> </td>
                                    <td><span class="text-dark">{{ $ledger->credit_amount ? $ledger->credit_amount : 0.00 }}</span> </td>
                                    <td>{{ App\Models\User::where('id',$ledger->created_by)->first()->name ?? null }}</td>
                                    <td>{{ App\Models\User::where('id',$ledger->updated_by)->first()->name ?? null}}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$ledgers->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
