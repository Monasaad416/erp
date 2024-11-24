<div class="modal" id="return_modal"  wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ trans('admin.trans_item_to_returns') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <form wire:submit.prevent="returnInvoiceItem">
                                                    @csrf
                                                        {{-- {{ method_field('delete') }} --}}
                                                    <p class="text-danger font-weight-bold my-3">  {{ trans('admin.sure_trans_item_to_returns') }}</p>
                                                    <h5 class="text">{{trans('admin.inv_num')}} : {!! "&nbsp;" !!} {{$customerInvoiceNum}}</h5>
                                                    <h5 class="text">{{trans('admin.product_name')}} : {!! "&nbsp;" !!} {{App::getLocale() == "ar" ? $ItemNameAr : $ItemNameEn}}</h5>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ trans('admin.close') }}</button>
                                                        <button type="submit" class="btn btn-danger pd-x-20">{{ trans('admin.confirm') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>
