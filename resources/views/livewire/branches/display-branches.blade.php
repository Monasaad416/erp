<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.branches_list')}}</h4>
                    {{-- @can('اضافة-فرع')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_branch')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_branch')}}</span>
                    </button>
                    @endcan --}}
                </div>
            </div>

            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_branch_name')}}" wire:model.live="searchItem">
                    </div>


                @if($branches->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>{{trans('admin.branch_num')}}</th>
                            <th>{{trans('admin.name')}}</th>
                            <th>رقم المبني</th>
                            <th>إسم الشارع</th>
                            <th>المنطقة</th>
                            <th>المحافظة</th>
                            <th>الكود البريدي</th>
                            <th>الرقم الفرعي</th>
                            <th>{{trans('admin.phone')}}</th>
                            <th>{{trans('admin.email')}}</th>
                            <th>{{trans('admin.gln')}}</th>
                            <th>{{trans('admin.status')}}</th>
                            @can('تعديل-فرع')
                            <th>{{trans('admin.edit')}}</th>
                            @endcan
                            {{-- @can('حذف-فرع')
                            <th>{{trans('admin.delete')}}</th>
                            @endcan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td class="text-center" >{{$branch->branch_num}}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->building_number }}</td>
                                    <td>{{ $branch->streetName }}</td>
                                    <td>{{ $branch->region }}</td>
                                    <td>{{ $branch->city }}</td>
                                    <td>{{ $branch->postal_code }}</td>
                                    <td>{{ $branch->plot_identification }}</td>
                                    <td>{{ $branch->phone ? $branch->phone : "---"}}</td>
                                    <td>{{ $branch->email ? $branch->email : "---"}}</td>
                                    <td>{{ $branch->gln }}</td>
                                    <td>
                                        <button type="button" class="btn btn-{{$branch->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$branch->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggleBranch',{id:{{$branch->id}}})">
                                            <i class="fa fa-toggle-{{$branch->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>

                                    @can('تعديل-فرع')
                                    <td class="text-center" >

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateBranch',{id:{{$branch->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>

                                    </td>
                                    @endcan
                                    {{-- @can('حذف-فرع')
                                    <td>
                                        @if($branch->id >= 1 && $branch->id < 8)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else


                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                                data-toggle="modal"
                                                wire:click="$dispatch('deleteBranch',{id:{{$branch->id}}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif


                                    </td>
                                    @endcan --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                     <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$branches->links()}}
                </div>

            </div>
        </div>
    </div>

</div>





