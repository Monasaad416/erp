<div>

<form wire:submit.prevent="update">
    @php
        $currentYear = Carbon\Carbon::now()->format('Y');
        $currentMonthNo = Carbon\Carbon::now()->format('m');
        $currentFinancialYear = App\Models\FinancialYear::where('year',$currentYear)->first();
        $currentFinancialMonth = App\Models\FinancialMonth::where('month_id',$currentMonthNo)->first();
        //dd($currentFinancialYear->months);
        $currentMonth = Carbon\Carbon::now()->format('m');
        $startDate = Carbon\Carbon::now()->startOfMonth();
        $endDate = Carbon\Carbon::now()->endOfMonth();

        $period = new Carbon\CarbonPeriod($startDate, '1 day', $endDate);
        $numberOfDays = count($period);
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم اليوم</th>
                <th>اليوم </th>
                <th>نوع الوردية </th>
                <th>عدد ساعات الوردية</th>
                <th>بداية الوردية</th>
                <th>نهاية الوردية</th>
                <th>توقيت الحضور</th>
                <th>توقيت الانصراف </th>
                {{-- <th>ساعات اضافية</th> --}}
                <th>تم الحضور</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $index => $row)

                @php
                    $dayNo =Carbon\Carbon::createFromDate($currentFinancialYear->year, $currentFinancialMonth->month_id, $index)->toDateString();
                    $dayName = Carbon\Carbon::createFromDate($currentFinancialYear->year, $currentFinancialMonth->month_id, $index)->formatLocalized('%A');
                @endphp
                <tr class="bg-{{ $dayName === "Friday" ? 'warning' : '' }}  bg-{{ $index == Carbon\Carbon::now()->format('j') ? 'danger'  : ''}}" >

                    <td>
                        <input type="date" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} wire:model="rows.{{ $index }}.date" class="form-control @error('date') is-invalid @enderror">
                    </td>
                    <td>
                        {{ $dayName }}
                    </td>
                    <td>
                        <div class="form-group" wire:ignore.self>
                            <select {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} wire:model="rows.{{ $index }}.shift_type_id"  class="form-control @error('shift_type_id') is-invalid @enderror">
                                <option>إختر نوع الوردية</option>
                                @foreach(App\Models\ShiftType::all() as $shift)
                                    @php
                                    $type="";
                                        if($shift->type == 1){
                                            $type = 'صباحية 8 ساعات';
                                        }elseif($shift->type == 2) {
                                            $type =   'مسائية 8 ساعات';
                                        }elseif($shift->type == 3){
                                            $type =   'ليلية 8 ساعات';
                                        }elseif($shift->type == 4) {
                                            $type = 'صباحية 12 ساعة' ;
                                        }elseif($shift->type == 5){
                                            $type = 'ليلية 12 ساعة';
                                        }
                                    @endphp
                                    <option value="{{$shift->id}}">{{$type}}</option>
                                @endforeach
                            </select>
                            @include('inc.livewire_errors', ['property' => 'rows.'.$index .'.shift_type_id'])

                        </div>
                    </td>
                    <td>
                        <input type="number" min="0" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} step="any" wire:model="rows.{{ $index }}.shift_hours"  class="form-control inv-fields @error('shift_hours') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'. $index.'.shift_hours'])
                    </td>
                    <td>
                        <input type="time" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}}  wire:model="rows.{{ $index }}.shift_start" class="form-control inv-fields @error('shift_start') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index .'.shift_start'])
                    </td>
                    <td>
                        <input type="time" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} wire:model="rows.{{ $index }}.shift_end" class="form-control inv-fields @error('shift_end') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index .'.shift_end'])
                    </td>
                    <td>
                        <input type="time" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} wire:model="rows.{{ $index }}.user_attend_at"  class="form-control inv-fields @error('user_attend_at') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index .'.user_attend_at'])
                    </td>
                    <td>
                        <input type="time" {{ $index >= Carbon\Carbon::now()->format('j') ? 'readonly' : ''}} wire:model="rows.{{ $index }}.user_leave_at" class="form-control inv-fields @error('user_leave_at') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.user_leave_at'])
                    </td>
                    {{-- <td>
                        <input type="number" min="0" wire:model="rows.{{ $index }}.overtime_mins" class="form-control inv-fields @error('overtime_mins') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.overtime_mins'])
                    </td> --}}
                    <td>
                        <input type="checkbox" {{ $index >= Carbon\Carbon::now()->format('j') ? 'disabled' : ''}} wire:model="rows.{{ $index }}.attended" {{ $row['attended'] == 1 ? 'checked' : '' }} style="width: 20px;height: 20px;"  class="inv-fields @error('attended') is-invalid @enderror">
                        @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.attended'])
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>



            <div class="d-flex justify-content-center">
                <button type="submit"  class="btn btn-info mx-2">{{trans('admin.edit')}}</button>
            </div>


</div>



