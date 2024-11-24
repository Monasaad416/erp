<x-update-modal-component title="تعديل العرض">
    @php
        $products = App\Models\Product::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    @endphp
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <style>
            .select2-container--default.select2-container--focus .select2-selection--multiple {
                height: 50px !important;
            }
        </style>
    @endpush



    <div class="row">
        <div class="col-4 mb-2">
            <div class="form-group" >
                <label for='product_id'>المنتج </label><span class="text-danger">*</span>
                <select wire:model='product_id' disabled class='form-control select2 mt-1 mb-3 @error('product_id') is-invalid @enderror'>
                    <option value="">إختر المنتج</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" wire:key="product-{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'product_id'])
        </div>
       <div class="col-2 mb-2">
            <div class="form-group">
                <label for='percentage'>نسبة الخصم  %</label><span class="text-danger">*</span>
                <input wire:model='percentage' type="number" min="0"  class= 'form-control mt-1 mb-3 @error('percentage') is-invalid @enderror'>
            </div>
            @include('inc.livewire_errors',['property'=>'percentage'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for='price'> سعر العرض</label><span class="text-danger">*</span>
                <input wire:model='price' type="number" min="0" step="any" class='form-control mt-1 mb-3 @error('price') is-invalid @enderror'>
            </div>
            @include('inc.livewire_errors',['property'=>'price'])
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for="from_date">من تاريخ:</label><span class="text-danger">*</span>
                <input type="date" wire:model.defer="from_date" class="form-control @error('from_date') is-invalid @enderror" placeholder="من تاريخ:">
                @include('inc.livewire_errors', ['property' => 'from_date'])
            </div>
        </div>
        <div class="col-2 mb-2">
            <div class="form-group">
                <label for="to_date">إلي تاريخ:</label><span class="text-danger">*</span>
                <input type="date" wire:model.live="to_date" class="form-control @error('to_date') is-invalid @enderror" placeholder="إلي تاريخ:">
                @include('inc.livewire_errors', ['property' => 'to_date'])
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='description'>الوصف</label><span class="text-danger"> *</span>
                <textarea wire:model='description' class= 'form-control mt-1 mb-3
                @error('description') is-invalid @enderror' placeholder = "الوصف"></textarea>
            </div>
            @include('inc.livewire_errors',['property'=>'description'])
        </div>





        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='branches_ids'>الفروع </label><span class="text-danger">*</span>
                <select wire:model='branches_ids' multiple class='form-control select2bs4 mt-1 mb-3 @error('branches_ids') is-invalid @enderror'>
                    <option value="">إختر الفرع</option>
                    @foreach ($branches as $branch)
                      <option value="{{ $branch->id }}" @if(in_array($branch->id, $branchesIds ?? [])) selected @endif wire:key="branch-{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'branches_ids'])
        </div>
    </div>
    <script>
        window.addEventListener('newProduct', event => {
            $(document).ready(function () {
                console.log("kkd");
                $('.select2').select2();
                $('.select2').on('change', function (e) {

                    var data = $(this).select2("val");
                    console.log(data);
                    @this.set('product_id', data);
                });
            });
        });
    </script>

</x-update-modal-component>
