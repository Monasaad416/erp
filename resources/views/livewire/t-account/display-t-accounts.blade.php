<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">دفتر الأستاذ المساعد</h4>
                    {{-- @can('إضافة وحدة') --}}
                    {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="إضافة قيد يومية">
                        <span style="font-weight: bolder; font-size:">إضافة قيد يومية</span>
                    </button> --}}
                    {{-- @endcan --}}
                </div>

            </div>

            {{-- {{ dd($tAccounts) }} --}}
            <div class="card-body">
                    <div class="my-3">
                        <select class="form-control w-25 search_term" wire:model.live="searchItem">
                            <option value="">إختر نوع القيد</option>
                            <option value="دائن">دائن</option>
                            <option value="مدين">مدين</option>

                       </select>
                    </div>
                @if($tAccounts->count() > 0)


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    {{-- <h3>{{  }}</h3> --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> مدين/ دائن </th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">الوصف</th>
                                <th scope="col"> القيد</th>
                                <th scope="col">الحساب</th>
                                {{-- <td>الاستاذ المساعد</td> --}}
                                <th scope="col">  انشاء بواسطة  </th>
                                <th scope="col"> تعديل بواسطة</th>
                                {{-- <th scope="col">{{trans('admin.actions')}}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tAccounts as $tAccount)
                                <tr wire:key="entry-{{$tAccount->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $tAccount->journal_type }}</span> </td>
                                    <td><span class="text-dark">{{ $tAccount->amount}}</span> </td>
                                    <td>{{ $tAccount->description }}</td>
                                    <td><span class="text-dark">#{{ $tAccount->journalEntry->entry_num}}</span> </td>
                                    <td><span class="text-dark">{{ $tAccount->account->name}}</span> </td>
                                    <td>{{ App\Models\User::where('id',$tAccount->created_by)->first()->name ?? null }}</td>
                                    <td>{{ App\Models\User::where('id',$tAccount->updated_by)->first()->name ?? null}}</td>
                                    {{-- <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateCategory',{id:{{$tAccount->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_entry')}}
                                            wire:click="$dispatch('deleteCategory',{id:{{$tAccount->id}}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td> --}}
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$tAccounts->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
