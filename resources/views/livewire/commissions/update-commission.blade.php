<x-update-modal-component title="{{trans('admin.edit_product')}}">
    @php
        $products = App\Models\Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    @endphp

    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <style>
            .add_onother {
                top: 36px;
                left: 0;
            }
        </style>
    @endpush
    <div class="row">

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='product_id'>المنتج </label><span class="text-danger">*</span>
                <select wire:model='product_id' disabled class='form-control select2 mt-1 mb-3 @error('product_id') is-invalid @enderror'>
                    <option value="">إختر المنتج</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" wire::key="product-{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'product_id'])
        </div>
       <div class="col-6 mb-2">
            <div class="form-group">
                <label for='commission_rate'>نسبة العمولة  %</label><span class="text-danger">*</span>
                <input wire:model='commission_rate' type="number" min="0"  class= 'form-control mt-1 mb-3 @error('commission_rate') is-invalid @enderror'>
            </div>
            @include('inc.livewire_errors',['property'=>'commission_rate'])
        </div>

    </div>

</x-update-modal-component>

