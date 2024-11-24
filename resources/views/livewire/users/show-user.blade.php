<x-show-modal-component title="بيانات الموظف">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25">{{ trans('admin.item') }}</th>
                            <th class="w-75">{{ trans('admin.details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-25">{{ trans('admin.name') }}</td>
                            <td class="w-75">{{ $name }}</td>
                        </tr>

                        <tr>
                            <td>النوع</td>
                            <td class="w-75">{{ $gender ? $gender : '---' }}</td>
                        </tr>
                        <tr>
                            <td>تاريخ الميلاد</td>
                            <td class="w-75">{{ $date_of_birth ? $date_of_birth : '---'}}</td>
                        </tr>
                        <tr>
                            <td class="w-25">المهمة</td>
                            <td class="w-75">{{ $roles_name }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">البريد الالكتروني</td>
                            <td class="w-75">{{ $email ? $email : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">الهاتف</td>
                            <td class="w-75">{{ $phone ? $phone : '---' }}</td>
                        </tr>

                              <tr>
                            <td class="w-25">العنوان</td>
                            <td class="w-75">{{ $address ? $address : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">العمر</td>
                            <td class="w-75">{{ $age ? $age : '---' }}</td>
                        </tr>

                       <tr>
                            <td class="w-25">الجنسية</td>
                            <td class="w-75">{{ $nationality ? $nationality : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">فصيلة الدم</td>
                            <td class="w-75">{{ $bloodType ? $bloodType : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">الكود</td>
                            <td class="w-75">{{ $code ? $code : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">كود البصمة</td>
                            <td class="w-75">{{ $fingerprint_code ? $fingerprint_code : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">تاريخ الاإلتحاق بالعمل</td>
                            <td class="w-75">{{ $joining_date ? $joining_date : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">الفرع</td>
                            <td class="w-75">{{ $branch ? $branch : '---' }}</td>
                        </tr>
          
                        <tr>
                            <td class="w-25">علي رأس العمل </td>
                            <td class="w-75 text-{{ $working_status == 'working' ? 'success' : 'danger' }}">{{ $working_status == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>

                        <tr>
                            <td class="w-25">لديه تأمين طبي</td>
                            <td class="w-75 text-{{ $has_medical_insurance == 1 ? 'success' : 'danger' }}">{{ $has_medical_insurance == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">لديه رخصة قيادة</td>
                            <td class="w-75 text-{{ $has_driving_license == 1 ? 'success' : 'danger' }}" >{{ $has_driving_license == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">الراتب</td>
                            <td class="w-75"> {{ $salary  ? $salary :  0 }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">تكلفةة ساعة الإضافي</td>
                            <td class="w-75"> {{ $overtime_hour_price ? $overtime_hour_price:  0 }}</td>
                        </tr>
                                
                        <tr>
                            <td class="w-25">علي رأس العمل </td>
                            <td class="w-75 text-{{ $working_status == 'working' ? 'success' : 'danger' }}">{{ $working_status == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                                
                        <tr>
                            <td class="w-25"> تاريخ الاستقالة - في حالة إنهاء العمل </td>
                            <td class="w-75 >{{ $resignation_date  ? $resignation_date  : 0 }}</td>
                        </tr>
                    </tbody>
                </table>
</x-show-modal-component>