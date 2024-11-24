<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    {{-- <h4 class="card-title h4">{{trans('admin.shortcomings_list')}}</h4> --}}

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

                @if($shortcomings->count() > 0)
                    <style>
                        .table thead tr th{
                            text-align:center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>الرقم التسلسلي</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>كود المنتج</th>
                                <th>{{trans('admin.category')}}</th>
              
                                <th>{{ trans('admin.unit') }}</th>
                                <th>{{ trans('admin.branch') }}</th>
                                

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($shortcomings as $shortcoming)

                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $shortcoming->serial_num }}</td>
                                    <td>{{ $shortcoming->name_ar }}</td>
                                    <td>{{ $shortcoming->code }}</td>
                                    <td>{{ $shortcoming->category->name }}</td>
                    
                                    <td>{{ $shortcoming->unit->name }}</td>
                                    <td>{{ $shortcoming->branch->name }}</td>

     
                                </tr>

                                {{-- <livewire:shortcomings.update-product :product="$product" /> --}}
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">لا يوجد منتجات للعرض</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$shortcomings->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





