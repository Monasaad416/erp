<x-create-modal-component title="إضافة مركز تكلفة">
    @php
        $centers = App\Models\CostCenter::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','is_parent','parent_id')->get();
    @endphp
    <div class="row">
    <div class="col-6 mb-2">
        <div class="form-group">
            <label for='name_ar'>{{trans('admin.name_ar')}}</label><span class="text-danger"> *</span>
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

    <div class="col-4 mb-2">
        <div class="form-group">
            <label for='parent_id'>المركز الرئيسي</label>
            <select wire:model="parent_id" class="form-control">
                <option value="">إختر المركز</option>
                @foreach ($centers as $center )
                    <option value="{{$center->id}}" wire:key="category-{{$center->id}}">{{$center->name}}</option>
                @endforeach
            </select>

        </div>
        @include('inc.livewire_errors',['property'=>'parent_id'])
    </div>


    <div class="col-4 mb-2">
        <div class="form-group">
            <label for='code'>الكود</label>
            <input type="text" wire:model='code' readonly class= 'form-control mt-1 mb-3 @error('code') is-invalid @enderror' placeholder = "الكود">
        </div>
        @include('inc.livewire_errors',['property'=>'code'])
    </div>



    <div class="col-4 mb-2">
         <label for='parent_id'> حساب رئيسي؟</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
            <input type="checkbox" wire:model="is_parent">
            </div>
        </div>
        <input type="text" class="form-control" aria-label="Text input with checkbox"  value="حساب رئيسي" readonly>
        </div>
        @include('inc.livewire_errors',['property'=>'is_parent'])
    </div>
    </div>
</x-create-modal-component>
