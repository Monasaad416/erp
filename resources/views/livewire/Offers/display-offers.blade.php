<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة العروض</h4>
                    @can('اضافة-عرض')
                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="قائمة العروض">
                        <span style="font-weight: bolder; font-size:">إضافة عرض</span>
                    </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                    <div class="d-flex my-3">
                        <input type="text" class="form-control w-25 search_term" placeholder="{{trans('admin.search_by_product_name')}}" wire:model.live="searchItem">
                        {{-- <select class="form-control w-25 mx-5" wire:model.live="filter">
                            <option value="">كل العرضات</option>
                            <option value="inside_invoices">المجرودة</option>
                            <option value="outside_invoices">الغيرمجرودة</option>
                        </select> --}}
                    </div>

                @if($offers->count() > 0)
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
                                <th>المنتج</th>
                                <th>وصف العرض</th>
                                <th>سعر العرض</th>
                                <th>نسبة الخصم</th>
                                <th>الأفرع</th>
                                @can( 'تعديل-عرض')
                                <th>{{trans('admin.edit')}}</th>
                                @endcan
                                    @can( 'حذف-عرض')
                                <th>{{trans('admin.delete')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($offers as $offer)

                                <tr>
                                    <td style="width:2%">{{$loop->iteration}}</td>
                                    <td>{{ $offer->product->name }}</td>
                                    <td>{{ $offer->description? $offer->description : '---' }}</td>
                                    <td>{{ $offer->price ? $offer->price : '---' }}</td>
                                    <td>{{ $offer->percentage ? $offer->percentage : '---' }}</td>

                                     <td>
                                        @php
                                            $branchesIds = App\Models\BranchOffer::where('offer_id', $offer->id)->pluck('branch_id')->toArray();
                                            //dd($branchesIds)
                                        @endphp
                                        <ul>
                                            @foreach ($branchesIds as $branchId)
                                                <li> {{ App\Models\Branch::where('id',$branchId)->first()->name_ar }} </li>
                                            @endforeach
                                        </ul>
                                     </td>



                                    @can( 'تعديل-عرض')
                                    <td>

                                        <button type="button" class="btn btn-outline-info btn-sm mx-1" title="{{trans('admin.edit')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('updateOffer',{id:{{$offer->id}}})">
                                            <i class="far fa-edit"></i>
                                        </button>

                                    </td>
                                    @endcan
                                    @can('حذف-عرض')
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="{{trans('admin.delete')}}"
                                            data-toggle="modal"
                                            wire:click="$dispatch('deleteOffer',{id:{{$offer->id}}})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                        @endcan

                                </tr>


                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">لا يوجد  عروض</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$offers->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





