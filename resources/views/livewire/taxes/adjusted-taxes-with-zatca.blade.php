<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة تسويات الضرائب</h4>
                    @php
                        $currentDate = Carbon\Carbon::now();
                        $cutoffDateFirst = Carbon\Carbon::createFromDate($currentDate->year, 3, 31);
                        $cutoffDateSec = Carbon\Carbon::createFromDate($currentDate->year, 6, 30);
                        $cutoffDateThird = Carbon\Carbon::createFromDate($currentDate->year, 9, 30);
                        $cutoffDateForth = Carbon\Carbon::createFromDate($currentDate->year, 12, 31);
                    @endphp
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3 search_term">
                            <option value="">إختر الفرع</option>
                            @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch )
                                <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                        <select class="form-control w-25 search_term mx-3"  wire:model.live="searchItem">
                            <option>إختر السنة المالية </option>
                            @foreach(App\Models\FinancialYear::all() as $year)
                                {{$year->year}}
                            @endforeach
                        </select>
                    </div>


                @if($taxes->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>إجمالي مبلغ التسوية</th>
                                    <th>الفرع</th>
                                    <th>من تاريخ</th>
                                    <th>إلي تاريخ</th>
                                    <th>حالة التسوية</th>
                                    <th>تسوية الضريبة</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($taxes as $tax)
                                    <tr wire:key="balance_type-{{$tax->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td><span class="text-dark">{{ $tax->amount }}</span> </td>
                                        <td><span class="text-dark">{{$tax->branch->name}}</span> </td>
                                        <td><span class="text-dark">{{$tax->start_date}}</span> </td>
                                        <td><span class="text-dark">{{$tax->end_date}}</span> </td>
                                        <td><span class="text-{{ $tax->is_adjusted == true ? 'success' : 'danger'}}"> {{ $tax->is_adjusted == true ? 'تمت التسوية' : 'لم تتم التسوية'}} </span> </td>
                                        <td>
                                            <button type="button" class="btn btn-{{$tax->is_adjusted == 1 ? 'success' : 'secondary'}} btn-sm mx-1" {{$tax->is_adjusted == 1 ? 'disabled' : ''}} title="{{$tax->is_adjusted == 1 ? 'لم تتم التسوية' : 'تمت التسوية' }}"
                                                data-toggle="modal"
                                                {{-- data-target="#edit_modal"  --}}
                                                wire:click="$dispatch('approveTaxAdjustmentWithZatca',{id:{{$tax->id}}})">
                                                <i class="fa fa-toggle-{{$tax->is_adjusted== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                            </button>
                                            <div class="modal" id="change_state_modal" wire:ignore.self>
                                                <form wire:submit.prevent="toggle">
                                                    @csrf
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">{{ trans('admin.toggle_state') }}</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            {{-- {{ dd($tax) }}  --}}
                                                            <div class="modal-body">
                                                                <p>{{ trans('admin.sure_change_state') }} <span class="text-danger">{{ $tax }}</span></p>
                                                                <p class="text-{{ $tax->is_adjusted == 1 ? 'success' : 'danger'}} "> {{ trans('admin.current_state')}} {{  $tax->is_adjusted == 1 ? trans('admin.active') : trans('admin.inactive') }}</p>
                                                                @csrf
                                                            {{-- <input type="hidden" value="{{$tax->id}}" wire:model="id"> --}}
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                                                    <button type="submit" name="submit" class="btn btn-info">{{ trans('admin.edit') }}</button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @php


                                    @endphp

                                @endforeach
                                {{-- {{dd($debitBalance + $creditBalance)}} --}}
                            </tbody>
                        </table>
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$taxes->links()}}
                </div>

            </div>
        </div>
    </div>
    <
</div>

