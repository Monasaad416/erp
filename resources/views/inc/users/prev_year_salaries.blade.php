@php
    if(Auth::user()->roles_name == 'سوبر-ادمن'){
        $users = App\Models\User::where('branch_id',$branch->id)->get();
    }else {
        $users = App\Models\User::where('branch_id',$branch->id)->get();
    }

@endphp
<style>
    .custom_button {
        background-color: rgb(198, 193, 193) !important;
    }
</style>


@if($users->count() > 0)
    @foreach ($users as $user)
        @php
            $href = str_replace(' ', '_', $user->name);
        @endphp
        <p>
            <a class="btn btn-block custom_button collapsed" data-toggle="collapse" href="#{{ $href }}" role="button" aria-expanded="false" aria-controls="{{ $href }}">
                {{ $user->name }}
            </a>
        </p>
        @php
            $currentFinancialYear = App\Models\FinancialYear::where('year',Carbon\Carbon::now()->format('Y'))->first();
            $salaries = App\Models\Salary::where('user_id', $user->id)->whereNot('financial_year_id',$currentFinancialYear->id)->get();
            //dd($salaries);
        @endphp

        <div class="collapse" id="{{ $href }}">
            <div class="card card-body">
                <style>
                    .table thead tr th ,tr{
                        text-align:center;
                    }
                </style>

                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>الاساسي</th>
                            <th>الاضافي </th>
                            <th>بدل السكن  </th>
                            <th>بدل الانتقالات</th>
                            <th>مكافئات</th>
                            <th>عمولة مبيعات</th>
                            <th>خصومات تأخير</th>
                            <th>خصم التأمين الطبي</th>
                            <th>خصومات السلف </th>
                            <th>خصومات اخري</th>
                            <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($salaries)
                            @foreach ($salaries as $salary )
                                    <tr>
                                        <td>
                                            {{$salary ?  $salary->salary : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ?  $salary->total_overtime : 0}}
                                        </td>
                                        <td>
                                        {{ $salary ? $salary->housing_allowance : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->transfer_allowance : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->rewards : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->total_commission_rate : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->total_delay : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->medical_insurance_deduction : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->advance_payment_deduction : 0}}
                                        </td>
                                        <td>
                                            {{ $salary ? $salary->deductions : 0}}
                                        </td>
                                        <td>
                                            @if($salary)
                                            {{ $salary->salary + $salary->total_overtime + $salary->housing_allowance + $salary->transfer_allowance
                                            +$salary->rewards + $salary->total_commission_rate -$salary->total_delay - $salary->medical_insurance_deduction - $salary->advance_payment_deduction
                                            -$salary->deductions}}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                            <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                            @endif


                        </tbody>
                    </table>

                </form>

            </div>
        </div>
    @endforeach
@else
        <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
@endif
