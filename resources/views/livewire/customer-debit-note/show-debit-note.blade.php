
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @php
                        $invoice = App\Models\CustomerInvoice::where('id',$invoiceDebitNote->customer_invoice_id)->first();
                    @endphp
                    <h4 class="card-title h4">إشعار مدين رقم {{$invoiceDebitNote->serial_num  }}  
                         {{ $invoice ?  "والخاص بفاتورة مبيعات رقم " . $invoice->customer_inv_num : ""  }}</h4>
                    <a href="{{ route('customers_debit_notes.print_debit_note',[ 'debit_note_num' => $invoiceDebitNote->serial_num ]) }}">
                        <button type="button" title="طباعة" class="btn btn-outline-secondary mx-1">
                            <i class="fas fa-print"></i>
                        </button>
                    </a>
                </div>

            </div>

            <div class="card-body">

                @if($items->count() > 0)

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
                        <th>{{ trans('admin.product_code') }}</th>
                        <th>{{ trans('admin.name') }}</th>
                        <th>{{ trans('admin.unit') }}</th>
                        <th>{{ trans('admin.qty') }}</th>
                        {{-- <th>حالة الرد</th> --}}
                        <th>{{ trans('admin.sale_price') }}</th>
                        <th> {{ trans('admin.tax_value') }}</th>

               
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($items as $item)
                        {{-- {{dd($item)}} --}}
                         
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                        <td>
                                            {{$invoiceDebitNote->branch->name}}
                                        </td>
                                    @endif 
                                    <td>
                                        @php
                                            $invoiceDebitNote = App\Models\CustomerDebitNote::where('id',$item->customer_debit_note_id)->first();
                                            $invoice = App\Models\CustomerInvoice::withTrashed()->where('id',$invoiceDebitNote->customer_invoice_id)->first();
                                            //dd($invoice);
                                        @endphp
                                        {{ $invoice ? $invoice->customer_inv_num : '---' }}
                                    </td>   
                                    <td>
                                        {{$item->product_code}}
                                    </td>
                                    <td>
                                        {{ $item->product_name_ar }}
                                    </td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->return_qty }}</td>
                                    {{-- <td>{{ $status }}</td> --}}
                                    <td>{{ $item->sale_price}}</td>
                                    <td>{{ $item->taxes ?  $item->taxes : 0}}</td>
                 
                                </tr>
                
                        @endforeach
                    </tbody>
                </table>
            </div>

                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$items->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
