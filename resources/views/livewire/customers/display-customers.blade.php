<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.customers_list')}}</h4>
                    @can('اضافة-عميل')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_customer')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_customer')}}</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_customer_name')}}" wire:model.live="searchItem">
                    </div>


                @if($customers->count() > 0)
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
                            <th>{{trans('admin.account_num')}}</th>
                            <th>{{trans('admin.address')}}</th>
                            <th>{{trans('admin.email')}}</th>
                            <th>{{trans('admin.phone')}}</th>
                            <th>{{trans('admin.balance_state')}}</th>
                            <th>{{trans('admin.start_balance')}}</th>
                            <th>{{trans('admin.current_balance')}}</th>
                            <th>نقاط البيع</th> 
                            {{-- <th>إستبدال النقاط</th> --}}
                            @can('تعديل-عميل')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                            @can('حذف-عميل')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->account_num }}</td>
                                    <td >{{ $customer->address ? $customer->address : "---"}}</td>
                                     <td >{{ $customer->email ? $customer->email : "---"}}</td>
                                    <td >{{ $customer->phone ? $customer->phone : "---"}}</td>
                                     @php
                                        $state = $customer->balance_state;
                                        if($state == 1) {
                                            $state = trans('admin.debit');
                                        } elseif ($state == 2) {
                                            $state = trans('admin.credit');
                                        } elseif ($state == 3) {
                                            $state = trans('admin.balanced_at_start') ;
                                        }
                                    @endphp
                                    <td >{{ $state }}</td>
                                    <td >{{ $customer->start_balance ? $customer->start_balance : "0"}}</td>
                                    <td >{{ $customer->current_balance ? $customer->current_balance : "0"}}</td>
                                    <td >{{ $customer->pos ? $customer->pos : "0"}}</td>
                                    {{-- <td class="text-center">
                         
                                        <button type="button" class="btn btn-outline-success btn-sm mx-1" title="إستبدال النقاط"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateCustomer',{id:{{$customer->id}}})">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </td>  --}}
                                    @can('تعديل-عميل')
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateCustomer',{id:{{$customer->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-عميل')
                                    <td>
                          
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteCustomer',{id:{{$customer->id}}})">
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
                    {{$customers->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





