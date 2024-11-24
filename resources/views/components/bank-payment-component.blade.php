<div class="modal" id="bank_payment_modal" wire:ignore.self>
    <form wire:submit.prevent="saveBankPayment">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة تفاصيل الدفع البنكي</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{ $slot }}

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                    <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                </div>
            </div>

        </div>
    </form>
</div>