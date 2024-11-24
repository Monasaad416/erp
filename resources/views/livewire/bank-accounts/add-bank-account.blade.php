<x-create-modal-component title="إضافة حساب بنكي">
    @php
        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $users = App\Models\User::get();
    @endphp
    <div class="row">

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='accountable_type'>الحساب خاص ب :</label><span class="text-danger"> *</span>
                <select wire:model.live='accountable_type' class= 'form-control mb-3 @error('accountable_type') is-invalid @enderror'>
                    <option value="">إختر </option>
                    <option value="supplier">مورد</option>
                    <option value="user">موظف</option>
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'accountable_type'])
        </div>

        @if($accountable_type == 'supplier')
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for='supplier_id'>الموردين</label>
                    <select wire:model='supplier_id' class= 'form-control mt-1 mb-3 @error('supplier_id') is-invalid @enderror'>
                        <option value="">إختر المورد</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" wire::key="supplier-{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'supplier_id'])
            </div>
        @elseif($accountable_type == 'user')
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for='user_id'>الموظفين</label>
                    <select wire:model='user_id' class= 'form-control mb-3 @error('user_id') is-invalid @enderror'>
                        <option value="">إختر الموظف</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" wire::key="user-{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'user_id'])
            </div>
        @endif
        <div class="col-3 mb-2">
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

        
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='bank_account_num'>رقم الحساب البنكي :</label><span class="text-danger"> *</span>
                <input type="text" wire:model.live='bank_account_num' class= 'form-control mb-3 @error('bank_account_num') is-invalid @enderror'>
            </div>
            @include('inc.livewire_errors',['property'=>'bank_account_num'])
        </div>
    </div>
</x-create-modal-component>

