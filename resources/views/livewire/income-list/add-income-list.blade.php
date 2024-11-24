<x-create-modal-component title="إضافة/تعديل قائمة الدخل">
    @php
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
    @endphp
    <div class="row">
        @if(Auth::user()->roles_name == 'سوبر-ادمن')
        <div class="col-4 mb-2">
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
        @endif

        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6 }} mb-2">
            <div class="form-group">
                <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='start_date' class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'start_date'])
        </div>

        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 :6 }} mb-2">
            <div class="form-group">
                <label for='end_date'>من تاريخ</label><span class="text-danger"> *</span>
                <input type="date" readonly wire:model='end_date' class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'end_date'])
        </div>



    </div>

</x-create-modal-component>
