<div>

        <div class="row">

            <div class="col-12">

                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for="code"> طريقة الدفع</label><span class="text-danger">*</span>
                            <select  wire:model.live="payment_method" class="form-control mt-1 mb-3 @error('payment_method') is-invalid @enderror">
                                <option value="">إختر طريقة الدفع</option>
                                <option value="cash"> كاش</option>
                                <option value="visa"> شبكة</option>
                            </select>
                            @include('inc.livewire_errors', ['property' => 'payment_method'])
                        </div>
                    </div>

                    <div class="col-12 mb-2">

                        @if($payment_method == 'cash')
                            <livewire:treasury-transactions.add-collection :invoice="$invoice" >
                        @elseif($payment_method == 'visa')
                            <p>الدفع عن طريق الشبكة </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

</div>
