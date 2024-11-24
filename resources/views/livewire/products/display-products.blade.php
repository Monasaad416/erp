<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">{{trans('admin.products_list')}}</h4>
                    @can('اضافة-منتج')
                    <div>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_product')}}">
                            <span style="font-weight: bolder; font-size:">{{trans('admin.create_product')}}</span>
                        </button>
                        <button type="button" class="btn bg-gradient-warning mx-2" data-toggle="modal" wire:click="$dispatch('importProducts')">
                                استيراد من  EXCEL
                        </button>
                    </div>
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
                     {{-- {{ dd(Auth::user()->getPermissionsViaRoles()) }} --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>{{ trans('admin.status') }}</th>
                                <th>{{ trans('admin.sale_price') }}</th>
                                <th>الضريبة</th>
                                {{-- <th>{{ trans('admin.commission_rate') }}%</th> --}}
                                <th>{{ trans('admin.inventory_balance') }}</th>
                                <th>تنبية الرصيد بالمخزن الرئيسي</th>
                                <th>تنبيه الرصيد بمخزن الفرع</th>
                                <th>{{trans('admin.show')}}</th>
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
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-{{$product->is_active == 1 ? 'success' : 'secondary'}} btn-sm mx-1" title="{{$product->is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('toggleProduct',{id:{{$product->id}}})">
                                            <i class="fa fa-toggle-{{$product-> is_active== 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                        </button>
                                    </td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td class="text-{{ $product->taxes == 1 ? 'success' :'danger'}}"> {{ $product->taxes == 1 ? 'خاضع للضريبة' :'غير خاضع للضريبة' }} </td>
                                    <td>{{ App\Models\Inventory::where('product_id',$product->id)->where('branch_id',1)->latest()->first()->inventory_balance }}</td>

                                     <td>{{ $product->alert_main_branch }}</td>

                                     <td >
                                        {{ $product->alert_branch }}
                                    </td>
                                    <td>
                                        <a href="{{ route('product.show',['id'=> $product->id]) }}">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.show')}}">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>

                                    @can( 'تعديل-منتج')
                                    <td>

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateProduct',{id:{{$product->id}}})">
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

                                {{-- <livewire:products.update-product :product="$product" /> --}}
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





