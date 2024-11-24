<x-create-modal-component title="إضافة  ميزان مراجعة">
    @php
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
    @endphp
    <div class="row">
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='start_date' class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'start_date'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='end_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='end_date' class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'end_date'])
        </div>
    </div>

</x-create-modal-component>
