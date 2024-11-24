<div class="modal" id="edit_invoice_modal" wire:ignore.self>

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('admin.edit_invoice_item')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="product_code">{{ trans('admin.product_code') }}</label><span class="text-danger">*</span>
                            <input type="text" readonly wire:model.lazy="product_code" wire:change="fetchProductName" class="form-control mt-1 mb-3 @error('product_code') is-invalid @enderror" placeholder="{{ trans('admin.product_code') }}">
                            @include('inc.livewire_errors', ['property' => 'product_code'])
                        </div>
                    </div>


                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="product_name_ar">{{ trans('admin.name_ar') }}</label>
                            <input type="text" wire:model.defer="product_name_ar" class="form-control mt-1 mb-3 @error('product_name_ar') is-invalid @enderror" placeholder="{{ trans('admin.name_ar') }}" readonly>
                            @include('inc.livewire_errors', ['property' => 'product_name_ar'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="product_name_en">{{ trans('admin.name_en') }}</label>
                            <input type="text" wire:model.defer="product_name_en" class="form-control mt-1 mb-3 @error('product_name_en') is-invalid @enderror" placeholder="{{ trans('admin.name_en') }}" readonly>
                            @include('inc.livewire_errors', ['property' => 'product_name_en'])
                        </div>
                    </div>


                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="qty">{{ trans('admin.qty') }}</label><span class="text-danger">*</span>
                            <input type="number" min="0" step="any" wire:model="qty" class="form-control mt-1 mb-3 @error('qty') is-invalid @enderror" placeholder="{{ trans('admin.qty') }}">
                            @include('inc.livewire_errors', ['property' => 'qty'])
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="sale_price">{{ trans('admin.sale_price') }}</label>  {!! "&nbsp;" !!} ({{ trans('admin.without_vat') }})
                            <input type="number" min="0" step="any" wire:model="sale_price" class="form-control mt-1 mb-3 @error('sale_price') is-invalid @enderror" placeholder="{{ trans('admin.sale_price') }}">
                            @include('inc.livewire_errors', ['property' => 'sale_price'])
                        </div>
                    </div>


                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="batch_num">{{ trans('admin.batch_num') }}</label>
                            <input type="text" wire:model="batch_num" class="form-control mt-1 mb-3 @error('batch_num') is-invalid @enderror" placeholder="{{ trans('admin.batch_num') }}">
                            @include('inc.livewire_errors', ['property' => 'batch_num'])
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="submit" class="btn btn-secondary" wire:loading.attr="disabled" wire:click="updateItem">
                        <span wire:loading wire:target="updateItem">
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


   
