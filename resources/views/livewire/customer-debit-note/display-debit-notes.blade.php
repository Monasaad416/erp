
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة إشعارات المدين</h4>
                    @can('اضافة-مردودات-فاتورة-عميل')
                        <a href="{{ route('customers.create_debit_note') }}" id="newInvoice" class="text-white">
                            <button type="button" class="btn bg-gradient-cyan"  title="إضافة إشعار مدين">
                                <span style="font-weight: bolder; font-size:">إضافة إشعار مدين </span>
                            </button>
                        </a>
                    @endcan
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
                        <th>رقم الإشعار</th>
                        <th>التفاصيل</th>
                        <th>طباعة</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($items as $item)
                            <tr>
                                {{-- {{ dd($item) }}  --}}
                                <td>{{$loop->iteration}}</td>
                                @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                    <td>
                                        {{$item->branch->name}}
                                    </td>
                                @endif
                                <td>
                                    @php
                                        $invoice = App\Models\CustomerInvoice::withTrashed()->where('id',$item->customer_invoice_id)->first();
                                        //dd($invoice);
                                    @endphp
                                    {{ $item->customer_invoice_id ? $invoice->customer_inv_num : '---' }}
                                </td>
                                <td>
                                    {{$item->serial_num}}
                                </td>
                                <td>
                                    <a href="{{ route('customers_debit_notes.show_debit_note',['debit_note_num'=> $item->serial_num]) }}">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.show')}}">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    @if($invoice)
                                        <a href="{{ route('customers_debit_notes.print_debit_note',[ 'debit_note_num' => $item->serial_num ]) }}">
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
                    {{$items->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
