<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.shifts_types_list')}}</h4>
                    @can('اضافة-وردية-خزينة')
                    <button type="button" {{ $currentTreasuryShift && Auth::user()->roles_name != 'سوبر-ادمن' ? 'disabled' : '' }} class="btn bg-gradient-cyan"  data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_user_shift')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_user_shift')}}
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($treasuryShifts->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_shift')}} " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th colspan="7" style="background-color: rgb(244, 232, 230)">{{trans('admin.delivered_shift_info')}}</th>
                                <th colspan="2" style="background-color: rgb(183, 211, 233)" >{{trans('admin.delivered_to_shift_info')}}</th>
                                <th ></th>
                                <th ></th>
                                <th ></th>
                                <th ></th>

                            </tr>
                            <tr>
                                <th scope="col" >#</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.delivered_user')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.shift')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.shift_start_date')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.shift_end_date')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.start_shift_cash_balance')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.end_shift_cash_balance')}}</th>
                                <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.end_shift_bank_balance')}}</th>
                                {{-- <th scope="col" style="background-color: rgb(244, 232, 230)">{{trans('admin.amount_delivered')}}</th> --}}
                                {{-- <th scope="col">{{trans('admin.amount_status')}}</th>
                                <th scope="col">{{trans('admin.amount_status_value')}}</th> --}}
                                <th scope="col" style="background-color: rgb(183, 211, 233)">{{trans('admin.delivered_to_user')}}</th>
                                <th scope="col" style="background-color: rgb(183, 211, 233)">{{trans('admin.shift')}}</th>
                                <th scope="col" rowspan="2">{{trans('admin.branch')}}</th>
                                <th scope="col" rowspan="2">{{trans('admin.delived_to_approval')}}</th>

                                <th scope="col" rowspan="2">{{trans('admin.edit')}}</th>
                                <th scope="col" rowspan="2">{{trans('admin.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>

                            </style>


                            @foreach ($treasuryShifts as $shift)

                                <tr wire:key="shift-{{$shift->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ $shift->delivered->name}}</td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ $shift->deliveredShiftType->label() }} </td>
                                    <td style="background-color: rgb(244, 232, 230)"> {{ Carbon\Carbon::parse($shift->start_shift_date_time)->format('d-m-Y H:i') }}</td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ Carbon\Carbon::parse($shift->end_shift_date_time)->format('d-m-Y H:i') }}</td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ $shift->start_shift_cash_balance }} </td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ $shift->end_shift_cash_balance }} </td>
                                    <td style="background-color: rgb(244, 232, 230)">{{ $shift->end_shift_bank_balance }} </td>
                                    {{-- <td style="background-color: rgb(244, 232, 230)">{{ $shift->amount_delivered }}</td> --}}
                                    {{-- @if($shift->amount_status == 1)
                                        <td style="background-color: rgb(244, 232, 230)">{{ trans('admin.balanced')}}</td>
                                    @elseif($shift->amount_status == 2)
                                        <td style="background-color: rgb(237, 133, 114)">{{ trans('admin.shortage') }}</td>
                                    @elseif($shift->amount_status == 3)
                                        <td  style="background-color: #93e4a6">{{ trans('admin.surplus') }}</td>
                                    @endif

                                    @if($shift->amount_status == 1)
                                        <td style="background-color: rgb(244, 232, 230)">{{ $shift->amount_status_value}}</td>
                                    @elseif($shift->amount_status == 2)
                                        <td style="background-color: rgb(237, 133, 114)">{{ $shift->amount_status_value }}</td>
                                    @elseif($shift->amount_status == 3)
                                        <td  style="background-color: #93e4a6">{{ $shift->amount_status_value }}</td>
                                    @endif --}}
                                    <td style="background-color: rgb(183, 211, 233)">{{ $shift->deliveredTo->name}}</td>
                                    <td style="background-color: rgb(183, 211, 233)">{{ $shift->deliveredToShiftType->label()}}</td>
                                    <td>{{ $shift->branch->name}}</td>
                                     @can('تعديل-وردية-خزينة')
                                     @endcan
                                    <td>
                                        <button type="button" class="btn btn-{{$shift->is_approved  == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$shift->is_approved  == 1 ? trans('admin.is_approved') : trans('admin.not_approved_yet') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('recieveShift',{id:{{$shift->id}}})">
                                            <i class="fa fa-toggle-{{$shift->is_approved == 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                     @can('تعديل-وردية-خزينة')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateTreasuryShift',{id:{{$shift->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    @endcan
                                      @can('حذف-وردية-خزينة')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_shift')}}
                                            wire:click="$dispatch('deleteTreasuryShift',{id:{{$shift->id}}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>

                                      @endcan
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$treasuryShifts->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
