<div class="modal" id="import_modal" wire:ignore.self>
    <form wire:submit.prevent="storeImportedProdcts">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إستيراد المنتجات من ملف EXCEL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for='name'>تحميل الملف</label><span class="text-danger"> *</span>
                            <input type="file" wire:model='file' class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror'>
                        </div>
                        @include('inc.livewire_errors',['property'=>'file'])
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ </button>
                </div>
            </div>
        </div>
    </form>
</div>
 