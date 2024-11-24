<x-update-modal-component title="{{trans('admin.edit_supplier')}}">
  <div class="row">
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='name_ar'>{{trans('admin.name_ar')}}</label><span class="text-danger"> *</span>
                <input type="text" wire:model='name_ar' class= 'form-control mt-1 mb-3 @error('name_ar') is-invalid @enderror' placeholder = "{{trans('admin.name_ar')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_ar'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='name_en'>{{trans('admin.name_en')}}</label>
                <input type="text" wire:model='name_en' class= 'form-control mt-1 mb-3 @error('name_en') is-invalid @enderror' placeholder = "{{trans('admin.name_en')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_en'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='email'>{{trans('admin.email')}}</label>
                <input type="text" wire:model='email' class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "{{trans('admin.email')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'email'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='address'>{{trans('admin.address')}}</label>
                <input type="text" wire:model='address' class= 'form-control mt-1 mb-3 @error('address') is-invalid @enderror' placeholder = "{{trans('admin.address')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'address'])
        </div>

        {{-- <div class="col-4 mb-2">
            <div class="form-group">
                <label for='balance_state'>{{trans('admin.balance_state')}}</label><span class="text-danger"> *</span>
                <select wire:model='balance_state' class= 'form-control mt-1 mb-3 @error('balance_state') is-invalid @enderror'>
                    <option value="">{{ trans('admin.select_account_status') }}</option>
                    <option value="1"> {{ trans('admin.debit') }}</option> 
                    <option value="2"> {{ trans('admin.credit') }}</option> 
                    <option value="3"> {{ trans('admin.balanced_at_start') }}</option> 
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'balance_state'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='start_balance'>{{trans('admin.start_balance')}}</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='start_balance' class= 'form-control mt-1 mb-3 @error('start_balance') is-invalid @enderror' placeholder = "{{trans('admin.start_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'start_balance'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='current_balance'>{{trans('admin.current_balance')}}</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='current_balance' class= 'form-control mt-1 mb-3 @error('current_balance') is-invalid @enderror' placeholder = "{{trans('admin.current_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'current_balance'])
        </div> --}}
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='phone'>{{trans('admin.phone')}}</label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = "{{trans('admin.phone')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'phone'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='tax_num'>{{trans('admin.tax_num')}}</label>
                <input type="text" wire:model='tax_num' class= 'form-control mt-1 mb-3 @error('tax_num') is-invalid @enderror' placeholder = "{{trans('admin.tax_num')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'tax_num'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='gln'>{{trans('admin.gln')}}</label>
                <input type="text" wire:model='gln' class= 'form-control mt-1 mb-3 @error('gln') is-invalid @enderror' placeholder = "{{trans('admin.gln')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'gln'])
        </div>
    </div>

</x-update-modal-component>
