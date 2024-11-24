<div class="modal" id="return_partially_modal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">رد جزئي للبند</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <form wire:submit.prevent="returnInvoiceItemPartially">
                                                    @csrf
                                                        {{-- {{ method_field('delete') }} --}}
                                                    <p class="text-danger font-weight-bold my-3">  {{ trans('admin.sure_partially_trans_item_to_returns') }}</p>
                                                    <h5 class="text">{{trans('admin.inv_num')}} : {!! "&nbsp;" !!} {{$supplierInvoiceNum}}</h5>
                                                    <h5 class="text">{{trans('admin.product_name')}} : {!! "&nbsp;" !!} {{App::getLocale() == "ar" ? $itemNameAr : $itemNameEn}}</h5>
                                                   
                                                    <div class="row">
                                                        <div class="col-6">
                                                             <input type="number" min="0"  step="any" class="form-control @error('qty') is-invalid @enderror" wire:model="qty" class="form-control"  placeholder="{{ trans('admin.return_qty') }}">
                                                             @include('inc.livewire_errors', ['property' => 'qty'])
                                                        </div>
                                                        <div class="col-6">
                                                            <select wire:model.live="return_payment_type" class="form-control @error('return_payment_type') is-invalid @enderror">
                                                                <option>طريقة إسترداد المبلغ</option>
                                                                <option value="cash">استرداد كامل المبلغ نقدا</option>
                                                                <option value="by_check">استرداد كامل المبلغ بشيك</option>
                                                                <option value="by_installments">اجل</option>
                                                            </select>
                                                            @include('inc.livewire_errors', ['property' => 'return_payment_type'])
                                                        </div>
                                                        @if($return_payment_type == "by_check" )
                                             
                                                            <div class="col-6 mt-4">
                                                                <select wire:model.live="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                                                    <option>إختر البنك</option>
                                                                   @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                                                                        <option value="{{ $bank->id }}">{{$bank->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @include('inc.livewire_errors', ['property' => 'bank_id'])
                                                            </div>
                                                            <div class="col-6 mt-4" >  
                                                                <input type="text" wire:model="check_num" class="form-control @error('bank_id') is-invalid @enderror"  placeholder="رقم الشيك">                                                               
                                                                @include('inc.livewire_errors', ['property' => 'check_num'])
                                                            </div>
                                                
                                      
                                                        @endif
                                                    </div>
                                                   
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ trans('admin.close') }}</button>
                                                        <button type="submit" class="btn btn-danger pd-x-20">{{ trans('admin.confirm') }}</button>
                                                    </div>
                                                    {{-- <input type="hidden" name="invoice_id" value="{{$suppInvoice->id}}"> --}}
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
