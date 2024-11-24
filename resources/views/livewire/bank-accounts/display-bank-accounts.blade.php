<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الحسابات البنكية</h4>
                    @can('اضافة-حساب-بنكي')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة حساب بنكي">
                        <span style="font-weight: bolder; font-size:">إضافة حساب</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">
               <div class="my-3">
                    <input type="text" class="form-control w-25 search_term" placeholder="بحث برقم الحساب " wire:model.live="searchItem">
                </div>
                @if($bankAccounts->count() > 0)


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
                                <th scope="col">البنك</th>
                                <th scope="col">رقم الحساب البنكي </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bankAccounts as $bankAccount)
                                @php
                                    if($bankAccount->accountable_type == 'App\Models\Supplier')
                                    {
                                        $accountable = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$bankAccount->accountable_id)->first()->name;
                                    } else {
                                         $accountable = App\Models\User::where('id',$bankAccount->accountable_id)->first()->name;
                                    }
                                @endphp
                                <tr wire:key="bank-{{$bankAccount->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $accountable }}</td>
                                    <td>{{ $bankAccount->bank->name }}</td>
                                    <td>{{ $bankAccount->bank_account_num }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$bankAccounts->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
