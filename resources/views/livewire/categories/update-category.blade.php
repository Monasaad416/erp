<x-update-modal-component title="{{trans('admin.edit_category')}}">
     @php
    $categories = App\Models\Category::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
    ->where('is_active',1)->get();
 @endphp
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
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='description_ar'>{{trans('admin.description_ar')}}</label>
            <textarea wire:model='description_ar' class= 'form-control mt-1 mb-3 @error('description_ar') is-invalid @enderror' placeholder = "{{trans('admin.description_ar')}}"></textarea>
        </div>
        @include('inc.livewire_errors',['property'=>'description_ar'])
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='description_en'>{{trans('admin.description_en')}}</label>
            <textarea wire:model='description_en' class= 'form-control mt-1 mb-3 @error('description_en') is-invalid @enderror' placeholder = "{{trans('admin.description_en')}}"></textarea>
        </div>
        @include('inc.livewire_errors',['property'=>'description_en'])
    </div>

    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='parent_id'>{{ trans('admin.parent_category') }}</label>
            <select wire:model="parent_id" class="form-control">
                <option value="">{{trans('admin.select_category')}}</option>
                @foreach ($categories as $category )
                    <option value="{{$category->id}}" wire:key="category-{{$category->id}}" {{$parent_id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>

        </div>
        @include('inc.livewire_errors',['property'=>'parent_id'])
    </div>

    {{-- <div class="col-12 mb-2">
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
</x-update-modal-component>
