<x-create-modal-component title="{{trans('admin.create_supplier')}}">
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

        <div class="col-{{ Auth::user()->roles_name =='سوبر-ادمن' ? 4:6 }} mb-2">
            <div class="form-group">
                <label for='phone'>{{trans('admin.phone')}}</label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = "{{trans('admin.phone')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'phone'])
        </div>
        <div class="col-{{ Auth::user()->roles_name =='سوبر-ادمن' ? 4:6 }} mb-2">
            <div class="form-group">
                <label for='tax_num'>{{trans('admin.tax_num')}}</label>
                <input type="text" wire:model='tax_num' class= 'form-control mt-1 mb-3 @error('tax_num') is-invalid @enderror' placeholder = "{{trans('admin.tax_num')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'tax_num'])
        </div>
        @if(Auth::user()->roles_name == 'سوبر-ادمن' )
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch_id'>الفرع</label>
                <select wire:model='branch_id' class= 'form-control mt-1 mb-3 @error('branch_id') is-invalid @enderror'>
                    <option value="">إختر الفرع</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'branch_id'])
        </div>
        @endif
    </div>

</x-create-modal-component>
