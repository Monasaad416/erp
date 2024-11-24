<x-create-modal-component title="إضافة مكافاءة">
        @php
            $branches = App\Models\Branch::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->whereNot('id',1)->get();
            $months = App\Models\FinancialMonth::where('year',date('Y'))->get();

        @endphp


    <div class="row">
        {{-- <div class="col-12 bg-danger py-2">إذا كانت المكافاءة  سوف يتم تطبيقها علي  سنة مالية قادمة فضلا قم بتسجيل السنة المالية اولا ثم أضف المكافاءة</div> --}}
        @if(Auth::user()->roles_name == 'سوبر-ادمن')
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for='branch_id'>الفرع</label>

                    <select wire:model='branch_id'  wire:change='branchIdChanged' style="height: 45px;" class='form-control pb-3 @error('branch_id') is-invalid @enderror'>
                        <option value="">إختر الفرع</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>

                </div>
                @include('inc.livewire_errors',['property'=>'branch_id'])
            </div>
        @endif
        <div class="col-{{Auth::user()->roles_name == 'سوبر-ادمن' ? 4 : 6 }} mb-2">
            <div class="form-group">
                <label for='user_id'>الموظف</label>
                <select wire:model='user_id' wire:change.live="getAccountNum" style="height: 45px;" class='form-control  pb-3 @error('user_id') is-invalid @enderror'>
                    <option value="">إختر الموظف</option>
                    @if (!is_null($branch_id))
                        @foreach ( $selectedUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'user_id'])
        </div>

        <div class="col-{{Auth::user()->roles_name == 'سوبر-ادمن' ? 4 : 6 }} mb-2">
            <div class="form-group">
                <label for='financial_month_id'>الشهر المالي</label>
                <select wire:model='financial_month_id' style="height: 45px;" class='form-control  pb-3 @error('financial_month_id') is-invalid @enderror'>
                    <option value="">الشهر المالي</option>
                    @foreach ( App\Models\FinancialMonth::where('year',date('Y'))->get() as $month)
                        @if($month->month_id >= Carbon\Carbon::now()->format('m'))
                            <option value="{{ $month->id }}">{{ $month->month_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'financial_month_id'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='account_num'>رقم الحساب المالي </label><span class="text-danger"> *</span>
                <input type="number" wire:model='account_num' readonly class= 'form-control mt-1 mb-3 @error('account_num') is-invalid @enderror' placeholder = " رقم الحساب المالي">
            </div>
            @include('inc.livewire_errors',['property'=>'account_num'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='amount'>مبلغ المكافاءة </label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='amount' class= 'form-control mt-1 mb-3 @error('amount') is-invalid @enderror' placeholder = " مبلغ المكافاءة">
            </div>
            @include('inc.livewire_errors',['property'=>'amount'])
        </div>
        <div class="col-12 mb-2">
            <div class="form-group">
                <label for="notes">ملاحظات</label>
                <textarea wire:model="notes" class="form-control mt-1 mb-3 @error('notes') is-invalid @enderror" placeholder="ملاحظات"></textarea>
            </div>
            @include('inc.livewire_errors', ['property' => 'notes'])
        </div>
    </div>





</x-create-modal-component>
