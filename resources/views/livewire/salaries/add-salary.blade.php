

<div>

        <form wire:submit.prevent="create">
            @csrf
            <div class="d-flex justify-content-between" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                <h5> حسابات راتب - <span class="text-danger">{{ $user->name }}  </span> عن شهر {{ Carbon\Carbon::now()->format('Y F') }} </h5>
                <hr>
                <h6> رقم الحساب المالي  - <span class="text-danger"> {{ $user->account_num }}</span>  </h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mt-6" >
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="from_date">من تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model="from_date" wire:change.live="getValues" class="form-control @error('from_date') is-invalid @enderror" placeholder="من تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'from_date'])
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="to_date">إلي تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model="to_date" wire:change.live="getValues" class="form-control @error('to_date') is-invalid @enderror" placeholder="إلي تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'to_date'])
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='mainSalary'>الراتب الأساسي</label>
                                <input type="number" min="0" readonly class="form-control @error('mainSalary') is-invalid @enderror" wire:model="mainSalary"  placeholder = "الراتب الأساسي">
                            </div>
                            @include('inc.livewire_errors',['property'=>'mainSalary'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_overtime'>الإضافي</label>
                                <input type="number" min="0" readonly class="form-control @error('total_overtime') is-invalid @enderror" wire:model="total_overtime"  placeholder = "الإضافي">
                            </div>
                            @include('inc.livewire_errors',['property'=>'total_overtime'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_commission_rate'>عمولات المبيعات</label>
                                <input type="number" min="0" readonly class="form-control @error('total_commission_rate') is-invalid @enderror" wire:model="total_commission_rate"  placeholder = "عمولات المبيعات">
                            </div>
                            @include('inc.livewire_errors',['property'=>'total_commission_rate'])
                        </div>
                       <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='rewards'>المكافئات</label>
                                <input type="number" min="0" readonly class="form-control @error('rewards') is-invalid @enderror" wire:model="rewards"  placeholder = "المكافئات">
                            </div>
                            @include('inc.livewire_errors',['property'=>'rewards'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='housing_allowance'>بدل السكن</label>
                                <input type="number" min="0" readonly class="form-control @error('housing_allowance') is-invalid @enderror" wire:model="housing_allowance"  placeholder = "بدل السكن">
                            </div>
                            @include('inc.livewire_errors',['property'=>'housing_allowance'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='transfer_allowance'>بدل  الإنتقال</label>
                                <input type="number" min="0" readonly class="form-control @error('transfer_allowance') is-invalid @enderror" wire:model="transfer_allowance"  placeholder = "بدل  الإنتقال">
                            </div>
                            @include('inc.livewire_errors',['property'=>'transfer_allowance'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='medical_insurance_deduction'>استقطاع التأمين الصحي</label>
                                <input type="number" min="0" readonly class="form-control @error('medical_insurance_deduction') is-invalid @enderror" wire:model="medical_insurance_deduction"  placeholder = "استقطاع التأمين الصحي">
                            </div>
                            @include('inc.livewire_errors',['property'=>'medical_insurance_deduction'])
                        </div>
                       <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='advance_payment_deduction'>خصومات السلف</label>
                                <input type="number" min="0" readonly class="form-control @error('advance_payment_deduction') is-invalid @enderror" wire:model="advance_payment_deduction"  placeholder = "خصومات السلف">
                            </div>
                            @include('inc.livewire_errors',['property'=>'advance_payment_deduction'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='total_commission_rate'>خصومات أخري</label><span class="text-danger"> *</span>
                                <input type="number" min="0" readonly class="form-control @error('total_commission_rate') is-invalid @enderror" wire:model="total_commission_rate"  placeholder = "خصومات أخري">
                            </div>
                            @include('inc.livewire_errors',['property'=>'total_commission_rate'])
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for='delay'>عدد دقائق التأخير</label>
                                <input type="number" min="0" readonly class="form-control @error('delay') is-invalid @enderror" wire:model="delay"  placeholder = "عدد دقائق التأخير">
                            </div>
                            @include('inc.livewire_errors',['property'=>'delay'])
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for='total_delay'>تكلفة التأخير</label><span class="text-danger"> *</span>
                                <input type="number" min="0" class="form-control @error('total_delay') is-invalid @enderror" wire:model="total_delay"  placeholder = "تكلفة التأخير">
                            </div>
                            @include('inc.livewire_errors',['property'=>'total_delay'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='required_days'>عدد الأيام المطلوب حضورها</label><span class="text-danger"> *</span>
                                <input type="number" min="0" class="form-control @error('required_days') is-invalid @enderror" wire:model="required_days"  placeholder = "عدد الأيام المطلوب حضورها">
                            </div>
                            @include('inc.livewire_errors',['property'=>'required_days'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='actual_days_num'>أيام الحضور الفعلية</label>
                                <input type="number" min="0" readonly class="form-control @error('actual_days_num') is-invalid @enderror" wire:model="actual_days_num"  placeholder = "أيام الحضور الفعلية">
                            </div>
                            @include('inc.livewire_errors',['property'=>'actual_days_num'])
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for='receiving_type'>طريقة استلام الراتب</label><span class="text-danger"> *</span>
                                <select wire:model.live='receiving_type' style="height: 45px;" class='form-control  pb-3 @error('receiving_type') is-invalid @enderror'>
                                    <option value="">إختر الطريقة</option>

                                    <option value="cash">كاش</option>
                                    <option value="visa">تحويل بنكي</option>


                                </select>
                            </div>
                            @include('inc.livewire_errors',['property'=>'receiving_type'])
                        </div>
                        @if($receiving_type == 'visa')
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label for='bank_id'>البنك</label><span class="text-danger"> *</span>
                                    <select wire:model='bank_id' class= 'form-control mt-1 mb-3 @error('bank_id') is-invalid @enderror'>
                                        <option value="">إختر البنك</option>
                                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $partner )
                                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @include('inc.livewire_errors',['property'=>'bank_id'])
                            </div>
                            {{-- <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label for='check_num'>رقم الحساب البنكي</label>
                                    <input type="text" wire:model='check_num' class= 'form-control mt-1 mb-3 @error('check_num') is-invalid @enderror' placeholder = "رقم الشيك">
                                </div>
                                @include('inc.livewire_errors',['property'=>'check_num'])
                            </div> --}}
                        @endif    
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit"  class="btn btn-success mx-2"> إعتماد الراتب</button>
            </div>
        </form>
    @push('scripts')

    @endpush
</div>


