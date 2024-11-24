<div class="modal" id="return_modal"  wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ trans('admin.return_all_invoice') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <form wire:submit.prevent="returnInvoice">
                                                    @csrf
                                                        {{-- {{ method_field('delete') }} --}}
                                                    <p class="text-danger font-weight-bold my-3">  {{ trans('admin.sure_return_invoice') }}</p>
                                                    <h5 class="text">{{trans('admin.inv_num')}} : {!! "&nbsp;" !!} {{$supplierInvoiceNum}}</h5>
                             
                                                    <div class="row">
                                                        <div class="col-{{ $return_payment_type == 'by_check' ? 6 : 12}}">
                                                            <select wire:model.live="return_payment_type" class="form-control @error('return_payment_type') is-invalid @enderror">
                                                                <option>طريقة إسترداد المبلغ</option>
                                                                <option value="cash">استرداد كامل المبلغ نقدا</option>
                                                                <option value="by_check">استرداد كامل المبلغ بشيك</option>
                                                                <option value="by_installments">اجل</option>
                                                            </select>
                                                            @include('inc.livewire_errors', ['property' => 'return_payment_type'])
                                                        </div>
                                                        @if($return_payment_type == 'by_check')
                                                        <div class="col">
                                                            <select wire:model.live="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                                                <option>إختر البنك</option>
                                                                @foreach(App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active', 1)->get() as $bank)
                                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @include('inc.livewire_errors', ['property' => 'bank_id'])
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
