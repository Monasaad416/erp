<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.units_list')}}</h4>
                    @can('اضافة-وحدة')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($units->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_unit')}}  " wire:model.live="searchItem">
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
                            <th>{{trans('admin.unit')}}</th>
                            <th>{{trans('admin.operations')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $unit->name }}</td>
                                     @can('تعديل-وحدة')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateUnit',{id:{{$unit->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>
                                    @endcan
                                    @can('حذف-وحدة')
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="{{trans('admin.delete')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}

                                            wire:click="$dispatch('deleteUnit',{id:{{$unit->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$units->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
