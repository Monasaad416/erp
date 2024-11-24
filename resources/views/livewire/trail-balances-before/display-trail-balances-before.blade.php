<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة موازين المراجعة</h4>
                    @can('اضافة-ميزان-مراجعة')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة ميزان مراجعة">
                        <span style="font-weight: bolder; font-size:">إضافة ميزان مراجعة</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <div class="form-group w-25 mx-1">
                            <label for="from_date">رقم الحساب :</label>
                            <input type="text" class="form-control " placeholder="بحث بالحساب" wire:model.live="searchItem">
                        </div>
                        <div class="form-group w-25 mx-1">
                            <label for="from_date">الفرع :</label>
                            <select wire:model.live="branch_id" class="form-control">
                                <option value="">إختر الفرع</option>
                                @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch )
                                    <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>

                        </div>


                            <div class="form-group w-25 mx-1">
                                <label for="from_date">من تاريخ:</label>
                                <input type="date" id="from_date" class="form-control ml-2" wire:model.live="from_date">
                            </div>



                            <div class="form-group w-25 mx-1">
                                <label for="from_date">إلي تاريخ:</label>
                                <input type="date" id="to_date" class="form-control ml-2"  wire:model.live="to_date">
                            </div>
                        </div>


                @if($balances->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                        @php
                            $debitBalance = 0;
                            $creditBalance = 0;
                            $totalBalance = 0;

                        @endphp


                </table>
                <table class="table table-bordered mt-3">
                    <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                    <th colspan="2">اول الفترة</th>

                                    <th colspan="2">خلال الفترة</th>

                                    <th colspan="2">الرصيد الختامي</th>

                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>


                                </tr>
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">الحساب</th>
                                    <th scope="col">رقم الحساب</th>
                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col" style="background-color: rgb(189, 236, 189)">مدين</th>
                                    <th scope="col" style="background-color: rgb(235, 192, 192)">دائن</th>

                                    <th scope="col"> الفرع</th>
                                    <th scope="col"> من تاريخ</th>
                                    <th scope="col"> إلي تاريخ</th>
                                </tr>
                            </thead>
                    <tbody>
                           @php
                                $debitBalance = 0;
                                $creditBalance = 0;
                            @endphp
                            @foreach ($balances as $balance)
                            @php

                                $debitBalance += $balance->debit;
                                $creditBalance += $balance->credit;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $balance->name }} </td>
                                <td>{{ $balance->account_num }} </td>

                                <td style="background-color: rgb(189, 236, 189)">0</td>
                                <td style="background-color: rgb(235, 192, 192)">0</td>

                                <td style="background-color: rgb(189, 236, 189)">{{ $balance->debit  }}</td>
                                <td style="background-color: rgb(235, 192, 192)">{{  $balance->credit }}</td>



                                <td style="background-color: {{ $balance->debit > $balance->credit ? 'rgb(189, 236, 189)' :'rgb(235, 192, 192)' }}">{{  $balance->debit > $balance->credit ?  ($balance->debit - $balance->credit) : 0 }} </td>
                                <td style="background-color: {{ $balance->debit > $balance->credit ? 'rgb(189, 236, 189)' :'rgb(235, 192, 192)' }}">{{  $balance->credit > $balance->debit ?  ($balance->credit - $balance->debit) : 0 }} </td>


                                <td>{{  $balance->branch->name}}</td>
                                <td>{{  $balance->start_date}}</td>
                                <td>{{  $balance->end_date}}</td>


                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">الإجمالي</td>
                            <td></td>
                            <td style="background-color: rgb(189, 236, 189)">0</td>
                            <td style="background-color: rgb(235, 192, 192)">0</td>

                            <td style="background-color: rgb(189, 236, 189)">{{ $debitBalance }}</td>
                            <td style="background-color: rgb(235, 192, 192)">{{  $creditBalance }}</td>

                                    <td style="background-color: rgb(189, 236, 189)">{{ $debitBalance }}</td>
                            <td style="background-color: rgb(235, 192, 192)">{{  $creditBalance }}</td>
                        </tr>

                    </tbody>
                </table>
                {{-- <table class="table table-bordered mt-1">
                    <tbody>
                        <tr>
                            <td style="background-color:#f5f6f9">إجمالي الدائن </td>
                            <td>{{ $credit }}</td>
                        </tr>
                        <tr>
                            <td style="background-color:#f5f6f9">إجمالي المدين </td>
                            <td>{{ $debit }}</td>
                        </tr>
                        <tr>
                            <td style="background-color:#f5f6f9">الرصيد </td>
                            <td>{{ $debit - $credit }}</td>
                        </tr>
                    </tbody>
                </table> --}}
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif

{{--

                <div class="d-flex justify-content-center my-4">
                    {{$balances->links()}}
                </div> --}}

            </div>

        </div>
    </div>

</div>





