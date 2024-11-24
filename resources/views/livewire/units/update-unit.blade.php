<x-update-modal-component title="{{trans('admin.edit_unit')}}">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='name_ar'>{{trans('admin.name_ar')}}</label>
            <input type="text" wire:model='name_ar' class= 'form-control mt-1 mb-3 @error('name_ar') is-invalid @enderror' placeholder = "{{trans('admin.name_ar')}}">
        </div>
        @include('inc.livewire_errors',['property'=>'name_ar'])
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='name_en'>{{trans('admin.name_en')}}</label>
            <input type="text" wire:model='name_en' class= 'form-control mt-1 mb-3 @error('name_en') is-invalid @enderror' placeholder = "{{trans('admin.name_en')}}">
        </div>
        @include('inc.livewire_errors',['property'=>'name_en'])
    </div>
</x-update-modal-component>
