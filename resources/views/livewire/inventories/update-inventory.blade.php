<x-update-modal-component title="تعديل المخزون">
    <div class="row">
         <div class="col-6 mb-2">
            <div class="form-group">
                <label for='latest_purchase_price'>أخر سعر شراء</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='latest_purchase_price' class= 'form-control mt-1 mb-3 @error('latest_purchase_price') is-invalid @enderror' placeholder = "أخر سعر شراء">
            </div>
            @include('inc.livewire_errors',['property'=>'latest_purchase_price'])
        </div>
        <div class="col-6 mb-2">
            <div class="form-group">
                <label for='main_branch_inv'>رصيد المخزن الرئيسي</label>
                <input type="number" min="0" step="any" wire:model='main_branch_inv' class= 'form-control mt-1 mb-3 @error('main_branch_inv') is-invalid @enderror' placeholder = "مخزون المخزن الرئيسي">
            </div>
            @include('inc.livewire_errors',['property'=>'main_branch_inv'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch1_inv'>رصيد فرع1 </label>
                <input type="number" min="0" step="any" wire:model='branch1_inv' class= 'form-control mt-1 mb-3 @error('branch1_inv') is-invalid @enderror' placeholder = "مخزون فرع 1">
            </div>
            @include('inc.livewire_errors',['property'=>'branch1_inv'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch2_inv'>رصيد فرع2 </label>
                <input type="number" min="0" step="any" wire:model='branch2_inv' class= 'form-control mt-1 mb-3 @error('branch2_inv') is-invalid @enderror' placeholder = "مخزون فرع 2">
            </div>
            @include('inc.livewire_errors',['property'=>'branch2_inv'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch3_inv'>رصيد فرع3 </label>
                <input type="number" min="0" step="any" wire:model='branch3_inv' class= 'form-control mt-1 mb-3 @error('branch3_inv') is-invalid @enderror' placeholder = "مخزون فرع 3">
            </div>
            @include('inc.livewire_errors',['property'=>'branch3_inv'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch4_inv'>رصيد فرع4 </label>
                <input type="number" min="0" step="any" wire:model='branch4_inv' class= 'form-control mt-1 mb-3 @error('branch4_inv') is-invalid @enderror' placeholder = "مخزون فرع 4">
            </div>
            @include('inc.livewire_errors',['property'=>'branch4_inv'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch5_inv'>رصيد فرع5 </label>
                <input type="number" min="0" step="any" wire:model='branch5_inv' class= 'form-control mt-1 mb-3 @error('branch5_inv') is-invalid @enderror' placeholder = "مخزون فرع 5">
            </div>
            @include('inc.livewire_errors',['property'=>'branch5_inv'])
        </div>
                <div class="col-4 mb-2">
            <div class="form-group">
                <label for='branch6_inv'>رصيد فرع6 </label>
                <input type="number" min="0" step="any" wire:model='branch6_inv' class= 'form-control mt-1 mb-3 @error('branch6_inv') is-invalid @enderror' placeholder = "مخزون فرع 6">
            </div>
            @include('inc.livewire_errors',['property'=>'branch6_inv'])
        </div>

    </div>


</x-update-modal-component>
