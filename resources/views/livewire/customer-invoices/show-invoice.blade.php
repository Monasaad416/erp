<div>

    <div class="card-body">
        <h3 class="text-muted my-3">{{ trans('admin.customer_invoice_details') }} {!! "&nbsp;" !!}{{ $invoice->customer_inv_num }}</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('admin.product_code') }}</th>
                <th>{{ trans('admin.name_ar') }}</th>
                <th>{{ trans('admin.name_en') }}</th>
                <th>{{ trans('admin.unit') }}</th>
                <th>{{ trans('admin.qty') }}</th>
                <th>{{ trans('admin.sale_price') }}</th>
                <th> {{ trans('admin.tax_value') }}</th>
                </tr>
            </thead>
            <tbody>
        
                @foreach ($items as $item)
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
                        <td>{{ $item->sale_price}}</td>
                        <td>{{ $item->taxes ?  $item->taxes : 0}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <h3 class="text-danger my-3">إشعارات الدائن</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('admin.product_code') }}</th>
                <th>{{ trans('admin.name_ar') }}</th>
                <th>{{ trans('admin.name_en') }}</th>
                <th>{{ trans('admin.unit') }}</th>
                <th>{{ trans('admin.qty') }}</th>
                <th>{{ trans('admin.sale_price') }}</th>
                <th> {{ trans('admin.tax_value') }}</th>
                <th>رقم الإشعار</th>
                <th> طباعة</th>
                </tr>
            </thead>
            <tbody>
        
                @foreach ($returns as $serial_num => $items)
                    @php
                        $rowspan = count($items);
                    @endphp
                    @foreach($items as  $index=>$return)
                        <tr>
                            {{-- {{ dd($return) }}  --}}
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$return->product_code}}
                            </td>
                            <td>
                                {{ $return->product_name_ar }}
                            </td>
                            <td>
                                {{ $return->product_name_en }}
                            </td>
                            <td>{{ $return->unit }}</td>
                            <td>{{ $return->qty }}</td>
                            <td>{{ $return->sale_price}}</td>
                            <td>{{ $return->taxes ?  $return->taxes : 0}}</td>
                            @if ($index === 0)
                                <td rowspan="{{ $rowspan }}">{{ $serial_num }}</td>
                            @endif
                            <td></td>
                        </tr>
                    @endforeach    
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-body">
        <h3 class="text-success my-3">إشعارات المدين</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th>{{ trans('admin.product_code') }}</th>
                <th>{{ trans('admin.name_ar') }}</th>
                <th>{{ trans('admin.name_en') }}</th>
                <th>{{ trans('admin.unit') }}</th>
                <th>{{ trans('admin.qty') }}</th>
                <th>{{ trans('admin.sale_price') }}</th>
                <th> {{ trans('admin.tax_value') }}</th>
                <th>رقم الإشعار</th>
                <th> طباعة</th>
                </tr>
            </thead>
            <tbody>
        
                @foreach ($debitNotes as $serial_num => $notes)
                    @php
                        $rowspan = count($notes);
                    @endphp
                    @foreach ($notes as  $index =>$debit)
                
                        <tr>
                            {{-- {{ dd($debit) }}  --}}
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$debit->product_code}}
                            </td>
                            <td>
                                {{ $debit->product_name_ar }}
                            </td>
                            <td>
                                {{ $debit->product_name_en }}
                            </td>
                            <td>{{ $debit->unit }}</td>
                            <td>{{ $debit->qty }}</td>
                            <td>{{ $debit->sale_price}}</td>
                            <td>{{ $debit->taxes ?  $debit->taxes : 0}}</td>
                            <td>{{ $serial_num}}</td>
                            <td>{{ $debit->sale_price}}</td>
                            @if ($index === 0)
                                <td rowspan="{{ $rowspan }}">{{ $serial_num }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
