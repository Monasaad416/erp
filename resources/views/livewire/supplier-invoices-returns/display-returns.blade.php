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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ trans('admin.product_code') }}</th>
                        <th>{{ trans('admin.name_ar') }}</th>
                        <th>{{ trans('admin.name_en') }}</th>
                        <th>{{ trans('admin.unit') }}</th>
                        <th>{{ trans('admin.qty') }}</th>
                        <th>حالة الرد</th>
                        <th>{{ trans('admin.sale_price') }}</th>
                        <th> {{ trans('admin.tax_value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                
                        @foreach ($items as $item)
                            <tr>
                                @php
                            
                                    if($item->return_status === 1 ) {
                                        $status = 'رد كلي للفاتورة';
                                    }
                                    if($item->return_status ===2 ) {
                                        $status = 'رد كلي للبند';
                                    }
                                    if($item->return_status === 3 ) {
                                        $status = 'رد جزئي للبند';
                                    }
                                @endphp
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
                                <td>{{ $item->return_qty }}</td>
                                <td>{{ $status }}</td>
                                <td>{{ $item->sale_price}}</td>
                                <td>{{ $item->taxes ?  $item->taxes : 0}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
