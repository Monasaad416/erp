<x-update-modal-component title="تعديل فرع">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='code'>إسم الفرع</label><span class="text-danger"> *</span>
            <input type="text" wire:model='name' class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = " إسم الفرع">
        </div>
        @include('inc.livewire_errors',['property'=>'name'])
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='code'>كود الفرع</label><span class="text-danger"> *</span>
            <input type="number" min="1" wire:model='code' class= 'form-control mt-1 mb-3 @error('code') is-invalid @enderror' placeholder = " كود الفرع">
        </div>
        @include('inc.livewire_errors',['property'=>'code'])
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='address'>العنوان</label><span class="text-danger"> *</span>
            <input type="text" wire:model='address' class= 'form-control mt-1 mb-3 @error('address') is-invalid @enderror' placeholder = "العنوان">
        </div>
        @include('inc.livewire_errors',['property'=>'address'])
    </div>


      <div class="col-12 mb-2">
        <div class="form-group">
            <label for='phone'>الهاتف</label><span class="text-danger"> *</span>
            <input type="text" wire:model='phone' class= 'form-control mt-1 mb-3 @error('phone') is-invalid @enderror' placeholder = "الهاتف">
        </div>
        @include('inc.livewire_errors',['property'=>'phone'])
    </div>


    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='email'>البريد الإلكتروني</label><span class="text-danger"> *</span>
            <input type="email"  wire:model='email' class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "البريد الإلكتروني ">
        </div>
        @include('inc.livewire_errors',['property'=>'email'])
    </div>
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='is_active'>حالة الفرع</label><span class="text-danger"> *</span>
            <select wire:model='is_active' class= 'form-control mt-1 mb-3 @error('type') is-invalid @enderror'>
                <option value="">--إختر حالة الفرع --</option>
                <option value="0">غير نشط</option>
                <option value="1">نشط</option>
            </select>
        </div>
        @include('inc.livewire_errors',['property'=>'is_active'])
    </div>
</x-update-modal-component>
