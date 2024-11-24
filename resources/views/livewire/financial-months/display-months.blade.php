<div class="card">
    <div class="card-header">
    <h3 class="card-title">الشهور المالية</h3>
    </div>
    <div class="bg-danger-outline">
    @include('inc.errors')
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>السنة المالية</th>
                    <th>إسم الشهر</th>
                    <th> رقم الشهر </th>
                    <th> عدد أيام الشهر </th>
                    <th>بداية الشهر</th>
                    <th>نهاية الشهر</th>
                    <th>بداية البصمة</th>
                    <th>نهاية البصمة</th>
                    <th>الإضافة بواسطة</th>
                    <th>التعديل بواسطة</th>
                    <th>الحالة</th>
                    <th>تعديل</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($months as $month)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $month->financialYear->year }}</td>
                                <td>{{ $month->month_name }}</td>
                                <td>{{ $month->month_id }}</td>
                                <td>{{ $month->no_of_days }}</td>
                                <td>{{ $month->start_date }}</td>
                                <td>{{ $month->end_date }}</td>
                                <td>{{ $month->signature_start_date }}</td>
                                <td>{{ $month->signature_end_date }}</td>
                                <td>{{ $month->createdBy->name }}</td>
                                <td>{{ $month->updatedBy ? $month->updatedBy->name : '---'}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#change-state-{{$month->id}}" class="btn btn-sm btn-{{$month->is_opened == 1 ? 'success' : 'secondary'}} mx-1" title="{{$month->is_opened == 1 ? 'حالية' : 'مغلقة'}}">
                                        <i class="fa fa-toggle-{{$month->is_opened == 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                                    </a>
                                </td>
                                <!-- Change state modal  -->
                                <form action="{{route('admin.financial_months.toggle_state',$month->id)}}" method="POST">
                                    <div class="modal fade" id="change-state-{{$month->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">تغيير حالة الشهر المالي </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                    <p>هل انت متأكد من تغيير حالة الشهر المالي </p>
                                                    @csrf
                                                    <input type="hidden" value="{{$month->id}}" name="month_id">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                        <button type="submit" name="submit" class="btn btn-info">تعديل</button>
                                                    </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                                <td>
                                    <a href="{{route('admin.financial_months.edit',$month->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true" title="تعديل السنة"><i class="fa fa-edit text-white" aria-hidden="true"></i></a>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_month{{ $month->id }}" title="حذف السنة"><i class="fa fa-trash"></i></button>
                                    <!-- Delete Modal -->
                                    <form action="{{route('admin.financial_months.destroy',$month)}}" method="POST">
                                        <div class="modal fade" id="delete_month{{$month->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">حذف شهر من قائمة الشهور المالية</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل انت متأكد من حذف الشهر المالي {{ $month->name}}</p>
                                                        @csrf
                                                        @method('DELETE')
                                                        {{-- {{method_field('delete')}} --}}
                                                        <input type="hidden" value="{{$month->id}}" name="month_id">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                            <button type="submit" name="submit" class="btn btn-danger">حذف</button>
                                                        </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                            </tr>
                                        @forelse ($branches as $branch)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->address }}</td>
                        <td>{{ $branch->phone }}</td>
                        <td>{{ $branch->email ? $branch->email : '---' }}</td>
                        <td>{{ $branch->createdBy->name }}</td>
                        <td>{{ $branch->updatedBy ?  $branch->updatedBy->name :'---' }}</td>
                        <td>
                            <a data-toggle="modal" data-target="#change-state-{{$branch->id}}" class="btn btn-sm btn-{{$branch->is_active == 1 ? 'success' : 'secondary'}} mx-1" title="{{$branch->is_active == 1 ? 'حالية' : 'مغلقة'}}">
                                <i class="fa fa-toggle-{{$branch->is_active == 1 ? 'on' : 'off'}}" style="color: #fff";></i>
                            </a>

                            <!-- Change state modal  -->
                            <form action="{{route('admin.branches.toggle_state',$branch->id)}}" method="POST">
                                <div class="modal fade" id="change-state-{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">تغيير حالة الفرع</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                                <p>هل انت متأكد من تغيير حالة الفرع </p>
                                                @csrf
                                                <input type="hidden" value="{{$branch->id}}" name="branch_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                    <button type="submit" name="submit" class="btn btn-info">تعديل</button>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </td>

                        <td>
                            <a href="{{route('admin.branches.edit',$branch->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true" title="تعديل السنة"><i class="fa fa-edit text-white" aria-hidden="true"></i></a>
                        </td>


                        <td>
                            <a data-toggle="modal" data-target="#show_branch_{{$branch->id}}" class="btn btn-sm btn-secondary mx-1" title="عرض الشهور المالية للسنة">
                                <i class="fa fa-eye" style="color: #fff";></i>
                            </a>

                            <!-- Show branch modal  -->
                            <div class="modal fade" id="show_branch_{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabel" >عرض الشهور للسنة المالية : <span class="text-muted"  >{{ $branch->branch }}</span> </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead  class="bg_table_head">
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>إسم الشهر</th>
                                                    <th> رقم الشهر </th>
                                                    <th> عدد أيام الشهر </th>
                                                    <th>بداية الشهر</th>
                                                    <th>نهاية الشهر</th>
                                                    <th>بداية البصمة</th>
                                                    <th>نهاية البصمة</th>
                                                    <th>الإضافة بواسطة</th>
                                                    <th>التعديل بواسطة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @isset($branch->months)
                                                    @foreach ($branch->months as $month)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $month->month_name }}</td>
                                                            <td>{{ $month->month_id }}</td>
                                                            <td>{{ $month->no_of_days }}</td>
                                                            <td>{{ $month->start_date }}</td>
                                                            <td>{{ $month->end_date }}</td>
                                                            <td>{{ $month->signature_start_date }}</td>
                                                            <td>{{ $month->signature_end_date }}</td>
                                                            <td>{{ $month->createdBy->name }}</td>
                                                            <td>{{ $month->updatedBy->name }}</td>
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
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_branch{{ $branch->id }}" title="حذف السنة"><i class="fa fa-trash"></i></button>
                            <!-- Delete Modal -->
                            <form action="{{route('admin.branches.destroy',$branch)}}" method="POST">
                                <div class="modal fade" id="delete_branch{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف فرع من قائمة الافرع</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>هل انت متأكد من حذف الفرع؟{{ $branch->name}}</p>
                                            @csrf
                                            @method('DELETE')
                                            {{-- {{method_field('delete')}} --}}
                                            <input type="hidden" value="{{$branch->id}}" name="branch_id">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                <button type="submit" name="submit" class="btn btn-danger">حذف</button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>لا يوجد بيانات للعرض</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>