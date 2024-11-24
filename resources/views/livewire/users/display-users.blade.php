<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">{{ trans('admin.users_list') }} </h4>
                    @can('اضافة-موظف')
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{ trans('admin.create_user') }}">
                            <span style="font-weight: bolder; font-size:">{{ trans('admin.create_user') }}</span>
                        </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($users->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25" placeholder="{{ trans('admin.search_by_name_email') }}" wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>رقم حساب الراتب</th>
                                <th>رقم حساب السلف</th>
                                <th> {{ trans('admin.email') }}</th>
                                <th>{{ trans('admin.role') }}</th>
                                <th>{{ trans('admin.address') }}</th>
                                <th>{{ trans('admin.branch') }}</th>
                                <th>الرواتب</th>
                                 <th>الورديات</th>
                                <th>{{ trans('admin.show') }}</th>

                                @can('تعديل-موظف')
                                    <th>{{ trans('admin.edit') }}</th>
                                @endcan
                                @can('حذف-موظف')
                                <th>{{ trans('admin.delete') }}</th>
                                @endcan 
                            </tr>
                        </thead>
                        <tbody>
                     @foreach ($users as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->account_num }}</td>
                            <td>{{ $user->advance_payment_account_num }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles_name }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->branch->name }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-info btn-sm" title="إضافة الراتب">
                                    <a href="{{ route('users.salaries.create',['user_id' => $user->id]) }}" >
                                        <span style="font-weight: bolder; font-size:"> <i class="far fa-money-bill-alt"></i></span>
                                    </a>
                                </button>   
                            </td>
                            <td>
                                 <button type="button" class="btn btn-outline-secondary btn-sm" title="إضافة الورديات">
                                    <a href="{{ route('users.shifts.create',['user_id' => $user->id]) }}" >
                                        <span style="font-weight: bolder; font-size:"><i class="fas fa-sync-alt"></i></span>  
                                    </a>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm" title="بيانات الموظف"
                                    data-toggle="modal"
                                    wire:click="$dispatch('showUser',{id:{{$user->id}}})">
                                    <i class="far fa-eye"></i>
                                </button>
                            </td>
                            @can('تعديل-موظف')
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{ trans('admin.edit') }}"
                                        data-toggle="modal"
                                        wire:click="$dispatch('editUser',{id:{{$user->id}}})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>
                            @endcan
                            @can('حذف-موظف')
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="{{ trans('admin.delete') }}"
                                    data-toggle="modal"
                                    wire:click="$dispatch('deleteUser',{id:{{$user->id}}})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                     @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">لا يوجد موظفين للعرض</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$users->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
