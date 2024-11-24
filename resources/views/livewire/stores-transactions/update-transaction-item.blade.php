<div class="modal" id="edit_modal" wire:ignore.self>
    <form wire:submit.prevent="update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل كمية بند التحويل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for="qty">{{ trans('admin.qty') }}</label><span class="text-danger">*</span>
                            <input type="number" min="0" step="any" wire:model="qty"  class="form-control mt-1 mb-3 @error('qty') is-invalid @enderror" placeholder="{{ trans('admin.qty') }}">
                            @include('inc.livewire_errors', ['property' => 'qty'])
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="submit" class="btn btn-secondary" wire:loading.attr="disabled">
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
    </form>
</div>




