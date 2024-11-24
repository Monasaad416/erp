<x-update-modal-component title="{{trans('admin.edit_branch')}}">
    <div class="row">
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch_num'>{{trans('admin.branch_num')}}</label><span class="text-danger"> *</span>
                <input type="number" min="0" wire:model='branch_num' class= 'form-control mt-1 mb-3 @error('branch_num') is-invalid @enderror' placeholder = "{{trans('admin.branch_num')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'branch_num'])
        </div>
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
                <input type="email" wire:model='email' class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "{{trans('admin.email')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'email'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='gln'>{{trans('admin.gln')}}</label>
                <input type="text" wire:model='gln' class= 'form-control mt-1 mb-3 @error('gln') is-invalid @enderror' placeholder = "{{trans('admin.gln')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'gln'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='phone'>{{trans('admin.phone')}}</label>
                <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = "{{trans('admin.phone')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'phone'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='building_number'>رقم المبني</label><span class="text-danger"> *</span>
                <input type="text" wire:model='building_number' class= 'form-control mt-1 mb-3 @error('building_number') is-invalid @enderror' placeholder = "رقم المبني">
            </div>
            @include('inc.livewire_errors',['property'=>'building_number'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='plot_identification'>الرقم الفرعي</label><span class="text-danger"> *</span>
                <input type="text" wire:model='plot_identification' class= 'form-control mt-1 mb-3 @error('plot_identification') is-invalid @enderror' placeholder = "الرقم الفرعي">
            </div>
            @include('inc.livewire_errors',['property'=>'plot_identification'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='postal_code'>الرقم البريدي</label><span class="text-danger"> *</span>
                <input type="text" wire:model='postal_code' class= 'form-control mt-1 mb-3 @error('postal_code') is-invalid @enderror' placeholder = "الرقم البريدي">
            </div>
            @include('inc.livewire_errors',['property'=>'postal_code'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='street_name_ar'>إسم الشارع باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='street_name_ar' class= 'form-control mt-1 mb-3 @error('street_name_ar') is-invalid @enderror' placeholder = "إسم الشارع باللغة العربية">
            </div>
            @include('inc.livewire_errors',['property'=>'street_name_ar'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='street_name_en'>إسم الشارع باللغة الإنجليزية</label>
                <input wire:model='street_name_en' class= 'form-control mt-1 mb-3 @error('street_name_en') is-invalid @enderror' placeholder = "إسم الشارع باللغة الإنجليزية">
            </div>
            @include('inc.livewire_errors',['property'=>'street_name_en'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='region_ar'>إسم المنطقة باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='region_ar' class= 'form-control mt-1 mb-3 @error('region_ar') is-invalid @enderror' placeholder = "إسم المنطقة باللغة العربية">
            </div>
            @include('inc.livewire_errors',['property'=>'region_ar'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='region_en'>إسم المنطقة باللغة الإنجليزية</label>
                <input wire:model='region_en' class= 'form-control mt-1 mb-3 @error('region_en') is-invalid @enderror' placeholder = "إسم الشارع باللغة الإنجليزية">
            </div>
            @include('inc.livewire_errors',['property'=>'region_en'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='city_ar'>إسم المدينة باللغة العربية</label><span class="text-danger"> *</span>
                <input type="text" wire:model='city_ar' class= 'form-control mt-1 mb-3 @error('city_ar') is-invalid @enderror' placeholder = "إسم المدينة باللغة العربية">
            </div>
            @include('inc.livewire_errors',['property'=>'city_ar'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='city_en'>إسم المدينة باللغة الإنجليزية</label>
                <input wire:model='city_en' class= 'form-control mt-1 mb-3 @error('city_en') is-invalid @enderror' placeholder = "إسم المدينة باللغة الإنجليزية">
            </div>
            @include('inc.livewire_errors',['property'=>'city_en'])
        </div>
    </div>
</x-update-modal-component>
