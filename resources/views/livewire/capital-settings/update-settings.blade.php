<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                    <div class="row mt-3">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for='parent_id'>إختر طريقة التقسيم</label> <span class="text-danger"> *</span>
                                <select wire:model="parent_id" class="form-control">
                                    <option value="">---</option>
                                    <option value="percentage" wire:key="type-1">نسبة مئوية</option>
                                    <option value="amount" wire:key="type-2">مبلغ(ريال)</option>
                                </select>

                            </div>
                            @include('inc.livewire_errors',['property'=>'parent_id'])
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch1'>حصة المركز الرئيسي </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch1'  class= 'form-control mt-1 mb-3 @error('branch1') is-invalid @enderror' placeholder = "حصة المركز الرئيسي">
                                @include('inc.livewire_errors',['property'=>'branch1'])
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch2'>حصة فرع مشعل </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch2'  class= 'form-control mt-1 mb-3 @error('branch2') is-invalid @enderror' placeholder = "حصة فرع مشعل">
                                @include('inc.livewire_errors',['property'=>'branch2'])
                            </div>
                        </div>
                         <div class="col-3">
                            <div class="form-group">
                                <label for='branch3'>حصة فرع الوديعة البلدية  </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch3'  class= 'form-control mt-1 mb-3 @error('branch3') is-invalid @enderror' placeholder = "حصة فرع الوديعة البلدية">
                                @include('inc.livewire_errors',['property'=>'branch3'])
                            </div>
                        </div>
                         <div class="col-3">
                            <div class="form-group">
                                <label for='branch4'>حصة فرع سعود الوديعة  </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch4'  class= 'form-control mt-1 mb-3 @error('branch4') is-invalid @enderror' placeholder = "حصة فرع سعود الوديعة">
                                @include('inc.livewire_errors',['property'=>'branch4'])
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch5'>حصة فرع بن علا </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch5'  class= 'form-control mt-1 mb-3 @error('branch5') is-invalid @enderror' placeholder = "حصة فرع بن علا">
                                @include('inc.livewire_errors',['property'=>'branch5'])
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for='branch6'>حصة فرع السوق </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch6'  class= 'form-control mt-1 mb-3 @error('branch6') is-invalid @enderror' placeholder = "حصة فرع السوق">
                                @include('inc.livewire_errors',['property'=>'branch6'])
                            </div>
                        </div>
                       <div class="col-3">
                            <div class="form-group">
                                <label for='branch'>حصة فرع 6 </label><span class="text-danger">*</span>
                                <input type='number' min="0" step="any" wire:model='branch'  class= 'form-control mt-1 mb-3 @error('branch') is-invalid @enderror' placeholder = "حصة فرع 6">
                                @include('inc.livewire_errors',['property'=>'branch'])
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
