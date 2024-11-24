<x-delete-modal-component>
    <div class="modal-body tx-center pd-y-20 pd-x-20">
        <div class="modal-header">
            <h5 class="tx-danger mg-b-20 mx-3 my-3">حذف خصم من قائمة خصومات الموظفين</h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>


        </div>
        <div class="modal-body">

            <p>هل انت متأكد من حذف السلفة الخاصة بالموظف {!! "&nbsp;" !!}{{$advancePaymentName}} </p>
            <p class="text-danger">مبلغ السلفة {!! "&nbsp;" !!}{{$advancePaymentAmount}} {!! "&nbsp;" !!} يبدأ خصمها ابتداءا من شهر{!! "&nbsp;" !!}{{$advancePaymentMonth}}</p>
            

                <div class="form-row">
                    <div class="col">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="submit" class="btn btn-danger">
                        <span wire:loading.remove>
                            {{ trans('admin.delete') }}
                        </span>

                        <div class="text-center" wire:loading wire:target="delete">
                            <div class="spinner-border text-warning" role="status">
                                <span class="sr-only">جاري التنفيذ ...</span>
                            </div>
                        </div>
                    </button>
                </div>

        </div>
    </div>
</x-delete-modal-component>
