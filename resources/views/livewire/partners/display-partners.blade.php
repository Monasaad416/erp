<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة الشركاء</h4>
                    @can('اضافة-شريك')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_partner')}}">
                        <span style="font-weight: bolder; font-size:">إضافة شريك</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="بحث بإسم الشريك" wire:model.live="searchItem">
                    </div>


                @if($partners->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>{{trans('admin.name')}}</th>
                            <th>{{trans('admin.address')}}</th>
                            <th>{{trans('admin.email')}}</th>
                            <th>{{trans('admin.phone')}}</th>
                            {{-- <th>{{trans('admin.balance_state')}}</th>
                            <th>{{trans('admin.start_balance')}}</th>
                            <th>{{trans('admin.current_balance')}}</th> --}}
                            @can('تعديل-شريك')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                            @can('حذف-شريك')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $partner)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $partner->name }}</td>
                                    {{-- <td>{{ $partner->account_num }}</td> --}}
                                    <td >{{ $partner->address ? $partner->address : "---"}}</td>
                                     <td >{{ $partner->email ? $partner->email : "---"}}</td>
                                    <td >{{ $partner->phone ? $partner->phone : "---"}}</td>
                                     {{-- @php
                                        $state = $partner->balance_state;
                                        if($state == 1) {
                                            $state = trans('admin.debit');
                                        } elseif ($state == 2) {
                                            $state = trans('admin.credit');
                                        } elseif ($state == 3) {
                                            $state = trans('admin.balanced_at_start') ;
                                        }
                                    @endphp --}}
                                    {{-- <td >{{ $state }}</td>
                                    <td >{{ $partner->start_balance ? $partner->start_balance : "0"}}</td>
                                    <td >{{ $partner->current_balance ? $partner->current_balance : "0"}}</td> --}}

                                    @can('تعديل-شريك')
                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updatePartner',{id:{{$partner->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-شريك')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deletePartner',{id:{{$partner->id}}})">
                                            <i class="fas fa-trash"></i>
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
                    {{$partners->links()}}
                </div>

            </div>
        </div>
    </div>
</div>





