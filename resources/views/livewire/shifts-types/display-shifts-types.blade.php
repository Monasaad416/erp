<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.shifts_types_list')}}</h4>
                    {{-- @can('إضافة وحدة') --}}
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_shift')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_shift')}}</span>
                    </button>
                    {{-- @endcan --}}
                </div>

            </div>

            <div class="card-body">

                @if($shiftsTypes->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_shift')}} " wire:model.live="searchItem">
                    </div>
                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('admin.shift_type')}}</th>
                                <th scope="col">{{trans('admin.shift_start')}}</th>
                                <th scope="col">{{trans('admin.shift_end')}}</th>
                                <th scope="col">{{trans('admin.total_hours')}}</th>
                                <th scope="col">{{trans('admin.created_by')}}</th>
                                <th scope="col">{{trans('admin.updated_by')}}</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                <th scope="col">{{trans('admin.edit')}}</th>
                                {{-- <th scope="col">{{trans('admin.delete')}}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shiftsTypes as $shift)

                                <tr wire:key="shift-{{$shift->id}}">
                                    <td>{{$loop->iteration}}</td>
            
                                    <td><span class="text-dark">{{$shift->label()}}</span> </td>
                                    <td><span class="text-dark">{{ $shift->start }}</span> </td>
                                    <td><span class="text-dark">{{ $shift->end }}</span> </td>
                                    <td><span class="text-dark">{{ $shift->total_hours }}</span> </td>
                                    <td>{{ $shift->createdBy->name}}</td>
                                    <td>{{ $shift->updated_by ?  $shift->updatedBy->name  :'---'}}</td>
                                    <td>
                                        <button type="button" class="btn btn-{{$shift->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$shift->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggleShift',{id:{{$shift->id}}})">
                                            <i class="fa fa-toggle-{{$shift->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateShift',{id:{{$shift->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    {{-- <td>   
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                        
                                            title={{trans('admin.delete_shift')}}
                                            wire:click="$dispatch('deleteShift',{id:{{$shift->id}}})">
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
                    {{$shiftsTypes->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
