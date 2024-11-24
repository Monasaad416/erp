<x-update-modal-component title="تعديل معلومات شريك">
    <div class="row">
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
                <label for='email'>{{trans('admin.email')}}</label>
                <input type="text" wire:model='email' class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "{{trans('admin.email')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'email'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='address'>{{trans('admin.address')}}</label>
                <input type="text" wire:model='address' class= 'form-control mt-1 mb-3 @error('address') is-invalid @enderror' placeholder = "{{trans('admin.address')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'address'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='phone'>{{trans('admin.phone')}}</label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = "{{trans('admin.phone')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'phone'])
        </div>
    </div>


</x-update-modal-component>
