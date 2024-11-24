<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة اجماليات الضرائب</h4>
                    @php
                        $currentDate = Carbon\Carbon::now();
                        $cutoffDateFirst = Carbon\Carbon::createFromDate($currentDate->year, 3, 31);
                        $cutoffDateSec = Carbon\Carbon::createFromDate($currentDate->year, 6, 30);
                        $cutoffDateThird = Carbon\Carbon::createFromDate($currentDate->year, 9, 30);
                        $cutoffDateForth = Carbon\Carbon::createFromDate($currentDate->year, 12, 31);
                    @endphp
                    @can('اضافة-ميزان-مراجعة')

                                <button type="button" class="btn bg-gradient-cyan"  {{ $currentDate->greaterThanOrEqualTo($cutoffDateFirst) ? '' : 'disabled' }} data-toggle="modal" data-target="#create_modal_first" title="إضافة ضرائب الربع الاول">
                                    <span style="font-weight: bolder; font-size:">إضافة ضرائب الربع المالي </span>
                                </button>


                    @endcan
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
                                    <th scope="col">#</th>
                                    <th scope="col">إجمالي ضرائب المدخلات</th>
                                    <th scope="col">اجمالي ضرائب المخرجات</th>
                                    <th scope="col">الفرع</th>
                                    <th scope="col">من تاريخ</th>
                                    <th scope="col">إلي تاريخ</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($taxes as $tax)


                                    <tr wire:key="balance_type-{{$tax->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td><span class="text-dark">{{ $tax->in_amount }}</span> </td>
                                        <td><span class="text-dark">{{ $tax->out_amount }}</span> </td>
                                        <td><span class="text-dark">{{$tax->branch->name}}</span> </td>
                                        <td><span class="text-dark">{{$tax->start_date}}</span> </td>
                                        <td><span class="text-dark">{{$tax->end_date}}</span> </td>
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

</div>

