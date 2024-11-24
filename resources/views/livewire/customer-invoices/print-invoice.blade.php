<div id="print">
    <div class="row m-auto" style="width: 400px ;height: auto;">
        <style>
            .details {
                font-size : 12px !important;
            }
            hr {
                height: 3px;
                border-style: dotted;
            }

            @media print {
                @page {
                    size: auto;   /* auto is the initial value */
                    margin: 0;  /* this affects the margin in the printer settings */
                    height: auto;
                }
            }
        </style>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h6>فاتورة ضريبية مبسطة</h6><br>
                        <span>رقم الفاتورة : {{ $invoice->customer_inv_num }}</span><br>
                        <span> {{ $settings->name }}</span><br>
                        <span>{{ $invoice->branch->name }}</span><br>
                        <span>{{ $invoice->branch->street_name }}</span><br>
                        <span>{{ $invoice->branch->phone }}</span><br>
                        {{-- <span>فاتورة بيع</span><br> --}}
                        {{-- <span style="text-decoration: underline">مبيعات نقدية</span><br>
                        <span>صيدلية دان الرعاية</span><br> --}}
                        <span> {{ $invoice->branch->costCenter->name }}</</span><br>
                        <span>رقم التليفون : {{ $invoice->branch->street_name }}</span><br>
                        {{-- <span>الرقم الضريبي  : {{ $invoice->branch->street_name }}</span><br> --}}
                        <hr>

                        <span>تاريخ الفاتورة : {{ \Carbon\Carbon::parse($invoice->customer_inv_date_time)->toDateString() }}</span><br>
                        <span>توقيت الفاتورة : {{ \Carbon\Carbon::parse($invoice->customer_inv_date_time)->toTimeString() }}</span><br>

                        <hr>
                        <div class="d-flex justify-content-space-between">
                            <div class="col-6">رقم المستخدم :</div> {{Auth::user()->id}}
                        </div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <span> رقم تسجيل ضريبة القيمة المضافة : {{ $settings->tax_num }}</span><br>
                    </div>    
                    <div>
                        @if($invoiceItems->count() > 0)
                        <style>
                            .table thead tr th{
                                text-align:center;
                            }
                        </style>
                        <table class="table ">
                            @php
                                $totalQty =0;
                                $totalPrice =0;
                                $totalTax =0;

                            @endphp
                            <thead>
                                <tr>
                                <th>{{trans('admin.name')}}</th>
                                <th>{{trans('admin.product_code')}}</th>
                                <th>{{trans('admin.qty')}}</th>
                                <th>{{trans('admin.price')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceItems as $item)
                                    <tr>
                                        @php
                                            $code = App\Models\ProductCode::where('product_id',$item->product_id)->latest()->first()->code;
                                            $product = App\Models\Product::where('id',$item->product_id)->first();
                                            $settings = App\Models\Setting::findOrFail(1);
                                            $tax = $product->taxes == 1 ? $settings->vat * $item->sale_price : 0;
                                            $totalQty += $item->qty;
                                            $totalPrice += $item->sale_price + $tax;
                                            $totalTax += $tax;
                                        @endphp
                                        <td class="text-center" >{{$item->product_name_ar}}</td>
                                        <td>{{ $code }}</td>
                                        <td class="text-center" style="width:8%">{{ $item->qty }}</td>
                                        <td >{{ $item->sale_price +$tax }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tr style="background: transparent">
                                <tr>
                                <td class="details">عدد القطع</td>
                                <td class="details">{{$totalQty}}</td>
                                <td class="details">الإجمالي</td>
                                <td class="details">{{$totalPrice}}</td>
                                </tr>
                            </tr>
                            <tr style="background: transparent">
                                <tr>
                                <td class="details">الخصم</td>
                                <td class="details">{{$invoice->discount_percentage * $invoice->total_before_discount}}</td>
                                <td class="details">الشبكة</td>
                                <td class="details">0</td>
                                </tr>
                            </tr>
                            <tr style="background: transparent">
                                <tr>
                                <td class="details">المبلغ المدفوع</td>
                                <td class="details">{{$totalPrice}}</td>
                                <td class="details">الصافي</td>
                                <td class="details">{{$totalPrice}}</td>
                                </tr>
                            </tr>
                            <tr style="background: transparent">
                                <tr>
                                <td class="details">الباقي</td>
                                <td class="details">0</td>
                                <td class="details">نقط الإستبدال</td>
                                <td class="details">0</td>
                                </tr>
                            </tr>
                        </table>
                        <hr >
                        <div class="d-flex justify-content-between">
                            <span style="font-size: 16px"> المجموع شامل ضريبة القيمة المضافة(ريال):</span>
                            <span style="font-size: 16px">  {{ $totalPrice }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span style="font-size: 16px"> ضريبة القيمة المضافة(15%):</span>
                            <span style="font-size: 16px">  {{ $totalTax }}</span>
                        </div>
                        
                        
                            <hr >
                            @php
                                $domain = request()->getHost();
                                $languagePath = request()->segment(1);
                                $domainWithLang = $domain.'/'.$languagePath;
                                $fullDomain = $domainWithLang ."/invoices/print/". $invoice->customer_inv_num;
                            @endphp
                            <div class="text-center">
                                {!! DNS1D::getBarcodeSVG($invoice->customer_inv_num, 'C39',0.75,44) !!}
                            </div>


                        <p class="mt-3 text-center" style="font-size:12px">نرجو إحضار الفاتورة عند الإستبدال أو الإسترجاع </p>

                        <p class="mt-5">ملاحضات</p>
                        <p>- الإسترجاع خلال 24 ساعة من تاريخ الشراء</p>
                        <p>- الإستبدال خلال 5 أيام  من تاريخ الشراء</p>
                        <p>- يجب أن يكون المنتج في حالتة الأصلية</p>
                        <p>- يجب إحضار الفاتورة الأصلية لإتمام عملية الإستبدال و الإسترجاع</p>
                        <p>- المنتجات التي يتم شراؤها خلال فترة التخفيضات يمكن إرجاعها و إستبدالها خلال فترة التخفيضات فقط</p>
                    @else
                        <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                    @endif

                    </div>

                    <p>>>>>>>>>>>>>0100أغلاق الفاتورة>>>>>>>>>>> </p>

                    <div class="d-flex justify-content-around">
                        <img src="{{ $displayQRCodeBase64 }}" width="100px" alt="qr_code">
                    </div>

          

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button class="btn btn-secondary  float-left mt-3 mr-2" id="print_button" onclick="printDiv()"> <i class="fas fa-print ml-1"></i>طباعة</button>
        </div>

    </div>
    <script>
        // function openPrintPage() {
        //     var printWindow = window.open('', '_blank');
        //     printWindow.document.open();
        //     printWindow.document.write('<html><head><title>Print</title></head><body>');
        //     printWindow.document.write(document.getElementById('print').innerHTML);
        //     printWindow.document.write('</body></html>');
        //     printWindow.document.close();
        //     printWindow.print();
        // }

        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            location.reload();
        }
    </script>
</div>







