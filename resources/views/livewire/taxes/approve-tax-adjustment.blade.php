<div class="modal" id="adjust_taxes_modal" wire:ignore.self>
    <form wire:submit.prevent="approve">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تسوية الضريبة مع هيأة الزكاة والضريبة والدخل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
    
                <p class="mx-2">هل انت متأكد من تسوية الضريبة عن الفترة من <span class="text-danger">{{ $start_date }}</span> إلي <span class="text-danger">{{ $end_date }}</span> <span class="text-danger"></span></p>
                <div class="modal-body">
                    {{-- <p class="text-{{ $is_adjusted == 1 ? 'success' : 'danger'}} "> {{ trans('admin.current_state')}} {{  $is_adjusted == 1 ? 'تم التسوية' : 'لم تتم التسوية' }}</p> --}}
                    @csrf

                    <div class="row">
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="adjust_date">تاريخ السداد والتسوية مع الهيأة</label><span class="text-danger">*</span>
                                 <input type="date" wire:model="adjust_date" class="form-control @error('adjust_date') is-invalid @enderror" placeholder="تاريخ السداد">
                                @include('inc.livewire_errors', ['property' => 'adjust_date'])
                            </div>
                        </div>
                        @if($is_adjusted == 0) 
                            <div class="col-{{ $payment_method == "bank" ? 4:8}} mb-2">
                                    <div class="form-group">
                                        <label for="payment_method"> إختر المصدر الذي  تم سداد الضرائب منه لاتمام عملية التسوية</label><span class="text-danger">*</span>
                                        <select wire:model.live="payment_method"  class="form-control @error('payment_method') is-invalid @enderror">
                                            <option>إختر طريقة الدفع</option>
                                            <option value="treasury">خزينة الفرع</option>
                                            <option value="bank">بنك</option>
                                        </select>
                                        @include('inc.livewire_errors', ['property' => 'payment_method'])
                                        {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                            <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                        </button> --}}
                                    </div>
                                </div>
                        @endif
                        @if($payment_method == "bank")
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="adjust_date">إختر البنك</label><span class="text-danger">*</span>
                                    <select wire:model="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                        <option value="">إختر البنك</option>
                                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                        @endforeach

                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'bank_id'])
                                </div>
                            </div>
                        @endif
                    </div>  
                    {{-- <input type="hidden" value="{{$category->id}}" wire:model="id"> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
                        <button type="submit" name="submit" class="btn btn-info">تأكيد العملية</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
