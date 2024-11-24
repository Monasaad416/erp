<div class="row">
    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
        <script>
        $( function() {
    
             
            $( "#from_date" ).datepicker({
                // dateFormat: "dd/mm/yy" 
            });
            $( "#to_date" ).datepicker({
                // dateFormat: "dd/mm/yy" 
            });
  
        } );
        </script>
    @endpush
    <div class="col">
        <div class="card">
            @php

            @endphp
            <div class="card-header">
                <div class="d-flex justify-content-around my-2">
                    {{-- @can('') --}}
                    {{-- <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#create_modal" title="إضافة إيصال صرف">
                        <span style="font-weight: bolder; font-size:">إضافة إيصال صرف</span>
                    </button>
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#create_modal" title="إضافة إيصال صرف">
                        <span style="font-weight: bolder; font-size:">إضافة إيصال تحصيل</span>
                    </button> --}}

                  @can('اضافة-حركة-بنكية')
                    <a href="{{ route('bank.transactions.create_exchange_check') }}">
                        <button type="button" class="btn btn-outline-danger mx-1" title="إضافة شيك صرف">
                            إضافة شيك صرف
                        </button>
                    </a>
                    <a href="{{ route('bank.transactions.create_collection_check') }}">
                        <button type="button" class="btn btn-outline-success mx-1" title="إضافةشيك تحصيل">
                            إضافة شيك تحصيل
                        </button>
                    </a>
                    @endcan
                    {{-- <a href="{{ route('create_collection_reciept') }}">
                        <button type="button" class="btn btn-outline-success mx-1" title="إضافة تحصيل">
                            إضافة تحصيل
                        </button>
                    </a> --}}
                    {{-- @endcan --}}
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex my-3">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم الفاتورة" wire:model.live="searchItem">
                    <input type="text" class="form-control ml-2" placeholder="بحث برقم الحساب " wire:model.live="accountNum">
                    <select class="form-control ml-3" wire:model.live="branch_id">
                        <option value=" >إختر الفرع</option>
                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                        
                    </select>
                    <select class="form-control ml-3" wire:model.live="bank_id">
                        <option value="">إختر البنك</option>
                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                        
                    </select>
                    <select class="form-control ml-3 " wire:model.live="state">
                        <option value="">إختر نوع الحركة</option>
                        <option value="صرف" {{$state == 'صرف' ? 'selected':''}} >صرف</option>
                        <option value="تحصيل" {{$state == 'تحصيل' ? 'selected':''}}>تحصيل</option>
                    </select> 
                </div>
                
                <div class="d-flex justify-content-around">
                        <div class="form-group w-50 mx-1">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date"  class="form-control ml-2" wire:model.live="from_date">
                        </div>
         
                    

                        <div class="form-group w-50 mx-1">
                            <label for="from_date">إلي تاريخ:</label>
                            <input type="date"  class="form-control ml-2"  wire:model.live="to_date">
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
                                <th>البنك</th>
                                <th>رقم الشيك</th>
                                <th>نوع الحركة</th>
                                <th>وصف الحركة</th>
                                <th>تابعة لحساب مالي</th>
                                <th>رقم الحساب</th>
                                <th>رقم الفاتورة</th>
                                <th>قيمة الشيك</th>
                                
                                @can('تعديل-حركة-بنكية')
                                <th>تعديل</th>
                                @endcan

                                @can('حذف-حركة-بنكية')
                                <th>حذف</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $transaction->bank->name }}</td>
                                    <td>{{ $transaction->check_num }}</td>
                                    <td class="text-{{ $transaction->state == "صرف" ? 'danger' : 'success' }}">{{ $transaction->state}}</td>
                                    <td>{{ $transaction->description ? $transaction->description : '--' }}</td>
                                    <td class="text-{{ $transaction->is_account ? 'success':'danger'}}">{{ $transaction->is_account ? trans('admin.yes') : trans('admin.no') }}</td>
                                    <td>{{ $transaction->account_num ? $transaction->account_num : '---'}}</td>
                                    <td>{{ $transaction->inv_num ? $transaction->inv_num : '---' }}</td>
                                    <td>{{ $transaction->amount }}</td>
                    

                                    @can('تعديل-حركة-بنكية')
                                    <td class="text-center">
                                        <button type="button" {{ $transaction->state =="تحصيل"  ? 'disabled' : '' }} class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateTransaction',{id:{{$transaction->id}} })">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-حركة-بنكية')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteTransaction',{id:{{$transaction->id}}})">
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
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
