<div class="row">
    <div class="col">
        <div class="card">
                @php
                $currentFinancialYear = App\Models\FinancialYear::where('year',Carbon\Carbon::now()->format('Y'))->first();
                $currentFinancialMonth = App\Models\FinancialMonth::where('month_id',Carbon\Carbon::now()->format('m'))->first();
                $startMonth = $currentFinancialMonth->start_date;
                $endMonth =  $currentFinancialMonth->end_date;

                $overtimeHours = App\Models\MonthShifts::where('user_id', $user->id)->where('financial_year_id',$currentFinancialYear->id)->where('financial_month_id',$currentFinancialMonth->id)->sum('overtime_mins');
                $overtimePrices = $overtimeHours * $user->overtime_hour_price;

                $deductions = App\Models\Deduction::where('user_id', $user->id)->where('financial_year_id',$currentFinancialYear->id)->where('financial_month_id',$currentFinancialMonth->id)->sum('amount');
                $rewards = App\Models\Deduction::where('user_id', $user->id)->where('financial_year_id',$currentFinancialYear->id)->where('financial_month_id',$currentFinancialMonth->id)->sum('amount');
                $advancePayments = App\Models\AdvancePayment::where('user_id', $user->id)->where('financial_year_id',$currentFinancialYear->id)->where('return_type','from_salary')->get();
                $advancePaymentInstallments = 0;
                foreach($advancePayments as $payment) {
                    $intallements = $payment->installments->where('financial_month_id',$currentFinancialMonth->id)->sum('amount');
                    $advancePaymentInstallments += $intallements;
                }

                $commissionsInvoices = App\Models\CustomerInvoice::whereBetween('created_at',[$startMonth,$endMonth])->get();
                $commissions = 0 ;
                foreach ( $commissionsInvoices as $invoice) {
                    $items = App\Models\CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get();
                    foreach($items as $item) {
                        $commissions += $item->total_commission_rate;
                    }
                }

                @endphp
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5> حسابات راتب - <span class="text-danger">{{ $user->name }}  </span> عن شهر {{ Carbon\Carbon::now()->format('Y F') }} </h5>
                    <hr>
                    <h6> رقم الحساب المالي  - <span class="text-danger"> {{ $user->account_num }}</span>  </h6>
                </div>

            </div>

            <div class="card-body">
                <style>
                    tr , .table thead th  {
                        text-align: center;
                    }
                </style>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">الاسم</th>
                            <th scope="col"> رقم الحساب</th>
                            <th scope="col"> الفرع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->name }} </td>
                            <td>{{ $user->account_num  }}</td>
                            <td>{{ $user->branch->name  }}</td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>

                            <th scope="col">البند</th>
                            <th scope="col"> المبلغ </th>
                            <th scope="col"> ملاحظات </th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>الراتب الأساسي</td>
                            <td>{{ $user->salary }}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>الإضافي</td>
                            <td> {{ $overtimePrices }} </td>
                            <td> عدد ساعات الإضافي = {{ $overtimeHours }} ساعة</td>
                        </tr>

                        <tr>
                            <td>عمولات المبيعات</td>
                            <td>{{  $commissions  }}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>المكافئات</td>
                            <td> {{ $rewards }}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>بدل السكن</td>
                            <td>{{ $user->housin_allowance ? $user->housin_allowance : 0 }}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>بدل الإنتقال</td>
                            <td>{{ $user->transfer_allowance ? $user->transfer_allowance : 0}}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>خصم التأمين الطبي</td>
                           <td>{{ $user->insurance_deduction ? $user->insurance_deduction : 0 }}</td>
                           <td>---</td>
                        </tr>
                        <tr>
                            <td>خصم السلف </td>
                            <td> {{ $advancePaymentInstallments }}</td>
                            <td>---</td>
                        </tr>

                        <tr>
                            <td>خصومات أخري</td>
                            <td> {{ $deductions }}</td>
                            <td>---</td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered mt-1">
                    <tbody>
                        <tr>
                            <td colspan="2">الإجمالي</td>
                            <td>---</td>
                            <td colspan ="1">{{ $user->salary  + $overtimePrices  +  $commissions + $rewards + $user->housin_allowance + $user->transfer_allowance + $user->insurance_deduction - $user->insurance_deduction - $deductions }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
