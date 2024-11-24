<x-update-modal-component title="إضافة أصل ثابت">
    {{-- <div class="row">
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='name_ar'>{{trans('admin.name_ar')}}</label><span class="text-danger"> *</span>
                <input type="text" wire:model='name_ar' class= 'form-control mt-1 mb-3 @error('name_ar') is-invalid @enderror' placeholder = "{{trans('admin.name_ar')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_ar'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='name_en'>{{trans('admin.name_en')}}</label>
                <input type="text" wire:model='name_en' class= 'form-control mt-1 mb-3 @error('name_en') is-invalid @enderror' placeholder = "{{trans('admin.name_en')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_en'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='life_span'>العمر الإفتراضي بالسنوات</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='life_span' class= 'form-control mt-1 mb-3 @error('life_span') is-invalid @enderror' placeholder = "العمر الإفتراضي">
            </div>
            @include('inc.livewire_errors',['property'=>'life_span'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='purchase_price'>سعر الشراء</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='purchase_price' class= 'form-control mt-1 mb-3 @error('purchase_price') is-invalid @enderror' placeholder = "سعر الشراء">
            </div>
            @include('inc.livewire_errors',['property'=>'purchase_price'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='scrap_price'> قيمة الخردة</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='scrap_price' class= 'form-control mt-1 mb-3 @error('scrap_price') is-invalid @enderror' placeholder = "سعر البيع خردة">
            </div>
            @include('inc.livewire_errors',['property'=>'scrap_price'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='purchase_date'>تاريخ الشراء</label><span class="text-danger"> *</span>
                <input type="date"  wire:model='purchase_date' class= 'form-control mt-1 mb-3 @error('purchase_date') is-invalid @enderror' placeholder = "تاريخ الشراء">
            </div>
            @include('inc.livewire_errors',['property'=>'purchase_date'])
        </div>
        @if(Auth::user()->roles_name == 'سوبر-ادمن')
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for='branch_id'>الفرع</label>

                    <select wire:model='branch_id' style="height: 45px;" class='form-control pb-3 @error('branch_id') is-invalid @enderror'>
                        <option value="">إختر الفرع</option>
                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name_ar }}</option>
                        @endforeach
                    </select>

                </div>
                @include('inc.livewire_errors',['property'=>'branch_id'])
            </div>
        @endif
        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6 }} mb-2">
            <div class="form-group">
                <label for='supplier_id'>{{trans('admin.select_supplier')}}</label><span class="text-danger"> *</span>
                <select wire:model='supplier_id' class= 'form-control mt-1 mb-3 @error('supplier_id') is-invalid @enderror'>
                    <option value="">{{ trans('admin.select_supplier') }}</option>
                    @foreach ( App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $supplier )
                        <option value="{{$supplier->id}}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'supplier_id'])
        </div>

        @php
            $mainAssetsAccount = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('name_ar',"الاصول الغير متداولة")->first()->account_num;
            $assetsAccounts = [111,1121 ,1131,1141,115];
            $accounts =  App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('account_num',$assetsAccounts)->get();
        //     foreach($accounts as $account ){
        //         $childAccounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('parent_id',$account->id)->get();
        //     }
        //     // if(Auth::user()->roles_name == 'سوبر-ادمن'){
        //     //     $child_accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('account_num', 'like', '11%')->get();
        //     // } else {
        //     //     $accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('account_num', 'like', '11%')
        //     //     ->where('branch_id' , Auth::user()->branch_id)->get();
        //     // }
        @endphp
        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6 }} mb-2">
            <div class="form-group">
                <label for='parent_parent_account_id'>إختر الحساب الأب التابع له  الأصل</label><span class="text-danger"> *</span>
                <select wire:model='parent_parent_account_id' class= 'form-control mt-1 mb-3 @error('parent_parent_account_id') is-invalid @enderror'>
                    <option value="">إختر الحساب الأب</option>

                    @foreach ( $accounts as $account )
                        <option value="{{$account->id}}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'parent_parent_account_id'])
        </div>


        <div class="col-{{ $payment_type == "by_check" ? '4':'12' }}  mb-2">
            <div class="form-group">
                <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                <select wire:model.live="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                    <option>{{trans('admin.select_payment_type')}}</option>
                    <option value="cash">دفع كامل المبلغ نقدا</option>
                    <option value="by_check">دفع كامل المبلغ بشيك</option>
                    <option value="by_installments">اجل</option>
                </select>
                @include('inc.livewire_errors', ['property' => 'payment_type'])
            </div>
        </div>
        @if($payment_type == "by_check")
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for="payment_type">إختر البنك</label><span class="text-danger">*</span>
                    <select wire:model="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                        <option value="">إختر البنك</option>
                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach

                    </select>
                    @include('inc.livewire_errors', ['property' => 'bank_id'])
                </div>
            </div>
            <div class="col-4 mb-2">
                <div class="form-group">
                    <label for="check_num">رقم الشيك</label>
                    <input type="text" wire:model="check_num" class="form-control @error('check_num') is-invalid @enderror" placeholder="رقم الشيك">
                    @include('inc.livewire_errors', ['property' => 'check_num'])
                </div>
            </div>
        @endif


    </div> --}}


</x-update-modal-component>
