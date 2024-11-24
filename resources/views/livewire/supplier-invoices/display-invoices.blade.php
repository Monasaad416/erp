<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.suppliers_invoices_list')}}</h4>
                    @can('اضافة-فاتورة-مورد')
                    <a href="{{ route('suppliers.create_invoice') }}" class="text-white">
                        <button type="button" class="btn bg-gradient-cyan" title="إضافة فاتورة">
                            <span style="font-weight: bolder; font-size:">{{trans('admin.create_supplier_invoice')}}</span>
                        </button>
                    </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control mx-1" placeholder="{{trans('admin.search_by_supp_inv_num')}}" wire:model.live="searchItem">
                        <select class="form-control mx-1" placeholder="{{trans('admin.search_by_supp_inv_completed')}}" wire:model.live="pending_status">
                            <option value="" >{{trans('admin.select_status')}}</option>
                            <option value="1" {{$pending_status === 1 ? 'selected':''}}>{{trans('admin.pending_invoice')}}</option>
                            <option value="0" {{$pending_status === 0 ? 'selected':''}}>{{trans('admin.completed_invoice')}}</option>
                        </select>
                        <select class="form-control mx-1" placeholder="{{trans('admin.search_by_supp_inv_completed')}}" wire:model.live="return_status">
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

                @if($suppInvoices->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                            font-size: 14px;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.inv_num') }}</th>
                                <th>{{ trans('admin.inv_date_time') }}</th>
                                <th>{{ trans('admin.supplier_name') }}</th>
                                <th>إجمالي المبلغ</th>
                                <th>ماتم سداده</th>
                                <th>{{ trans('admin.is_pending') }}</th>
                                {{-- <th>{{ trans('admin.is_approved') }}</th> --}}
                                <th>{{ trans('admin.created_by') }}</th>
                                @can('تفاصيل-فاتورة-مورد')
                                <th>{{trans('admin.show')}}</th>
                                @endcan
                                <th>حالة الفاتورة</th>
                                @can('اصدار-ايصال-صرف')
                                <th>إصدار ايصال صرف</th>
                                @endcan

                                @can('اضافة-شيك')
                                <th>إصدار شيك </th>
                                @endcan
                                {{-- <th>{{trans('admin.continue_adding')}}</th> --}}
                                <th>مردودات</th>

                                 @can('اضافة-مردودات-فاتورة-مورد')
                                <th>رد الفاتورة</th>
                                @endcan
                                @can('تعديل-فاتورة-مورد')
                                <th>{{trans('admin.edit')}}</th>
                                @endcan
                                @can('حذف-فاتورة-مورد')
                                <th>{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppInvoices as $suppInv)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $suppInv->supp_inv_num }}</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($suppInv->created_at)->format('d-m-Y ') }}
                                        <br>
                                        {{ Carbon\Carbon::parse($suppInv->created_at)->format('h:i A') }}
                                    </td>
                                    <td>{{ $suppInv->supplier->name }}</td>
                                    <td>{{ $suppInv->total_after_discount }}</td>
                                    <td>{{ $suppInv->paid_amount }}</td>
                                    <td>
                                        <span class="badge badge-{{ $suppInv->is_pending == 1 ? 'danger' : 'success' }}">
                                            {{ $suppInv->is_pending == 1 ? trans('admin.pending_invoice') : trans('admin.completed_invoice') }}
                                        </span>
                                    </td>
                                    {{-- <td>
                                        <button type="button" class="btn btn-{{$suppInv->is_approved == 1 ? 'success' : 'danger'}} btn-sm mx-1" title="{{$suppInv->is_approved == 1 ? trans('admin.is_approved') : trans('admin.not_approved_yet') }}"
                                            data-toggle="modal"

                                            wire:click="$dispatch('approveInvoice',{id:{{$suppInv->id}}})">
                                            <i class="fa fa-toggle-{{$suppInv->is_approved == 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td> --}}
                                    <td>{{ App\Models\User::where('id',$suppInv->created_by)->first()->name }}</td>

                                    <td>
                                        <a href="{{ route('suppliers.show_invoice',['id'=> $suppInv->id]) }}">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.show')}}">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>

                                    {{-- @can('تعديل منتج') --}}
                                    {{-- <td>

                                        <a href="{{ route('suppliers.create_invoice_items',['invoice_num'=> $suppInv->supp_inv_num]) }}">
                                            <button type="button"  {{ $suppInv->is_pending  == 1 ? '' :'disabled'}} title="{{trans('admin.continue_adding')}}" class="btn btn-outline-success btn-sm mx-1" title="{{trans('admin.edit')}}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </a>

                                    </td> --}}
                                    @php
                                        $status ='';$label='';
                                        if($suppInv->status == 1 ) {
                                            $status = 'غير مسددة';
                                            $label = 'danger';

                                        }elseif($suppInv->status == 2 ) {
                                            $status = 'مسددة ';
                                            $label = 'success';
                                        }
                                        elseif($suppInv->status == 3 ) {
                                            $status = ' مسددة جزئيا';
                                            $label = 'info';
                                        }
                                        elseif($suppInv->status == 4 ) {
                                            $status = 'مستحقة';
                                            $label = 'indigo';
                                        }
                                        elseif($suppInv->status == 5 ) {
                                            $status = 'مسددة مقدما';
                                            $label = 'warning';
                                        }
                                    @endphp
                                    <td>
                                        <span class="badge badge-{{ $label }}">{{$status}}</span>
                                    </td>

                                    @php
                                        $total = $suppInv->total_after_discount;
                                        $paid = $suppInv->paid_amount;
                                    @endphp
                                    <td>
                                        <a href="{{ route('create_exchange_reciept',['inv_num'=>$suppInv->supp_inv_num]) }}">
                                            <button type="button" {{ $suppInv->status == 2 || $suppInv->return_status == 10 ? 'disabled' : ''}} title="إضافة إيصال دفع" class="btn btn-outline-primary btn-sm mx-1" title="إضافة إيصال دفع">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                        </a>
                                    </td>
                                   {{-- <td>
                                        <a href="{{ route('bank.transactions.create',['inv_num'=>$suppInv->supp_inv_num]) }}">
                                            <button type="button" {{ $suppInv->status == 2 || $suppInv->return_status == 10 ? 'disabled' : ''}} title="إضافة شيك " class="btn btn-outline-dark btn-sm mx-1" title="إضافة شيك ">
                                                <i class="fas fa-money-check-alt"></i>
                                            </button>
                                        </a>
                                    </td> --}}


                                    <td>
                                        {{-- <a href="">
                                            <button type="button"  title="{{trans('admin.no_returns')}}" class="btn btn-outline-info btn-sm mx-1" >
                                            <i class="fas fa-check"></i>
                                        </button>
                                        </a>
                                        <i class="fas fa-times"></i> --}}
                                        @if($suppInv->return_status == 10)
                                            {{trans('admin.return_invoice')}}
                                        @elseif ($suppInv->return_status == 11)
                                            {{trans('admin.returned')}}
                                        @elseif ($suppInv->return_status == 12)
                                            {{trans('admin.partially_returned')}}
                                        @elseif ($suppInv->deleted_at !== null)
                                            {{trans('admin.deleted_invoice')}}
                                        @endif
                                    </td>
                                    @can('اضافة-مردودات-فاتورة-مورد')

                                    <td>
                                        <a href="#" class="modal-effect"
                                            data-toggle="modal"
                                            wire:click="$dispatch('returnInvItems',{id:{{$suppInv->id}}})" title="{{ trans("admin.return_all_invoice") }}">
                                            <button class="btn " {{ $suppInv->return_status == 10 ? 'disabled' : ''}}>
                                                <i class="fas fa-undo-alt text-danger"></i>
                                            </button>
                                        </a>
                                        {{-- <a class="dropdown-item" href=""><i class="fa fa-print mx-1" aria-hidden="true"></i>  {{trans('admin.print_invoice')}} </a> --}}

                                    </td>
                                    @endcan
                                     @can('تعديل-فاتورة-مورد')
                                    <td>

                                        <a href="{{ route('suppliers.edit_invoice',['inv_num'=>$suppInv->supp_inv_num]) }}">
                                            <button type="button" {{ $suppInv->return_status == 10 ? 'disabled' : ''}} title="{{trans('admin.edit')}}" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </a>
                                        {{-- <button type="button"   class="btn btn-outline-info btn-sm mx-1" "
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateSuppInvoice',{id:{{$suppInv->id}}})">

                                        </button> --}}
                                    </td>
                                      @endcan

                                    @can('حذف-فاتورة-مورد')
                                    <td>
                                        <button type="button" {{ $suppInv->return_status == 10 ? 'disabled' : ''}} class="btn btn-outline-danger btn-sm mx-1"  title="{{trans('admin.delete')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSuppInvoice',{id:{{$suppInv->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                        @endcan

                                </tr>

                                {{-- <livewire:suppInvoices.update-product :product="$suppInv" /> --}}
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{ trans('admin.not_found') }}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$suppInvoices->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





