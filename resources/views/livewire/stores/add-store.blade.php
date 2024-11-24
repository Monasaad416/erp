<x-create-modal-component title="إضافة مخزن">
    @php
        $treasuries = App\Models\Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
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

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='address_ar'>{{trans('admin.address_ar')}}</label><span class="text-danger"> *</span>
                <input type="text" wire:model='address_ar' class= 'form-control mt-1 mb-3 @error('address_ar') is-invalid @enderror' placeholder = "{{trans('admin.address_ar')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'address_ar'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='address_en'>{{trans('admin.address_en')}}</label>
                <input type="text" wire:model='address_en' class= 'form-control mt-1 mb-3 @error('address_en') is-invalid @enderror' placeholder = "{{trans('admin.address_en')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'address_en'])
        </div>

        <div class="col-6 mt-4">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox"  wire:model="is_parent">
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="مخزن رئيسي" readonly>
            </div>
            @include('inc.livewire_errors',['property'=>'is_parent'])
        </div>


        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='branch_id'> الفرع</label>
                <select wire:model="branch_id" class="form-control">
                    <option value="">إختر الفرع</option>
                    @foreach ($branches as $branch )
                        <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                    @endforeach
                </select>

            </div>
            @include('inc.livewire_errors',['property'=>'branch_id'])
        </div>


    </div>

</x-create-modal-component>
