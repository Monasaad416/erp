<div>
    <form wire:submit.prevent="approve">
        <div class="row">
            <div class="col-12">
                <hr>
                <div class="row">

                    <table class="table table-bordered" id="supp_inv">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ trans('admin.product_code') }}</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>{{ trans('admin.qty') }}</th>
                                <th>{{ trans('admin.unit') }}</th>
                                <th>سعر الوحدة</th>
                                <th>إجمالي السعر</th>
                                <th>قبول البند</th>
                                <th> الكمية المقبولة</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactionItems as $index => $trans)
                                <tr>
                                    <td style="width: 10px">{{ $loop->iteration }}</td>
                                    <td><p>{{ $trans->product_code}}</p></td>

                                    <td> <p>{{ $trans->product_name_ar}}</p></td>
                                    <td><p>{{ $trans->qty}}</p></td>

                                    <td><p>{{ $trans->unit}}</p></td>
                                    <td><p>{{ $trans->unit_price}}</p></td>

                                    <td><p>{{ $trans->total_price}}</p></td>
                                    <td>
                                        @if($trans->approval == 'pending')
                                        <select class="form-control" wire:model.live="approval.{{ $index }}">
                                            <option value="" selected>إختر حالة القبول</option>
                                            <option value="accepted" {{ isset($approval[$index]) && $approval[$index] === 'accepted' ? 'selected' : '' }}>مقبول</option>
                                            <option value="partially_accepted" {{ isset($approval[$index]) && $approval[$index] === 'partially_accepted' ? 'selected' : '' }}>مقبول جزئيا</option>
                                            <option value="rejected" {{ isset($approval[$index]) && $approval[$index] === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                        </select>
                                        @else
                                        <p>تم التعامل مع التحويل</p>
                                        @endif
                                    </td>

                                    @if(isset($approval[$index]) && $approval[$index] === 'partially_accepted')
                                        <td>
                                            <input type="number" min="0" step="any" max="{{ isset($trans->qty) ? $trans->qty : 0 }}" class="form-control" wire:model="accepted_qty.{{ $index }}">
                                        </td>
                                    @endif

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center">
            <button type="submit"  class="btn btn-info mx-2">حفظ</button>
        </div>
    </form>


</div>

