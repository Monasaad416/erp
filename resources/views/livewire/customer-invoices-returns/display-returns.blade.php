
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة المردودات</h4>
                    @can('اضافة-مردودات-فاتورة-عميل')
                        <a href="{{ route('customers.create_invoice_return') }}" id="newInvoice" class="text-white">
                            <button type="button" class="btn bg-gradient-cyan"  title="رد بند فاتورة مبيعات">
                                <span style="font-weight: bolder; font-size:">رد بند (إشعار دائن)</span>
                            </button>
                        </a>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($returns->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_category')}} " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        @if(Auth::user()->roles_name == 'سوبر-ادمن')
                            <th>{{ trans('admin.branch') }}</th>
                        @endif
                        <th>رقم الفاتورة</th>
                        <th>رقم الإشعار</th>
                        <th>الحالة</th>
                        <th>التفاصيل</th>
                        <th>طباعة</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($returns as $return)
                         
                            <tr>
                                @php

                                    if($return->return_status === 1 ) {
                                        $status = 'رد كلي للفاتورة';
                                    }
                                    if($return->return_status ===2 ) {
                                        $status = 'رد كلي للبند';
                                    }
                                    if($return->return_status === 3 ) {
                                        $status = 'رد جزئي للبند';
                                    }
                                    else{
                                        $status = '---';
                                    }
                                @endphp
                                {{-- {{ dd($return) }}  --}}
                                <td>{{$loop->iteration}}</td>
                                @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <td>
                                        {{$return->branch->name}}
                                    </td>
                                @endif 
                                <td>
                                    @php
                                        $invoice = App\Models\CustomerInvoice::withTrashed()->where('id',$return->customer_invoice_id)->first();
                                        //dd($invoice);
                                    @endphp
                                    {{ $return->customer_invoice_id ? $invoice->customer_inv_num : '---' }}
                                </td>   
                                <td>{{$return->serial_num}}</td>
                                <td>{{ $status }}</td>
                                <td>
                                    <a href="{{ route('customers_returns.show_return',['return_num'=> $return->serial_num]) }}">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.show')}}">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    @if($invoice)
                                    <a href="{{ route('customers_returns.print_return',[ 'return_num' => $return->serial_num ]) }}">
                                        <button type="button" title="طباعة" class="btn btn-outline-dark btn-sm mx-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </a>
                                    @else
                                    <span>---</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$returns->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
