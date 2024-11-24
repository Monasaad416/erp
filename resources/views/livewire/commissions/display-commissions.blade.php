<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.products_list')}}</h4>
                    @can('اضافة-منتج')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_product')}}">
                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_product')}}</span>
                    </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_product_name')}}" wire:model.live="searchItem">
                        {{-- <select class="form-control w-25 mx-5" wire:model.live="filter">
                            <option value="">كل المنتجات</option>
                            <option value="inside_invoices">المجرودة</option>
                            <option value="outside_invoices">الغيرمجرودة</option>
                        </select> --}}
                    </div>

                @if($products->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>نسبة العمولة</th>
                                @can( 'تعديل-منتج')
                                <th>{{trans('admin.edit')}}</th>
                                @endcan
                                    @can( 'حذف-منتج')
                                <th>{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)

                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->commission_rate }}</td>

                                    @can( 'تعديل-منتج')
                                    <td>

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateProduct',{product_id:{{$product->product_id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>

                                    </td>
                                    @endcan




                                    @can('حذف-منتج')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="{{trans('admin.delete')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteProduct',{id:{{$product->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                        @endcan

                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">لا يوجد منتجات للعرض</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





