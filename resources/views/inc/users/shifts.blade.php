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
                            <th>رقم اليوم</th>
                            <th>اليوم </th>
                            <th>نوع الوردية </th>
                            <th>عدد ساعات الوردية</th>
                            <th>بداية الوردية</th>
                            <th>نهاية الوردية</th>
                            <th>توقيت الحضور</th>
                            <th>توقيت الانصراف </th>
                            <th>ساعات اضافية</th>
                            <th>تم الحضور</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1 ;$i <= $currentMonth->no_of_days ;$i ++)

                                @php
                                    $dayNo =Carbon\Carbon::createFromDate($currentFinancialYear->year, $currentMonth->month_id, $i)->toDateString();
                                    $dayName = Carbon\Carbon::createFromDate($currentFinancialYear->year, $currentMonth->month_id, $i)->formatLocalized('%A');
                                @endphp
                                <tr class="bg-{{ $dayName === "Friday" ? 'warning' : '' }}  bg-{{ $i == Carbon\Carbon::now()->format('j') ? 'danger'  : ''}}" >

                                    <td>
                                        {{ $dayNo }}
                                    </td>
                                    <td>
                                        {{ $dayName }}
                                    </td>
                                    <td>
                                        <div class="form-group" wire:ignore.self>
                                            <select wire:model="rows.{{ $branch->id . $user->id .$i }}.shift_type_id" wire:change="fillInfo({{$branch->id }}, {{ $user->id }} {{ $i }})" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'disabled' : '' }} class="form-control @error('shift_type_id') is-invalid @enderror">
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
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i .'.shift_type_id'])

                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" min="0"  step="any" wire:model="rows.{{ $branch->id . $user->id .$i }}.shift_hours" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }}  class="form-control inv-fields @error('shift_hours') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'. $branch->id . $user->id .$i.'.shift_hours'])
                                    </td>
                                    <td>
                                        <input type="time" wire:model="rows.{{ $branch->id . $user->id .$i }}.shift_start" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }} class="form-control inv-fields @error('shift_start') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i .'.shift_start'])
                                    </td>
                                    <td>
                                        <input type="time" wire:model="rows.{{ $branch->id . $user->id .$i }}.shift_end" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }} class="form-control inv-fields @error('shift_end') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i .'.shift_end'])
                                    </td>
                                    <td>
                                        <input type="time" wire:model="rows.{{ $branch->id . $user->id .$i }}.user_attend_at"  {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }} class="form-control inv-fields @error('user_attend_at') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i .'.user_attend_at'])
                                    </td>
                                    <td>
                                        <input type="time" wire:model="rows.{{ $branch->id . $user->id .$i }}.user_leave_at" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }} class="form-control inv-fields @error('user_leave_at') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i.'.user_leave_at'])
                                    </td>
                                    <td>
                                        <input type="number" min="0" wire:model="rows.{{ $branch->id . $user->id .$i }}.overtime_mins" {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'readonly' : '' }} class="form-control inv-fields @error('overtime_mins') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i.'.overtime_mins'])
                                    </td>
                                    <td>
                                        <input type="checkbox" wire:model="rows.{{ $branch->id . $user->id .$i }}.attended" style="width: 20px;height: 20px;"  {{ $currentMonth->month_id < $currentFinancialMonth->month_id ? 'disabled' : '' }} class="inv-fields @error('attended') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'rows.'.$branch->id . $user->id .$i.'.attended'])
                                    </td>

                                </tr>
                            @endfor

                        </tbody>
                    </table>

                </form>

            </div>
        </div>
    @endforeach
@else
        <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
@endif
