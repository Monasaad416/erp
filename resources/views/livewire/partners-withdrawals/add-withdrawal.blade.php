<x-create-modal-component title="إضافة شريك">
    <div class="row">
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='partner_id'>الشريك</label><span class="text-danger"> *</span>
                <select wire:model='partner_id' class= 'form-control mt-1 mb-3 @error('partner_id') is-invalid @enderror'>
                    <option value="">إختر الشريك</option>
                    @foreach (App\Models\Partner::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $partner )
                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'partner_id'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='amount'>مبلغ السحب</label>
                <input type="number" min=0 step="any" wire:model='amount' class= 'form-control mt-1 mb-3 @error('amount') is-invalid @enderror' placeholder = "مبلغ السحب">
            </div>
            @include('inc.livewire_errors',['property'=>'amount'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='date'>تاريخ السحب</label>
                <input type="date" wire:model='date' class= 'form-control mt-1 mb-3 @error('date') is-invalid @enderror' placeholder = "تاريخ السحب">
            </div>
            @include('inc.livewire_errors',['property'=>'date'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='type'>نوع المسحوبات</label><span class="text-danger"> *</span>
                <select wire:model='type' class= 'form-control mt-1 mb-3 @error('type') is-invalid @enderror'>
                    <option value="">إختر السبب</option>
                    <option value="راتب">راتب للشريك</option>
                    <option value="ارباح">من ارباح الشريك</option>
                    <option value='من رأس المال'>من اصل رأس مال الشريك</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'type'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='sourcable_id'>مصدر المسحوبات</label><span class="text-danger"> *</span>
                <select wire:model.live='sourcable_id' class= 'form-control mt-1 mb-3 @error('sourcable_id') is-invalid @enderror'>
                    <option value="">إختر مصدر السحب</option>
                    <option value="treasury">خزينة</option>
                    <option value="bank">بنك</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'sourcable_id'])
        </div>
        @if($sourcable_id == "treasury") 
            <div class="col-6 mb-2">
                <div class="form-group">
                    <label for='treasury_id'>إختر الخزينة</label><span class="text-danger"> *</span>
                    <select wire:model='treasury_id' class= 'form-control mt-1 mb-3 @error('treasury_id') is-invalid @enderror'>
                        <option value="">إختر الخزينة</option>
                        @foreach (App\Models\Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $treasury )
                            <option value="{{ $treasury->id }}">{{ $treasury->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'treasury_id'])
            </div>
        @elseif($sourcable_id == "bank") 
            <div class="col-6 mb-2">
                <div class="form-group">
                    <label for='bank_id'>إختر البنك</label><span class="text-danger"> *</span>
                    <select wire:model='bank_id' class= 'form-control mt-1 mb-3 @error('bank_id') is-invalid @enderror'>
                        <option value="">إختر البنك</option>
                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank )
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'bank_id'])
            </div>
        @endif

</x-create-modal-component>
