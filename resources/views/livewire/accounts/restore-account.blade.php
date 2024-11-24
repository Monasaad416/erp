{{-- <div class="restore_modal" id="restore_modal" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content tx-size-sm">
            <form wire:submit.prevent="restore">
                @csrf
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                        <div class="modal-header">
                            <h5 class="tx-danger mg-b-20 mx-3 my-3">إستعادة الحساب</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>هل انت متأكد من إستعادة الحساب الخاص ب  {!! "&nbsp;" !!}{{$accountName}} </p>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="hidden" wire:model="productId">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                    <button type="submit" class="btn btn-success">
                                        <span wire:loading.remove>
                                            إستعادة
                                        </span>

                                        <div class="text-center" wire:loading wire:target="restore">
                                            <div class="spinner-border text-warning" role="status">
                                                <span class="sr-only">جاري التنفيذ...</span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                        </div>
                    </div>
            </form>
        </div>
    </div> --}}
{{-- </div> --}}


<div class="modal" id="restore_modal" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content tx-size-sm">
           
                <form wire:submit.prevent="restore">
                    @csrf
                     
                    ssss
                </form>
            
        </div>
    </div>
</div>