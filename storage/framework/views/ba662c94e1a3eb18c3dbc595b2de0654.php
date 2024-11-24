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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h6>إشعار دائن للفاتورة الضريبية المبسطة</h6><br>
                        <span>رقم الاشعار : <?php echo e($invoiceReturn->serial_num); ?></span><br>
                        <span>رقم الفاتورة : <?php echo e(App\Models\CustomerInvoice::withTrashed()->where('id',$invoiceReturn->customer_invoice_id)->first()->customer_inv_num); ?></span><br>
                        <span><?php echo e($settings->name); ?></span><br>
                        <span><?php echo e($invoiceReturn->branch->name); ?></span><br>
                        <span><?php echo e($invoiceReturn->branch->address); ?></span><br>
                        <span><?php echo e($invoiceReturn->branch->phone); ?></span><br>
                        
                        
                        <span> <?php echo e($invoiceReturn->branch->costCenter->name); ?></</span><br>
                        <span>رقم التليفون : <?php echo e($invoiceReturn->branch->address); ?></span><br>
                        
                        <hr>

                        <span>تاريخ الفاتورة : <?php echo e(\Carbon\Carbon::parse($invoiceReturn->customer_inv_date_time)->toDateString()); ?></span><br>
                        <span>توقيت الفاتورة : <?php echo e(\Carbon\Carbon::parse($invoiceReturn->customer_inv_date_time)->toTimeString()); ?></span><br>

                        <hr>
                        <div class="d-flex justify-content-space-between">
                            <div class="col-6">رقم المستخدم :</div> <?php echo e(Auth::user()->id); ?>

                        </div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <span> رقم تسجيل ضريبة القيمة المضافة : <?php echo e($settings->tax_num); ?></span><br>
                    </div>    
                    <div>
                        <!--[if BLOCK]><![endif]--><?php if($invoiceReturnItems->count() > 0): ?>
                        <style>
                            .table thead tr th{
                                text-align:center;
                            }
                        </style>
                        <table class="table ">
                            <?php
                                $totalQty =0;
                                $totalPrice =0;
                                $totalTax =0;

                            ?>
                            <thead>
                                <tr>
                                <th><?php echo e(trans('admin.name')); ?></th>
                                <th><?php echo e(trans('admin.product_code')); ?></th>
                                <th><?php echo e(trans('admin.qty')); ?></th>
                                <th><?php echo e(trans('admin.price')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $invoiceReturnItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php
                                            $code = App\Models\ProductCode::where('product_id',$item->product_id)->latest()->first()->code;
                                            $product = App\Models\Product::where('id',$item->product_id)->first();
                                            $settings = App\Models\Setting::findOrFail(1);
                                            $tax = $product->taxes == 1 ? $settings->vat * $item->sale_price : 0;
                                            $totalQty += $item->qty;
                                            $totalPrice += $item->sale_price + $tax;
                                            $totalTax += $tax;
                                        ?>
                                        <td class="text-center" ><?php echo e($item->product_name_ar); ?></td>
                                        <td><?php echo e($code); ?></td>
                                        <td class="text-center" style="width:8%"><?php echo e($item->qty); ?></td>
                                        <td ><?php echo e($item->sale_price +$tax); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>

                            <tr style="background: transparent">
                                <tr>
                                <td class="details">عدد القطع</td>
                                <td class="details"><?php echo e($totalQty); ?></td>
                                <td class="details">الإجمالي</td>
                                <td class="details"><?php echo e($totalPrice); ?></td>
                                </tr>
                            </tr>
                            <tr style="background: transparent">
                                <tr>
                                <td class="details">الخصم</td>
                                <td class="details"><?php echo e($invoiceReturn->discount_percentage * $invoiceReturn->total_before_discount); ?></td>
                                <td class="details">الشبكة</td>
                                <td class="details">0</td>
                                </tr>
                            </tr>
                            <tr style="background: transparent">
                                <tr>
                                <td class="details">المبلغ المدفوع</td>
                                <td class="details"><?php echo e($totalPrice); ?></td>
                                <td class="details">الصافي</td>
                                <td class="details"><?php echo e($totalPrice); ?></td>
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
                            <span style="font-size: 16px">  <?php echo e($totalPrice); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span style="font-size: 16px"> ضريبة القيمة المضافة(15%):</span>
                            <span style="font-size: 16px">  <?php echo e($totalTax); ?></span>
                        </div>
                        
                        
                            <hr >
                            <?php
                                $domain = request()->getHost();
                                $languagePath = request()->segment(1);
                                $domainWithLang = $domain.'/'.$languagePath;
                                $fullDomain = $domainWithLang ."/invoices/print/". $invoiceReturn->customer_inv_num;
                            ?>
                            <div class="text-center">
                                <?php echo DNS1D::getBarcodeSVG($invoiceReturn->customer_inv_num, 'C39',0.75,44); ?>

                            </div>


                        <p class="mt-3 text-center" style="font-size:12px">نرجو إحضار الفاتورة عند الإستبدال أو الإسترجاع </p>

                        <p class="mt-5">ملاحضات</p>
                        <p>- الإسترجاع خلال 24 ساعة من تاريخ الشراء</p>
                        <p>- الإستبدال خلال 5 أيام  من تاريخ الشراء</p>
                        <p>- يجب أن يكون المنتج في حالتة الأصلية</p>
                        <p>- يجب إحضار الفاتورة الأصلية لإتمام عملية الإستبدال و الإسترجاع</p>
                        <p>- المنتجات التي يتم شراؤها خلال فترة التخفيضات يمكن إرجاعها و إستبدالها خلال فترة التخفيضات فقط</p>
                    <?php else: ?>
                        <p class="h4 text-muted text-center"><?php echo e(trans('admin.data_not_found')); ?></p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    </div>

                    <p>>>>>>>>>>>>>0100أغلاق الفاتورة>>>>>>>>>>> </p>

                    <div class="d-flex justify-content-around">
                        <img src="<?php echo e($displayQRCodeBase64); ?>" width="100px" alt="qr_code">
                    </div>

          

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-secondary  float-left mt-3 mr-2" id="print_button" onclick="printDiv()"> <i class="fas fa-print ml-1"></i>طباعة</button>
            </div>
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







<?php /**PATH D:\laragon\www\pharma\resources\views/livewire/customer-invoices-returns/print-return.blade.php ENDPATH**/ ?>