<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.accounts_types_list')}}</h4>
                    {{-- @can('إضافة وحدة') --}}
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_account_type')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_account_type')}}</span>
                    </button>
                    {{-- @endcan --}}
                </div>

            </div>

            <div class="card-body">

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_account_type')}} " wire:model.live="searchItem">
                    </div>
                @if($accounts_types->count() > 0)

                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('admin.name')}}</th>
                                <th scope="col">{{trans('admin.parent_account_type')}}</th>
                                <th scope="col">{{trans('admin.description')}}</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                <th scope="col">{{trans('admin.separate_screen')}}</th>
                                <th scope="col">{{trans('admin.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($accounts_types as $account_type)
                                <tr wire:key="account_type-{{$account_type->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $account_type->name }}</td>
                                    <td>{{ $account_type->parent_id ? $account_type->parent_id : '---' }}</td>

                                    {{-- <td>
                                        <img src="{{asset('storage/uploads/post_accounts_types/'.$account_type->img)}}" width="100" alt="{{ $account_type->name }}">
                                    </td> --}}
                                    <td>{{ $account_type->description }}</td>
                                    <td>

                                        <button type="button" class="btn btn-{{$account_type->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$account_type->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggleAccountType',{id:{{$account_type->id}}})">
                                            <i class="fa fa-toggle-{{$account_type->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <td class="text-{{ $account_type->separate_screen == 1 ? 'success' : 'danger'  }}">
                                        {{ $account_type->separate_screen == 1 ? trans('admin.yes') : trans('admin.no')   }}

                                        @if($account_type->id == 2)
                                            <hr>
                                            <span>{{trans('admin.internal_sec_screen')}}<span>
        
                                        @elseif($account_type->id ==6)
                                            <hr>
                                            <span>{{trans('admin.client_screen')}}<span>
                                        @elseif($account_type->id == 7)
                                            <hr>
                                            <span>{{trans('admin.supplier_screen')}}<span>
                                        @elseif($account_type->id == 8)
                                            <hr>
                                            <span>{{trans('admin.employee_screen')}}<span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $typesEn=['Capital','Internal Section','Expenses','General','Bank','Client','Supplier','Employee'];
                                            $typesAr=['رأس مال','قسم داخلي','المصروفات','عام','بنكي ','عميل','مورد','موظف'];
                                        @endphp

                                        @if ((!in_array($account_type->name,$typesEn) && App::getLocale() == "en" )  || (!in_array($account_type->name,$typesAr) && App::getLocale() == "ar" ) )
                                            <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                                data-toggle="modal"
                                                {{-- data-target="#edit_modal"  --}}
                                                wire:click="$dispatch('updateAccountType',{id:{{$account_type->id}}})">
                                                <i class="far fa-edit"></i>

                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                                data-toggle="modal"
                                                {{-- data-target="#delete_modal"  --}}
                                                title={{trans('admin.delete_account_type')}}
                                                wire:click="$dispatch('deleteAccountType',{id:{{$account_type->id}}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        @else
                                            <i class="fas fa-lock text-muted"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$accounts_types->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
