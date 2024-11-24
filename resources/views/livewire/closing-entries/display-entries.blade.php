<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة قيود الأقفال</h4>
                    @can('اضافة-قيد-يومية')
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قيد يومية">
                            <span style="font-weight: bolder; font-size:">إضافة/ تعديل<br>  قيود الإقفال لسنة مالية </span>
                        </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                

                    <div class="my-3">
                     <div class="d-flex my-3">
                        {{-- <input type="text" class="form-control w-25 " placeholder="بحث بالحساب" wire:model.live="searchItem"> --}}
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
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    @if($entries->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">رقم القيد</th>
                                <th scope="col">مدين</th>
                                <th scope="col">مبلغ المدين</th>
                                <th scope="col"> الدائن</th>
                                <th scope="col">مبلغ الدائن</th>
                                <th scope="col">من تاريخ</th>
                                <th scope="col">إلي تاريخ</th>
                                {{-- <td>الاستاذ المساعد</td> --}}
                                @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <th scope="col">الفرع</th>
                                @endif
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                                {{-- <th scope="col">{{trans('admin.actions')}}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
    

                                <tr wire:key="entry-{{$entry->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">#{{ $entry->entry_num }}</span> </td>
                                    <td><span class="text-dark">{{ $entry->debitAccount->name}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->debit_amount}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->creditAccount->name}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->credit_amount}}</span> </td>
                                    <td>{{ $entry->start_date }}</td>
                                    <td>{{ $entry->end_date }}</td>
                                    {{-- <td>{{$entry->tAccounts->where('')}}</td> --}}

                                    @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <td>{{ $entry->branch->name }}</td>
                                    @endif

                                    <td>{{ App\Models\User::where('id',$entry->created_by)->first()->name ?? null }}</td>
                                    <td>{{ App\Models\User::where('id',$entry->updated_by)->first()->name ?? null}}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @else
                        <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                    @endif


                <div class="d-flex justify-content-center my-4">
                    {{$entries->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
