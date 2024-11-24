<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة قيود اليومية</h4>
                    {{-- @can('اضافة-قيد-يومية')
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قيد يومية">
                            <span style="font-weight: bolder; font-size:">إضافة قيد يومية</span>
                        </button>
                    @endcan --}}
                </div>

            </div>

            <div class="card-body">

                @if($entries->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث برقم القيد " wire:model.live="searchItem">
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
                                <th scope="col">رقم القيد</th>
                                <th scope="col">تاريخ القيد</th>
                                <th scope="col">مدين</th>
                                <th scope="col">مبلغ المدين</th>
                                <th scope="col"> الدائن</th>
                                <th scope="col">مبلغ الدائن</th>
                                <th scope="col">{{trans('admin.description')}}</th>
                                {{-- <td>الاستاذ المساعد</td> --}}
                                @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <th scope="col">الفرع</th>
                                @endif
                                <th scope="col"> انشاء  من</th>
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                                {{-- <th scope="col">{{trans('admin.actions')}}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                @php
                                    $type='';
                                    $name='';
                                    if( $entry->jounralable_type == "App\Models\SupplierInvoice"){
                                        $type ="فاتورة مورد";
                                        $name = App\Models\SupplierInvoice::withTrashed()->where('id',$entry->jounralable_id)->first()->supp_inv_num;

                                    }elseif( $entry->jounralable_type == "App\Models\CustomerInvoice"){
                                        $type ="فاتورة عميل";
                                        $name = App\Models\CustomerInvoice::withTrashed()->where('id',$entry->jounralable_id)->first()->customer_inv_num;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Transaction"){
                                         $trans = App\Models\Transaction::where('id',$entry->jounralable_id)->first();
                                        $type ="إيصال ".$trans->state;
                                        $name='رقم '.$trans->serial_num;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Salary"){
                                        $type ="راتب موظف";
                                        $salary = App\Models\Salary::where('id',$entry->jounralable_id)->first();
                                        $name = $entry->debitAccount->name;
                                    }
                                   elseif( $entry->jounralable_type == "App\Models\Asset"){
                                       $asset = App\Models\Asset::where('id',$entry->jounralable_id)->first();
                                        $type ="شراء أصل ثابت ";
                                        $name = $asset->name_ar;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\CustomerReturn"){
                                        $type ="مردودات  مبيعات -إشعار دائن";
                                        //dd(App\Models\CustomerReturn::where('id',$entry->jounralable_id)->first());
                                        $name = App\Models\CustomerReturn::where('id',$entry->jounralable_id)->first()->serial_num ?? null;

                                    }
                                    elseif( $entry->jounralable_type == "App\Models\CustomerDebitNote"){
                                        $type = "إشعار مدين ";
                                        $name = App\Models\CustomerDebitNote::where('id',$entry->jounralable_id)->first()->serial_num ?? null;
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\Capital"){
                                        $capital = App\Models\Capital::where('id',$entry->jounralable_id)->first();
                                        
                                        $type = "إضافة رأس مال للشريك";
                                        $name = App\Models\Partner::where('id',$capital->partner_id)->first()->name_ar ?? null;
                                         
                                    }
                                    elseif( $entry->jounralable_type == "App\Models\PartnerWithdrawal"){
                                        $withdrawal = App\Models\PartnerWithdrawal::where('id',$entry->jounralable_id)->first();
                        
                                        $type ="إضافة مسحوبات للشريك";
                                        $name = App\Models\Partner::where('id',$withdrawal->partner_id)->first()->name_ar ?? null;
                                    }
                                @endphp

                                <tr wire:key="entry-{{$entry->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">#{{ $entry->entry_num }}</span> </td>
                                    <td><span class="text-dark">{{ $entry->created_at }}</span> </td>
                                    <td><span class="text-dark">{{ $entry->debitAccount->name ?? null}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->debit_amount}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->creditAccount->name ?? null}}</span> </td>
                                    <td><span class="text-dark">{{ $entry->credit_amount}}</span> </td>
                                    <td>{{ $entry->description }}</td>
                                    {{-- <td>{{$entry->tAccounts->where('')}}</td> --}}

                                    @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <td>{{ $entry->branch->name }}</td>
                                    @endif
                                    <td>
                                        {{ $type ?? null }}
                                        <br>
                                        <span class="text-danger">{{ $name ??null }}</span>
                                    </td>
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
