<x-create-modal-component title="{{trans('admin.create_account_type')}}">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='name_ar'>{{trans('admin.name_ar')}}</label><span class="text-danger"> *</span>
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
{{-- 

    <div class="col-12 mb-2">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
            <input type="checkbox"  wire:model="is_active">
            </div>
        </div>
        <input type="text" class="form-control" aria-label="Text input with checkbox"  value="{{trans('admin.activate_category')}}" readonly>
        </div>
        @include('inc.livewire_errors',['property'=>'is_active'])
    </div> --}}
</x-create-modal-component>
