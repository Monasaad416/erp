<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.categories_list')}}</h4>
                    @can('اضافة-تصنيف')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_category')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_category')}}</span>
                    </button>
                    @endcan
                </div>

            </div>

            <div class="card-body">

                @if($categories->count() > 0)

                    <div class="my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_category')}} " wire:model.live="searchItem">
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
                                <th scope="col">{{trans('admin.name')}}</th>
                                <th scope="col">{{trans('admin.parent_category')}}</th>
                                <th scope="col">{{trans('admin.description')}}</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                 @can('تعديل-تصنيف')
                                <th scope="col">{{trans('admin.edit')}}</th>
                                @endcan
                                @can('حذف-تصنيف')
                                <th scope="col">{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr wire:key="category-{{$category->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $category->name }}</span> </td>
                                    <td><span class="text-dark">{{ $category->parent_id ? $category->parent->name : '---' }}</span> </td>

                                    {{-- <td>
                                        <img src="{{asset('storage/uploads/post_categories/'.$category->img)}}" width="100" alt="{{ $category->name }}">
                                    </td> --}}
                                    <td>{{ $category->description }}</td>
                                    <td>

                                        <button type="button" class="btn btn-{{$category->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$category->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('toggleCategory',{id:{{$category->id}}})">
                                            <i class="fa fa-toggle-{{$category->is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    @can('تعديل-تصنيف')
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            {{-- data-target="#edit_modal"  --}}
                                            wire:click="$dispatch('updateCategory',{id:{{$category->id}}})">
                                            <i class="far fa-edit"></i>

                                        </button>
                                    </td>    
                                    @endcan
                                    @can('حذف-تصنيف')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"
                                            data-toggle="modal"
                                            {{-- data-target="#delete_modal"  --}}
                                            title={{trans('admin.delete_category')}}
                                            wire:click="$dispatch('deleteCategory',{id:{{$category->id}}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
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
                    {{$categories->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
