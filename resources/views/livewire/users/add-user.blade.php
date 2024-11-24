<x-create-modal-component title="{{trans('admin.create_user')}}">
    @php
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->whereNot('branch_num',1)->get();
    @endphp
        @push('css')
            <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
            <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
            {{-- <style>
                .select2-container {
                    border-color:#ced4da !important;
                    padding-bottom: 20px !important;
                }

                .select2-container .select2-selection {
                    height: 40px; /* Adjust the height value as per your requirements */
                    }
            .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple {
                border-color:#ced4da !important
                padding:2% 0;
            }

            </style> --}}
        @endpush
    <div class="row">
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='name'>{{trans('admin.name')}}</label><span class="text-danger"> *</span>
                <input type="text" wire:model='name' class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = " {{trans('admin.name')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='email'>{{trans('admin.email')}}</label><span class="text-danger"> *</span>
                <input type="email"  wire:model='email' class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "{{trans('admin.email')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'email'])
        </div>

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='password'> {{trans('admin.password')}}</label><span class="text-danger"> *</span>
                <input type="password" wire:model='password' class= 'form-control mt-1 mb-3 @error('password') is-invalid @enderror' placeholder = " {{trans('admin.password')}} ">
            </div>
            @include('inc.livewire_errors',['property'=>'password'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='password_confirmation'> {{trans('admin.password_confirmation')}} </label><span class="text-danger"> *</span>
                <input type="password" wire:model='password_confirmation' class= 'form-control mt-1 mb-3 @error('password_confirmation') is-invalid @enderror' placeholder = " {{trans('admin.password_confirmation')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'password_confirmation'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='roles_name'>{{trans('admin.role')}} </label><span class="text-danger"> *</span>
                <select wire:model='roles_name' class= 'form-control mt-1 mb-3 @error('roles_name') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_role')}}  </option>
                    @foreach ( Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'roles_name'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='branch_id'>{{trans('admin.branch')}} </label><span class="text-danger"> *</span>
                <select wire:model='branch_id' class= 'form-control mt-1 mb-3 @error('branch_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_branch')}}  </option>
                    @foreach ( $branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'branch_id'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='gender'> النوع </label><span class="text-danger"> *</span>
                <select wire:model='gender' class= 'form-control mt-1 mb-3 @error('gender') is-invalid @enderror'>
                    <option value="">إختر النوع </option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثي</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'gender'])
        </div>
        <div class="col-3 mb-3">
            <div class="form-group">
                <label for='joining_date'> تاريخ الالتحاق بالعمل </label><span class="text-danger"> *</span>
                <input type="date" wire:model='joining_date' class= 'form-control mt-1 mb-3 @error('joining_date') is-invalid @enderror' placeholder = " تاريخ الالتحاق بالعمل">
            </div>
            @include('inc.livewire_errors',['property'=>'joining_date'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='age'>العمر </label><span class="text-danger"> *</span>
                <input type="number" wire:model='age' class= 'form-control mt-1 mb-3 @error('age') is-invalid @enderror' placeholder = " العمر">
            </div>
            @include('inc.livewire_errors',['property'=>'age'])
        </div>
        
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='medical_insurance_deduction'>إستقطاعات التأمين الطبي(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='medical_insurance_deduction' class= 'form-control mt-1 mb-3 @error('medical_insurance_deduction') is-invalid @enderror' placeholder = "إستقطاعات التأمين الطبي ">
            </div>
            @include('inc.livewire_errors',['property'=>'medical_insurance_deduction'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='transfer_allowance'>بدل الإنتقالات(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='transfer_allowance' class= 'form-control mt-1 mb-3 @error('transfer_allowance') is-invalid @enderror' placeholder = "بدل الإنتقالات">
            </div>
            @include('inc.livewire_errors',['property'=>'transfer_allowance'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='housing_allowance'>بدل السكن(بالشهر)</label>
                <input type="number" min='0' step="any" wire:model='housing_allowance' class= 'form-control mt-1 mb-3 @error('housing_allowance') is-invalid @enderror' placeholder = "بدل السكن">
            </div>
            @include('inc.livewire_errors',['property'=>'housing_allowance'])
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='salary'>الراتب بدون بدلات</label><span class="text-danger"> *</span>
                <input type="number" min='0' step="any" wire:model='salary' class= 'form-control mt-1 mb-3 @error('salary') is-invalid @enderror' placeholder = "الراتب بدون بدلات">
            </div>
            @include('inc.livewire_errors',['property'=>'salary'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='overtime_hour_price'>تكلفة ساعة الاضافي</label>
                <input type="number" min='0' step="any" wire:model='overtime_hour_price' class= 'form-control mt-1 mb-3 @error('overtime_hour_price') is-invalid @enderror' placeholder = "تكلفة ساعة الإضافي">
            </div>
            @include('inc.livewire_errors',['property'=>'overtime_hour_price'])
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='vacation_balance'>رصيد الاجازات</label>
                <input type="number" min='0' step="any" wire:model='vacation_balance' class= 'form-control mt-1 mb-3 @error('vacation_balance') is-invalid @enderror' placeholder = " رصيد الأجازات">
            </div>
            @include('inc.livewire_errors',['property'=>'vacation_balance'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='working_status'>حالة العمل</label>
                <select wire:model='working_status' class= 'form-control mt-1 mb-3 @error('working_status') is-invalid @enderror'>
                    <option value="">إختر  حالة العمل </option>
                    <option value="working">علي رأس العمل</option>
                    <option value="not_working">تم أنهاء العمل لدينا</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'working_status'])
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='resignation_date'>تاريخ الإستقالة</label>
                <input type="date" wire:model='resignation_date' class= 'form-control mt-1 mb-3 @error('resignation_date') is-invalid @enderror' placeholder = "تاريج الإستقالة">
            </div>
            @include('inc.livewire_errors',['property'=>'resignation_date'])
        </div>
    
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='fingerprint_code'> كود البصمة </label>
                <input type="text" wire:model='fingerprint_code' class= 'form-control mt-1 mb-3 @error('fingerprint_code') is-invalid @enderror' placeholder = " كود البصمة">
            </div>
            @include('inc.livewire_errors',['property'=>'fingerprint_code'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='blood_type_id'> فصبلة الدم </label>
                <select wire:model='blood_type_id' class= 'form-control mt-1 mb-3 @error('blood_type_id') is-invalid @enderror'>
                    <option value="">إختر فصبلة الدم  </option>
                    @foreach ( App\Models\BloodType::all() as $bloodType)
                        <option value="{{ $bloodType->id }}">{{ $bloodType->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'blood_type_id'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='marital_status'> الحالة الاجتماعية </label>
                <select wire:model='marital_status' class= 'form-control mt-1 mb-3 @error('marital_status') is-invalid @enderror'>
                    <option value="">إختر الحالة الاجتماعية </option>
                    <option value="married">متزوج</option>
                    <option value="single">أعزب</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'marital_status'])
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='nationality_id'>الجنسية</label>
                <select wire:model='nationality_id' style="height: 50px;" class='form-control select2bs4 pb-3 @error('nationality_id') is-invalid @enderror'>
                    <option value="">الجنسية</option>
                    @foreach ( App\Models\Nationality::select('id',   'name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $nat)
                        <option value="{{ $nat->id }}">{{ $nat->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'nationality_id'])
        </div>

         <div class="col-3 mb-2">
            <div class="form-group">
                <label for='job_title'>المسمي الوظيفي</label>
                <input type="text" wire:model='job_title' class='form-control pb-3 @error('job_title') is-invalid @enderror'>
                @include('inc.livewire_errors',['property'=>'job_title'])
            </div>
        </div>
            


        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='address'>{{trans('admin.address')}}</label>
                <input type="text" wire:model='address' class= 'form-control mt-1 mb-3 @error('address') is-invalid @enderror' placeholder = " {{trans('admin.address')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'address'])
        </div>

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='phone'>{{trans('admin.phone')}}</label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = " {{trans('admin.phone')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'phone'])
        </div>


        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='date_of_birth'>تاريخ الميلاد</label>
                <input type="date" wire:model='date_of_birth' class= 'form-control mt-1 mb-3 @error('date_of_birth') is-invalid @enderror' placeholder = " تاريخ الميلاد">
            </div>
            @include('inc.livewire_errors',['property'=>'date_of_birth'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='id_num'>رقم الهوية</label>
                <input type="text" wire:model='id_num' class= 'form-control mt-1 mb-3 @error('id_num') is-invalid @enderror' placeholder = " رقم الهوية">
            </div>
            @include('inc.livewire_errors',['property'=>'id_num'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='id_exp_date'>تاريخ انتهاء الهوية</label>
                <input type="date" wire:model='id_exp_date' class= 'form-control mt-1 mb-3 @error('id_exp_date') is-invalid @enderror' placeholder = " تاريخ انتهاء الهوية">
            </div>
            @include('inc.livewire_errors',['property'=>'id_exp_date'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='passport_num'>رقم جواز السفر</label>
                <input type="text" wire:model='passport_num' class= 'form-control mt-1 mb-3 @error('passport_num') is-invalid @enderror' placeholder = " رقم جواز السفر">
            </div>
            @include('inc.livewire_errors',['property'=>'passport_num'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='passport_exp_date'>تاريج إنتهاء جواز السفر</label>
                <input type="date" wire:model='passport_exp_date' class= 'form-control mt-1 mb-3 @error('passport_exp_date') is-invalid @enderror' placeholder = " تاريج إنتهاء جواز السفر">
            </div>
            @include('inc.livewire_errors',['property'=>'passport_exp_date'])
        </div>

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="has_driving_license">
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="لديه رخصة قيادة" readonly>
            </div>
            @include('inc.livewire_errors',['property'=>'has_driving_license'])
        </div>
        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="has_medical_insurance">
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="لديه تأمين طبي" readonly>
            </div>
            @include('inc.livewire_errors',['property'=>'has_medical_insurance'])
        </div>

    </div>
</x-create-modal-component>
