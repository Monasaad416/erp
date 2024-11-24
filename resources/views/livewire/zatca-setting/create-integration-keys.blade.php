

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row mt-6">
                    <div class="col-6">
                        <div class="form-group">
                            <label for='commercial_register'>السجل التجاري </label><span class="text-danger">*</span>
                            <input type='text' wire:model='commercial_register'  class= 'form-control mt-1 mb-3 @error('commercial_register') is-invalid @enderror' placeholder = "السجل التجاري">
                            @include('inc.livewire_errors',['property'=>'commercial_register'])
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='tax_num'>الرقم الضريبي </label><span class="text-danger">*</span>
                            <input type='text' wire:model='tax_num'  class= 'form-control mt-1 mb-3 @error('tax_num') is-invalid @enderror' placeholder = "الرقم الضريبي">
                            @include('inc.livewire_errors',['property'=>'tax_num'])
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='name'>إسم المتجر(المستخدم في طباعة الفواتير)</label><span class="text-danger">*</span>
                            <input type='text' wire:model='name'  class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = "إسم المتجر">
                            @include('inc.livewire_errors',['property'=>'name'])
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for='otp'>كود التحقق</label><span class="text-danger">*</span>
                            <input type='text' wire:model='otp'  class= 'form-control mt-1 mb-3 @error('otp') is-invalid @enderror' placeholder = "كود التحقق">
                            @include('inc.livewire_errors',['property'=>'otp'])
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" wire:click="update"  class="btn btn-secondary">
                        <span wire:loading wire:target="update">
                            <div class="text-center">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="sr-only">جاري التنفيذ ...</span>
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

