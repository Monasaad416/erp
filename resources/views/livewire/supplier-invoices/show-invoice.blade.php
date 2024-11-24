

<div class="row">
    @php
        $transactions = App\Models\Transaction::where('transactionable_type','App\Models\Supplier')->where('inv_num',$invoice->supp_inv_num)->get();
        $bankTransactions = App\Models\BankTransaction::where('transactionable_type','App\Models\Supplier')->where('inv_num',$invoice->supp_inv_num)->get();
    @endphp
    <div class="col">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">{{ trans('admin.details') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-receipts-tab" data-toggle="pill" href="#custom-tabs-two-receipts" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">إيصالات صرف </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-receipts-tab" data-toggle="pill" href="#custom-tabs-two-checks" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false"> شيكات دفع  </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                         <div class="card-body">
                                            <h5 class="text-danger my-4">{{ trans('admin.supplier_invoice_details') }} {!! "&nbsp;" !!}{{ $invoice->supp_inv_num }}</h5>

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>{{ trans('admin.product_code') }}</th>
                                                        <th>{{ trans('admin.name_ar') }}</th>
                                                        <th>{{ trans('admin.name_en') }}</th>
                                                        <th>{{ trans('admin.unit') }}</th>
                                                        <th>{{ trans('admin.qty') }}</th>
                                                        <th>{{ trans('admin.wholesale_inc_vat') }}</th>
                                                        <th>{{ trans('admin.purchase_price') }}</th>
                                                        <th> {{ trans('admin.tax_value') }}</th>
                                                        <th>الإجمالي</th>
                                                        <th>{{ trans('admin.batch_num') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($invoice_products as $item)
                                                            <tr>
                                                                {{-- {{ dd($item) }}  --}}
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>
                                                                    {{$item->product_code}}
                                                                </td>
                                                                <td>
                                                                    {{ $item->product_name_ar }}
                                                                </td>
                                                                <td>
                                                                    {{ $item->product_name_en }}
                                                                </td>
                                                                <td>{{ $item->unit }}</td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td>{{ $item->wholesale_inc_vat ?  $item->wholesale_inc_vat : 0}}</td>

                                                                <td>{{ $item->purchase_price ?  $item->purchase_price : 0}}</td>
                                                                <td>{{ $item->tax_value ?  $item->tax_value : 0}}</td>
                                                                <td>{{ $item->tax_value ?  $item->tax_value + $item->purchase_price : $item->purchase_price}}</td>
                                                                <td>{{ $item->batch_num ?  $item->batch_num : '---'}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                        </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-receipts" role="tabpanel" aria-labelledby="custom-tabs-two-receipts-tab">
                                    <div class="card-body">
                                            <h5 class="text-danger my-4">إيصالات الصرف لسداد فاتورة مورد رقم {!! "&nbsp;" !!}{{ $invoice->supp_inv_num }}</h5>

                                            <h6 class="text-muted mb-3">المورد : {{$invoice->supplier->name}}</h6>
                                            @if($transactions->count() > 0)
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th> وردية الخزينة</th>
                                                        <th> مسئول الخزينة</th>
                                                        <th>قيمة الإيصال</th>
                                                        <th>المبلغ المستحق للحساب</th>
                                                        <th>الوصف</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($transactions as $trans)
                                                            <tr>
                                                                {{-- {{ dd($trans) }}  --}}
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>
                                                                    {{$trans->treasuryShift->deliveredToShiftType->label()}}
                                                                </td>
                                                                <td>
                                                                    {{$trans->treasuryShift->deliveredTo->name}}
                                                                </td>
                                                                <td>
                                                                    {{ $trans->receipt_amount }}
                                                                </td>
                                                                <td>
                                                                    {{ $trans->deserved_account_amount }}
                                                                </td>
                                                                <td>{{ $trans->description ?? null }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p class="h4 text-muted text-center">{{ trans('admin.not_found') }}</p>
                                            @endif
                                        </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-banks" role="tabpanel" aria-labelledby="custom-tabs-two-receipts-tab">
                                    <div class="card-body">
                                            <h5 class="text-danger my-4">شيكات  لسداد فاتورة مورد رقم {!! "&nbsp;" !!}{{ $invoice->supp_inv_num }}</h5>

                                            <h6 class="text-muted mb-3">المورد : {{$invoice->supplier->name}}</h6>
                                            @if($bankTransactions->count() > 0)
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>البنك</th>
                                                        <th>رقم الشيك</th>
                                                        <th>قيمة الشيك</th>
                                                        <th>المبلغ المستحق للحساب</th>
                                                        <th>الوصف</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($transactions as $trans)
                                                            <tr>
                                                                {{-- {{ dd($trans) }}  --}}
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>
                                                                    {{$trans->treasuryShift->deliveredToShiftType->label()}}
                                                                </td>
                                                                <td>
                                                                    {{$trans->treasuryShift->deliveredTo->name}}
                                                                </td>
                                                                <td>
                                                                    {{ $trans->receipt_amount }}
                                                                </td>
                                                                <td>
                                                                    {{ $trans->deserved_account_amount }}
                                                                </td>
                                                                <td>{{ $trans->description ?? null }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p class="h4 text-muted text-center">{{ trans('admin.not_found') }}</p>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

