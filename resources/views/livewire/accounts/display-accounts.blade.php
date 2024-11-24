<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.accounts_list')}}</h4>
                    @can('اضافة-حساب-مالي')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_account_type')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_account')}}</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                    <div class="d-flex my-3">
                        <select wire:model.live="branch_id" class="form-control w-25 mx-3">
                            <option value="">إختر الفرع</option>
                            @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch )
                                <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control w-25 mx-3" placeholder="{{trans('admin.search_by_account')}} " wire:model.live="searchItem">

                        <input type="text" class="form-control w-25 mx-3" placeholder="بحث بالمستوي" wire:model.live="level">
                    </div>
                @if($accounts->count() > 0)
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
                                <th scope="col">{{trans('admin.account_num')}}</th>
                                <th scope="col">{{trans('admin.start_balance')}}</th>
                                <th scope="col">{{trans('admin.current_balance')}}</th>
                                <th scope="col">{{trans('admin.branch')}}</th>
                                <th scope="col">القائمة</th>
                                <th scope="col">{{trans('admin.parent_account')}}</th>
                                <th scope="col">المستوي</th>
                                 <th scope="col">نوع  الحساب</th>
                                <th scope="col">طبيعة الحساب</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                <th scope="col">دفتر الاستاذ العام</th>
                                <th scope="col"> كشف حساب</th>
                                @can('تفاصيل-حساب-مالي')
                                    <th scope="col">{{trans('admin.edit')}}</th>
                                    <th scope="col">{{trans('admin.delete')}}</th>
                                    <th scope="col">إسترجاع</th>
                                    <th scope="col">حذف نهائي</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($accounts as $account)
                            @php
                                $bg='';
                                if($account->level == 1 ) {
                                    $bg = '#add0f5';
                                }elseif($account->level == 2 ) {
                                    $bg = '#f2eecd';
                                }elseif($account->level == 3 ) {
                                    $bg = '#eff3f8';
                                }elseif($account->level == 4 ) {
                                    $bg = '#e2fae0';
                                }elseif($account->level == 5 ) {
                                    $bg = '#f1e4ea';
                                }
                            @endphp
                                <tr wire:key="account_type-{{$account->id}}" style="background-color: {{ $bg }}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $account->name }}</span> </td>
                                    <td><span class="text-dark">{{ $account->account_num }}</span> </td>
                                    <td><span class="text-dark">{{ $account->start_balance }}</span> </td>
                                    <td><span class="text-dark">{{ $account->current_balance }}</span> </td>
                                    <td><span class="text-dark">{{ $account->branch->name}}</span> </td>
                                    <td><span class="text-dark">{{ $account->list}}</span> </td>
                                    <td><span class="text-dark">{{ $account->parent->name }}</span> </td>
                                    <td><span class="text-dark">{{ $account->level}}</span> </td>
                                    <td><span class="text-dark">{{ $account->accountType->name}}</span> </td>
                                    <td><span class="text-{{ $account->nature == 'مدين' ? 'green' : ($account->nature == 'دائن' ? 'red' : 'blue') }}">
    {{ $account->nature }}
</span></td>
                                    <td>

                                        <button type="button" class="btn btn-{{$account->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$account->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}" data-toggle="modal"
                                            wire:click="$dispatch('toggleAccount',{id:{{$account->id}}})">
                                            <i class="fa fa-toggle-{{$account->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>

                                    </td>

                                    @can('تفاصيل-حساب-مالي')
                                    <td>

                                        <a href="{{ route('ledgers.show',['account_id'=> $account->id]) }}">
                                            <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.show')}}">
                                                <i class="fas fa-book"></i>
                                            </button>
                                        </a>

                                    </td>

                                    <td>
                                        <a href="{{ route('account_statements.show',['account_id'=> $account->id]) }}">
                                            <button type="button" class="btn btn-outline-success btn-sm mx-1" title="{{trans('admin.show')}}">
                                                <i class="fas fa-dollar-sign"></i>
                                            </button>
                                        </a>
                                    </td>
                                    @endcan


                                    <td>

                                        {{-- @if($account->id >= 1 && $account->id < 596)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else --}}

                                        <button type="button" {{$account->trashed() ? 'disabled' : ''}} class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}" data-toggle="modal"
                                            wire:click="$dispatch('updateAccount',{id:{{$account->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        {{-- @endif --}}
                                    </td>

                                    <td>
                                        @if($account->id >= 1 && $account->id < 596)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else

                                        <button type="button" {{$account->trashed()  ? 'disabled' : ''}} class="btn btn-outline-danger btn-sm mx-1" data-toggle="modal"
                                            title={{trans('admin.delete_account_type')}}
                                            wire:click="$dispatch('deleteAccount',{id:{{$account->id}}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        @endif
                                    </td>
                                   <td>
                                        @if($account->id >= 1 && $account->id < 596)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else
                                        <button type="button" {{$account->trashed()  ? '' : 'disabled' }} class="btn btn-outline-success btn-sm mx-1" title="إستعادة الحساب" data-toggle="modal"
                                            wire:click="dispatch('restoreAccount',{id:{{$account->id}}})">
                                            <i class="fa fa-trash-restore"></i>

                                        </button>
                                        @endif
                                    </td>

                                    <td>
                                        @if($account->id >= 1 && $account->id < 596)
                                            <i class="fas fa-lock text-muted"></i>
                                        @else
                                        <button type="button" {{$account->deleted_at ? '' : 'disabled'}} class="btn btn-outline-dark btn-sm mx-1" title="حذف نهائي" data-toggle="modal"
                                            wire:click="$dispatch('destroyAccount',{id:{{$account->id}}})">
                                            <i class="fa fa-trash-alt"></i>

                                        </button>
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
                    {{$accounts->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
