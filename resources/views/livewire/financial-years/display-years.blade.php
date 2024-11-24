<div class="container-fluid">
    <style>
        .modal-dialog {
            width: 500px;
        }
    </style>
    <div class="row my-auto">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>قائمة السنوات المالية</h3>
                        <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal"  title="إضافة سنة جديدة">
                           إضافة سنة
                        </button>
                    </div>

                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>السنة المالية</th>
                            {{-- <th>وصف السنة</th> --}}
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>الحالة</th>
                            <th>الإضافة بواسطة</th>
                            <th>التعديل بواسطة</th>
                            <th>الشهور المالية</th>
                            <th>الحالة</th>
                            <th>تعديل</th>
                            {{-- <th>حذف</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($years as $year)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $year->year }}</td>
                                {{-- <td>{{ $year->year_desc }}</td> --}}
                                <td>{{ $year->start_date }}</td>
                                <td>{{ $year->end_date }}</td>
                                <td>{{ $year->is_opened }}</td>
                                <td>{{ $year->createdBy ? $year->createdBy->name : '---' }}</td>
                                <td>{{ $year->updatedBy ? $year->createdBy->name : '---' }}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#show_year_{{$year->id}}" class="btn btn-sm btn-warning" title="عرض الشهور المالية للسنة">
                                        <i class="fa fa-eye" style="color: #fff";></i>
                                    </a>

                                    <!-- Show year modal  -->
                                    <div class="modal fade" id="show_year_{{$year->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="exampleModalLabel" >عرض الشهور للسنة المالية : <span class="text-muted"  >{{ $year->year }}</span> </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body" style="width: 100%">
                                                <table class="table table-bordered">
                                                    <thead  class="bg_table_head">
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>إسم الشهر</th>
                                                            <th> رقم الشهر </th>
                                                            <th> عدد أيام الشهر </th>
                                                            <th>بداية الشهر</th>
                                                            <th>نهاية الشهر</th>
                                                            <th>الإضافة بواسطة</th>
                                                            <th>التعديل بواسطة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($year->months)
                                                            @foreach ($year->months as $month)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $month->month_name }}</td>
                                                                    <td>{{ $month->month_id }}</td>
                                                                    <td>{{ $month->no_of_days }}</td>
                                                                    <td>{{ $month->start_date }}</td>
                                                                    <td>{{ $month->end_date }}</td>
                                                                    <td>{{ $month->createdBy ? $month->createdBy->name : '---' }}</td>
                                                                    <td>{{ $month->updatedBy ? $month->createdBy->name : '---' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#change-state-{{$year->id}}" class="btn btn-sm btn-{{$year->is_opened == true ? 'success' : 'secondary'}} mx-1" title="{{$year->is_active == 1 ? 'حالية' : 'مغلقة'}}">
                                        <i class="fa fa-toggle-{{$year->is_opened == 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                    </a>
                                    <!-- Change state modal  -->
                                    {{-- <form action="{{route('financial_years.toggle_state',$year->id)}}" method="POST"> --}}
                                        <div class="modal fade" id="change-state-{{$year->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">تغيير حالة الفرع</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                        <p>هل انت متأكد من تغيير حالة السنة المالية </p>
                                                        @csrf
                                                        <input type="hidden" value="{{$year->id}}" name="year_id">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                            <button type="submit" name="submit" class="btn btn-info">تعديل</button>
                                                        </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    {{-- </form> --}}

                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                        data-toggle="modal"
                                        wire:click="$dispatch('editYear',{id:{{$year->id}}})">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>




                                {{-- <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                        data-toggle="modal"
                                        wire:click="$dispatch('deleteyear',{id:{{$year->id}}})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted font-weight-bold">لا يوجد بيانات للعرض</td>
                            </tr>
                        @endforelse


                    </tbody>
                    </table>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>
