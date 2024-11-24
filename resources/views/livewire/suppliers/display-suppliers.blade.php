<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.suppliers_list')}}</h4>
                    @can('اضافة-مورد')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_supplier')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_supplier')}}</span>
                    </button>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_supplier_name')}}" wire:model.live="searchItem">
                    </div>

                @if($suppliers->count() > 0)
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
                            <th>{{trans('admin.tax_num')}}</th>
                            <th>{{trans('admin.address')}}</th>
                            <th>{{trans('admin.email')}}</th>
                            <th>{{trans('admin.phone')}}</th>
                            <th>{{trans('admin.gln')}}</th>
                            <th>{{trans('admin.balance_state')}}</th>
                            <th>{{trans('admin.start_balance')}}</th>
                            <th>{{trans('admin.current_balance')}}</th>
                            @can('تعديل-مورد')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                            @can('حذف-مورد')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->account_num }}</td>
                                    <td class="text-center" style="width:8%">{{ $supplier->tax_num }}</td>
                                    <td >{{ $supplier->address ? $supplier->address : "---"}}</td>
                                     <td >{{ $supplier->email ? $supplier->email : "---"}}</td>
                                    <td >{{ $supplier->phone ? $supplier->phone : "---"}}</td>
                                    <td>{{ $supplier->gln }}</td>
                                     @php
                                        $state = $supplier->balance_state;
                                        if($state == 1) {
                                            $state = trans('admin.debit');
                                        } elseif ($state == 2) {
                                            $state = trans('admin.credit');
                                        } elseif ($state == 3) {
                                            $state = trans('admin.balanced_at_start') ;
                                        }
                                    @endphp
                                    <td >{{ $state }}</td>
                                    <td >{{ $supplier->start_balance ? $supplier->start_balance : "0"}}</td>
                                    <td >{{ $supplier->current_balance ? $supplier->current_balance : "0"}}</td>
                                     @can('تعديل-مورد')
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateSupplier',{id:{{$supplier->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-مورد')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteSupplier',{id:{{$supplier->id}}})">
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
                    {{$suppliers->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





