<x-update-modal-component title="{{trans('admin.edit_account')}}">
    @php
        $account_types = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();

        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();

        $accounts = App\Models\Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->where('is_parent',1)->get();
    @endphp
    <div class="row">
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='name_ar'>{{trans('admin.name_ar')}}</label>
                <input type="text" wire:model='name_ar' class= 'form-control mt-1 mb-3 @error('name_ar') is-invalid @enderror' placeholder = "{{trans('admin.name_ar')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_ar'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='name_en'>{{trans('admin.name_en')}}</label>
                <input type="text" wire:model='name_en' class= 'form-control mt-1 mb-3 @error('name_en') is-invalid @enderror' placeholder = "{{trans('admin.name_en')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'name_en'])
        </div>


        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='account_num'>{{trans('admin.account_num')}}</label>
                <input type="number" min=0 wire:model='account_num'  class= 'form-control mt-1 mb-3 @error('account_num') is-invalid @enderror' placeholder = "{{trans('admin.account_num')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'account_num'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='start_balance'>{{trans('admin.start_balance')}}</label>
                <input type="number" min="0" step="any" wire:model='start_balance' class= 'form-control mt-1 mb-3 @error('start_balance') is-invalid @enderror' placeholder = "{{trans('admin.start_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'start_balance'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='current_balance'>{{trans('admin.current_balance')}}</label>
                <input type="number" min="0" step="any" wire:model='current_balance' class= 'form-control mt-1 mb-3 @error('current_balance') is-invalid @enderror' placeholder = "{{trans('admin.current_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'current_balance'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='account_type_id'>{{trans('admin.account_type')}} </label>
                <select wire:model='account_type_id' class= 'form-control mt-1 mb-3 @error('account_type_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_account_type')}}</option>
                    @foreach ($account_types as $account_type)
                        <option value="{{ $account_type->id }}" wire::key="account_type-{{ $account_type->id }}">{{ $account_type->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'account_type_id'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='parent_id'>{{trans('admin.parent_account')}} </label>
                <select wire:model='parent_id' class= 'form-control mt-1 mb-3 @error('parent_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_parent_account')}}</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" wire::key="account-{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'parent_id'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='branch_id'>{{trans('admin.branch')}} </label>
                <select wire:model='branch_id' class= 'form-control mt-1 mb-3 @error('branch_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_branch')}}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" wire::key="branch-{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'branch_id'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='notes'>{{trans('admin.notes')}}</label>
                <input type="text" wire:model='notes' class= 'form-control mt-1 mb-3 @error('notes') is-invalid @enderror' placeholder = "{{trans('admin.notes')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'notes'])
        </div>



        <div class="form-group clearfix">
            <div class="d-inline">
                <input type="checkbox" {{$is_parent == 1 ? 'checked' : ''}} wire:model="is_parent">
                <label>
                {{ trans('admin.is_parent_account') }}
                </label>
                <br>
                <small class="text-muted">
                    {{ trans('admin.is_parent_example') }}
                </small>
            </div>
        </div>
            
    </div>
</x-update-modal-component>
