<div class="row">
    <div class="col">
        <div class="card">
                @php

                    

                    // $startBalance = Account::where('account_num',$account_num)->')
                @endphp
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5>كشف حساب - <span class="text-danger">{{ $account_name }}  </span>  </h5>
                    <hr>
                    <h6> رقم الحساب المالي  - <span class="text-danger"> {{ $account_num }}</span>  </h6>
                </div>

            </div>

            <div class="card-body">
                      <div class="d-flex justify-content-around">
                        <div class="form-group w-50 mx-1">
                            <label for="from_date">من تاريخ:</label>
                            <input type="date" id="from_date" class="form-control ml-2" wire:model.live="from_date">
                        </div>
         
                    

                        <div class="form-group w-50 mx-1">
                            <label for="from_date">إلي تاريخ:</label>
                            <input type="date" id="to_date" class="form-control ml-2"  wire:model.live="to_date">
                        </div>
                </div>
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
                            <td>{{ $account_name }} </td>
                            <td>{{ $account_num  }}</td>
                            <td>{{ $account->branch->name ?? null }}</td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered mt-3">
                    <thead>
   
                                <tr>
                                    <th scope="col">#</th>
                        
                                    <th scope="col">بيان الحركة</th>

                                    <th scope="col" style="background-color: rgb(152, 232, 152)">مدين</th>
                                    <th scope="col" style="background-color: rgb(238, 144, 144)">دائن</th>

                                    <th scope="col"> الرصيد</th>
                                    <th scope="col"> التاريخ</th>
               
                                </tr>
                            </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $entry->description }} </td>

                                <td style="background-color: rgb(152, 232, 152)">{{ $entry->debit_account_num == $account_num ? $entry->debit_amount : 0  }}</td>
                                <td style="background-color: rgb(238, 144, 144)">{{  $entry->credit_account_num == $account_num ? $entry->credit_amount :0 }}</td>

                                <td style="background-color: {{  $entry->debit_account_num == $account_num  ? 'rgb(152, 232, 152)' : 'rgb(238, 144, 144)' }}">
                                    
                                    {{ $entry->debit_amount }} 
                                </td>


       
                                <td>{{  $entry->date}}</td>
              

                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <table class="table table-bordered mt-1">
                    <tbody>
                        <tr>
                            <td style="background-color: rgb(238, 144, 144)">إجمالي الدائن </td>
                            <td style="background-color: rgb(238, 144, 144)">{{ $credit }}</td>
                        </tr>
                        <tr>
                            <td style="background-color:rgb(152, 232, 152)">إجمالي المدين </td>
                            <td style="background-color:rgb(152, 232, 152)">{{ $debit }}</td>
                        </tr>
                        <tr>
                            <td style="background-color:{{ $debit - $credit > 0 ? 'rgb(152, 232, 152)' : 'rgb(238, 144, 144)' }}">الرصيد </td>
                            <td style="background-color:{{ $debit - $credit > 0 ? 'rgb(152, 232, 152)' : 'rgb(238, 144, 144)' }}">{{ $debit - $credit }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
