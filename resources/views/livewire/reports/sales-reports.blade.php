<div class="row">
    <div class="col">
        <div class="card">
  
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control mx-1" placeholder="{{trans('admin.search_by_customer_inv_num')}}" wire:model.live="searchItem">

                        @if(auth()->user()->roles_name == 'سوبر-ادمن')
                            <select class="form-control mx-1" placeholder="{{trans('admin.search_by_customer_inv_completed')}}" wire:model.live="branch_id">
                                <option value="" >{{trans('admin.select_branch')}}</option>
                                @foreach(App\Models\Branch::whereNot('id',1)->get() as $branch)
                                <option value="{{ $branch->id }}">{{$branch->name_ar}}</option>
                                @endforeach
                            </select>
                        @endif


                        <select class="form-control mx-1" placeholder="{{trans('admin.search_by_customer_inv_completed')}}" wire:model.live="pending_status">
                            <option value="" >{{trans('admin.select_status')}}</option>
                            <option value="1" {{$pending_status === 1 ? 'selected':''}}>{{trans('admin.pending_invoice')}}</option>
                            <option value="0" {{$pending_status === 0 ? 'selected':''}}>{{trans('admin.completed_invoice')}}</option>
                        </select>

                        <select class="form-control mx-1" placeholder="{{trans('admin.search_by_customer_inv_completed')}}" wire:model.live="pending_status">
                            <option value="" >{{trans('admin.select_status')}}</option>
                            <option value="10" {{$return_status == 10 ? 'selected':''}}>{{trans('admin.return_invoice')}}</option>
                            <option value="11" {{$return_status == 11 ? 'selected':''}}>{{trans('admin.return_item')}}</option>
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

                @if($customerInvoices->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.inv_num') }}</th>
                                <th>{{ trans('admin.inv_date_time') }}</th>
                                <th>{{ trans('admin.customer_name') }}</th>
                                <th>{{ trans('admin.is_pending') }}</th>
                                {{-- <th>{{ trans('admin.is_approved') }}</th> --}}
                                <th>{{ trans('admin.created_by') }}</th>
                                <th>{{ trans('admin.updated_by') }}</th>
                                <th>{{trans('admin.show')}}</th>
                                <th>إجمالي المبلغ</th>
                                {{-- <th>{{trans('admin.continue_adding')}}</th> --}}
                                <th>  رد الفاتورة</th>
                                <th>محذوفة / مردودة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerInvoices as $customerInv)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                <td>{{ $customerInv->customer_inv_num }}</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($customerInv->customer_inv_date_time)->format('d-m-Y ') }}
                                        <br>
                                        {{ Carbon\Carbon::parse($customerInv->customer_inv_date_time)->format('h:i A') }}
                                    </td>
                                    <td>{{ $customerInv->customer->name }}</td>
                                    <td class="text-{{ $customerInv->is_pending == 1 ? 'danger' : 'success' }}">{{ $customerInv->is_pending == 1 ? trans('admin.pending_invoice') : trans('admin.completed_invoice') }}</td>

                                    <td>{{ App\Models\User::where('id',$customerInv->created_by)->first()->name }}</td>
                                    <td>{{$customerInv->updated_by ?  App\Models\User::where('id',$customerInv->updated_by)->first()->name : '---'}}</td>
                                    <td>
                                        <a href="{{ route('customers.show_invoice',['id'=> $customerInv->id]) }}">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.show')}}">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                     <td>{{$customerInv->total_after_discount}}</td>
                                    @php
                                        $selectedTranaction = App\Models\Transaction::where('account_num',$customerInv->customer->account_num)
                                        ->where('inv_num',$customerInv->customer_inv_num)->first();
                                    @endphp
                                
                                    {{-- </td>
                                    <td>
                                        <a class="dropdown-item" href="#" class="modal-effect text-danger btn-sm"
                                            data-toggle="modal"
                                            wire:click="$dispatch('return CustomerInvItems',{id:{{$customerInv->id}}})" title="{{ trans("admin.return_all_invoice") }}">
                                            <button class="btn " {{$customerInv->deleted_at  != null ? 'disabled' :''}}>
                                                <i class="fas fa-undo-alt text-danger mx-1"></i>
                                            </button>
                                        </a>   
                                    </td> --}}
                                    <td>
                                        <a href="#" class="modal-effect"
                                            data-toggle="modal"
                                            wire:click="$dispatch('returnInvItems',{id:{{$customerInv->id}}})" title="{{ trans("admin.return_all_invoice") }}">
                                            <button class="btn " {{ $customerInv->return_status == 10 ? 'disabled' : ''}}>
                                                <i class="fas fa-undo-alt text-danger"></i>
                                            </button>
                                        </a>
                                        {{-- <a class="dropdown-item" href=""><i class="fa fa-print mx-1" aria-hidden="true"></i>  {{trans('admin.print_invoice')}} </a> --}}

                                    </td>
                                    <td>
                                        {{-- <a href="">
                                            <button type="button"  title="{{trans('admin.no_returns')}}" class="btn btn-outline-info btn-sm mx-1" >
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </a>
                                        <i class="fas fa-times"></i> --}}
                                        @if($customerInv->return_status == 10)
                                           رد كامل البنود
                                        @elseif ($customerInv->return_status == 11)
                                            رد جزئي للبنود
                                        @elseif (($customerInv->return_status == 10) && ($customerInv->deleted_at != null))
                                            {{trans('admin.deleted_invoice')}}
                                        @endif
                                    </td>
             
                                </tr>

                                {{-- <livewire:customerInvoices.update-product :product="$customerInv" /> --}}
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{ trans('admin.not_found') }}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$customerInvoices->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





