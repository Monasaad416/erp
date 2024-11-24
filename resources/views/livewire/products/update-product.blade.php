<x-update-modal-component title="{{trans('admin.edit_product')}}">

    @php
        $categories = App\Models\Category::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
        ->where('is_active',1)->get();
        $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    @endphp

    <style>
        .add_onother {
            top: 36px;
            left: 0;
        }
    </style>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="form-group">
                <label for="product_codes">{{ trans('admin.product_code') }}</label><span class="text-danger">*</span>
                @foreach ($product_codes as $index => $code)
                    <input type="text" id="codeInput{{ $index }}" wire:model="product_codes.{{ $index }}" wire:change.live="adjustCode({{$index}})" wire:keydown.enter.prevent
                     class="position relative form-control mt-1 mb-3
                     @error('product_codes.'.$index) is-invalid @enderror" placeholder="{{ trans('admin.product_code') }}"
                     >
                    <button class="btn btn-primary add_onother"
                    title="{{ trans('admin.add_code') }}" wire:click.prevent="addOnotherCode({{ $index }})">+</button>
                    <button class="btn btn-danger removeCode" wire:model="removeButtons.{{ $index }}" id="remove{{ $index }}"
                    title="{{ trans('admin.remove_code') }}" wire:click.prevent="removeCode({{ $index }})">-</button>

                @endforeach
            </div>

            @foreach ($product_codes as $index => $code)
                @include('inc.livewire_errors', ['property' => 'product_codes.'.$index])
            @endforeach
        </div>

        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='name_ar'>{{trans('admin.name_ar')}}</label>
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
                <label for='unit_id'>{{trans('admin.unit')}} </label>
                <select wire:model='unit_id' class= 'form-control mt-1 mb-3 @error('unit_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_unit')}}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" wire::key="unit-{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'unit_id'])
        </div>
        <div class="col-3 mb-2">
            <div class="form-group">
                <label for='sale_price'>{{trans('admin.sale_price')}}</label>
                <input type="number" min="0" step="any" wire:model='sale_price' class= 'form-control mt-1 mb-3 @error('sale_price') is-invalid @enderror' placeholder = "{{trans('admin.sale_price')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'sale_price'])
        </div>
        {{-- <div class="col-3 mb-2">
            <div class="form-group">
                <label for='discount_price'>{{trans('admin.discount_price')}}</label>
                <input type="number" min="0" step="any" wire:model='discount_price' class= 'form-control mt-1 mb-3 @error('discount_price') is-invalid @enderror' placeholder = "{{trans('admin.discount_price')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'discount_price'])
        </div> --}}

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='supplier_id'>{{trans('admin.supplier')}} </label>
                <select wire:model='supplier_id' class= 'form-control mt-1 mb-3 @error('supplier_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_supplier')}}</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" wire::key="supplier-{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'supplier_id'])
        </div>

        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='category_id'>{{trans('admin.category')}} </label>
                <select wire:model='category_id' class= 'form-control mt-1 mb-3 @error('category_id') is-invalid @enderror'>
                    <option value="">{{trans('admin.select_category')}}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" wire::key="cat-{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'category_id'])
        </div>

        <div class="col-8 mb-2">
            <div class="form-group">
                <label for='description'>{{trans('admin.description')}}</label>
                <input type="text" wire:model='description' class= 'form-control mt-1 mb-3 @error('description') is-invalid @enderror' placeholder = "{{trans('admin.description')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'description'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='initial_balance'>{{trans('admin.initial_balance')}}</label>
                <input type="number" min="0" step="any" wire:model='initial_balance' class= 'form-control mt-1 mb-3 @error('initial_balance') is-invalid @enderror' placeholder = "{{trans('admin.initial_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'initial_balance'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='inventory_balance'>{{trans('admin.inventory_balance')}}</label>
                <input type="number" min="0" step="any" wire:model='inventory_balance' class= 'form-control mt-1 mb-3 @error('inventory_balance') is-invalid @enderror' placeholder = "{{trans('admin.inventory_balance')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'inventory_balance'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='latest_purchase_price'>{{trans('admin.latest_purchase_price')}}</label>
                <input type="number" min="0" step="any" wire:model='latest_purchase_price' class= 'form-control mt-1 mb-3 @error('latest_purchase_price') is-invalid @enderror' placeholder = "{{trans('admin.latest_purchase_price')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'latest_purchase_price'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='alert_main_branch'>تنبيه نقص الكمية بالمركز الرئيسي</label>
                <input type="number" min="0" step="any" wire:model='alert_main_branch' class= 'form-control mt-1 mb-3 @error('alert_main_branch') is-invalid @enderror' placeholder = "الكمية التي يتم بعدها التنبيه بالمركز الرئيسي">
            </div>
            @include('inc.livewire_errors',['property'=>'alert_main_branch'])
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='alert_branch'>تنبية نقص الكمية في الفرع</label>
                <input type="number" min="0" step="any" wire:model='alert_branch' class= 'form-control mt-1 mb-3 @error('alert_branch') is-invalid @enderror' placeholder = "الكمية التي يتم بعدها التنبيه بالفرع ">
            </div>
            @include('inc.livewire_errors',['property'=>'alert_branch'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='manufactured_date'>{{trans('admin.manufactured_date')}}</label>
                <input type="date" wire:model='manufactured_date' class= 'form-control mt-1 mb-3 @error('manufactured_date') is-invalid @enderror' placeholder = "{{trans('admin.manufactured_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'manufactured_date'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='expiry_date'>{{trans('admin.expiry_date')}}</label>
                <input type="date" wire:model='expiry_date' class= 'form-control mt-1 mb-3 @error('expiry_date') is-invalid @enderror' placeholder = "{{trans('admin.expiry_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'expiry_date'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='import_date'>{{trans('admin.import_date')}}</label>
                <input type="date" wire:model='import_date' class= 'form-control mt-1 mb-3 @error('import_date') is-invalid @enderror' placeholder = "{{trans('admin.import_date')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'import_date'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='size'>{{trans('admin.size')}}</label>
                <input type="number" min="0" step="any" wire:model='size' class= 'form-control mt-1 mb-3 @error('size') is-invalid @enderror' placeholder = "{{trans('admin.size')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'size'])
        </div>

        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='max_dose'>{{trans('admin.max_dose')}}</label>
                <input type="number" min="0" step="any" wire:model='max_dose' class= 'form-control mt-1 mb-3 @error('max_dose') is-invalid @enderror' placeholder = "{{trans('admin.max_dose')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'max_dose'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='gtin'>{{trans('admin.gtin')}}</label>
                <input type="text" wire:model='gtin' class= 'form-control mt-1 mb-3 @error('gtin') is-invalid @enderror' placeholder = "{{trans('admin.gtin')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'gtin'])
        </div>

        {{-- <div class="col-3 mb-2">
            <div class="form-group">
                <label for='commission_rate'>{{trans('admin.commission_rate')}} %</label>
                <input type="number" min="0" step="any" wire:model='commission_rate' class= 'form-control mt-1 mb-3 @error('commission_rate') is-invalid @enderror' placeholder = "{{trans('admin.commission_rate')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'commission_rate'])
        </div> --}}

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="fraction" {{ $fraction == 1 ? 'checked' : '' }}>
                </div>
            </div>
            <input type="text" class="form-control"  value="{{trans('admin.fraction_available')}}" readonly>
            </div>
            @include('inc.livewire_errors',['property'=>'fraction'])
        </div>

        <div class="col-6 mb-2">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" wire:model="taxes" {{ $taxes == 1 ? 'checked' : '' }}>
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"  value="{{trans('admin.taxable')}}" readonly>
            </div>
            @include('inc.livewire_errors',['property'=>'taxes'])
        </div>
    </div>

</x-update-modal-component>
