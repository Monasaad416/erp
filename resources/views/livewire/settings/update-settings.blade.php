<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
  
                    <div class="row mt-3">

                        {{-- <div class="col-4">
                            <div class="form-group">
                                <label for='address'>عنوان المتجر(المستخدم في طباعة الفواتير)</label><span class="text-danger">*</span>
                                <input type='text' wire:model='address'  class= 'form-control mt-1 mb-3 @error('address') is-invalid @enderror' placeholder = "عنوان المتجر">
                                @include('inc.livewire_errors',['property'=>'address'])
                            </div>
                        </div> --}}
                        <div class="col-4">
                            <div class="form-group">
                                <label for='vat'> الضريبة </label><span class="text-danger">*</span> <span class="text-muted" >(مثال 0.15)</span>
                                <input type='text' wire:model='vat'  class= 'form-control mt-1 mb-3 @error('vat') is-invalid @enderror' placeholder = "نسبة الضريبة">
                                @include('inc.livewire_errors',['property'=>'vat'])
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='percentage_for_pos'>نسبة الفاتورة لحساب نقاط العميل  %</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='percentage_for_pos'  class= 'form-control mt-1 mb-3 @error('percentage_for_pos') is-invalid @enderror' placeholder = "نسبة الفاتورة لحساب نقاط العميل">
                                @include('inc.livewire_errors',['property'=>'percentage_for_pos'])
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='point_price'>تكلفة النقطة(ريال) </label><span class="text-danger"> *</span>
                                <input type='text' wire:model='point_price' class= 'form-control mt-1 mb-3 @error('point_price') is-invalid @enderror' placeholder = "تكلفة  النقطة">
                                @include('inc.livewire_errors',['property'=>'point_price'])
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <div class="form-group">
                                <label for='min_exchange_pos'>اقل عدد نقاط للاستبدال</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='min_exchange_pos'  class= 'form-control mt-1 mb-3 @error('min_exchange_pos') is-invalid @enderror' placeholder = "أقل عدد نقاط للاستبدال">
                                @include('inc.livewire_errors',['property'=>'min_exchange_pos'])
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='max_exchange_pos'>اقصي عدد نقاط للاستبدال</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='max_exchange_pos'  class= 'form-control mt-1 mb-3 @error('max_exchange_pos') is-invalid @enderror' placeholder = "أقصي عدد نقاط للاستبدال">
                                @include('inc.livewire_errors',['property'=>'max_exchange_pos'])
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for='expiry_days'>عدد أيام صلاحية نقاط العميل</label><span class="text-danger"> *</span>
                                <input type='text' wire:model='expiry_days' class= 'form-control mt-1 mb-3 @error('expiry_days') is-invalid @enderror' placeholder = "عدد أيام صلاحية نقاط العميل">
                                @include('inc.livewire_errors',['property'=>'expiry_days'])
                            </div>
                        </div>    
                    </div>
                    <div class="text-center">
                        <button type="button" wire:click="updatSettings" class="btn btn-secondary">
                            <span wire:loading wire:target="updatSettings">
                                <div class="text-center">
                                    <div class="spinner-border text-warning" role="status">
                                        <span class="sr-only">جاري التحميل...</span>
                                    </div>
                                </div>
                            </span>
                            <span wire:loading.remove>{{ trans('admin.edit') }}</span>
                        </button>
                    </div>
    
            </div>
        </div>
    </div>
</div>
