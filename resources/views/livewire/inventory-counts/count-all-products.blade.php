
<div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

        @php
            $branches = App\Models\Branch::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
        @endphp

    @endpush

            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">

                        @if($branch_id == null || $from_date == null || $to_date == null)

                        <div class="col-12 mb-2">
                            <h3 class="text-muted">معلومات الجرد</h3>
                        </div>
                        @if(Auth::user()->roles_name == 'سوبر-ادمن')
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'>الفرع</label>

                                    <select wire:model.live='branch_id' style="height: 45px;" class='form-control pb-3 @error('branch_id') is-invalid @enderror'>
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>
                        @endif
                        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 : 6 }} mb-2">
                            <div class="form-group">
                                <label for="from_date">من تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model.live="from_date" class="form-control @error('from_date') is-invalid @enderror" placeholder="من تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'from_date'])
                            </div>
                        </div>
                        <div class="col-{{ Auth::user()->roles_name == 'سوبر-ادمن' ? 4 : 6 }} mb-2">
                            <div class="form-group">
                                <label for="to_date">إلي تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model.live="to_date" class="form-control @error('to_date') is-invalid @enderror" placeholder="إلي تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'to_date'])
                            </div>
                        </div>
                        @endif



                    </div>

                    <hr>
                    <div class="row">
             <div class="col-12 mb-2">
                            @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                @php
                                    $branch = App\Models\Branch::where('id',$branch_id)->first();
                                @endphp
                                @if($branch_id != null || $from_date != null || $to_date != null)
                                    <h5 class="text-muted">بنود الجرد - {{App\Models\Branch::where('id',$branch_id)->first()->name_ar }} - من {{ $from_date}}- إلي   {{$to_date}}  </h5>
                                @else
                                <h3 class="text-muted">بنود الجرد </h3>
                                @endif
                            @else
                                @php
                                    $branch = App\Models\Branch::where('id',Auth::user()->branch_id)->first();
                                @endphp

                                @if($from_date != null || $to_date != null)
                                    <h5 class="text-muted">بنود الجرد - {{App\Models\Branch::where('id',$branch_id)->first() }} - من {{ $from_date}}- إلي   {{$to_date}}  </h5>
                                @else
                                <h3 class="text-muted">بنود الجرد </h3>
                                @endif

                            @endif
                        </div>
                        <style>
                            .table thead tr th{
                                text-align:center;
                                font-size: 12px;
                            }
                        </style>
            <div class="col-12 mb-2">
                    <form wire:submit.prevent="create">
                        <table class="table table-bordered" style="width: 100%" id="supp_inv">
                            <thead class="sticky-top top-0">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 70px">{{ trans('admin.delete') }}</th>
                                    <th style="width: 100px">{{ trans('admin.name') }}</th>
                                    <th style="width: 100px">{{ trans('admin.product_code') }}</th>
                                    <th style="width: 70px">{{ trans('admin.unit') }}</th>
                                    <th style="width: 70px"> أخر سعر شراء</th>
                                    <th style="width: 70px">العدد الفعلي</th>
                                    <th style="width: 70px">العدد بالبرنامج</th>
                                    <th style="width: 70px">عجز/زياد</th>
                                    <th style="width: 70px">كمية العجز/ الزيادة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td style="width: 10px">{{ $index }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" title="حذف"
                                                data-toggle="modal" wire:click="removeItem({{ $loop->iteration}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td style="width: 100px">
                                            <input type="text" readonly wire:model="rows.{{ $index }}.product_name_ar" class="form-control @error('product_name_ar') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_name_ar'])
                                        </td>
                                        <td style="width: 100px">
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                <input type="text" wire:model="rows.{{ $index }}.product_code" wire:keydown.enter.prevent="adjustCode({{ $index }})" class="form-control inv-fields @error('rows.'.$index.'.product_code') is-invalid @enderror">
                                                @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.product_code'])
                                                </span>

                                            </div>
                                        </td>
                                        <td style="width: 70px">
                                            <input type="text" wire:model.defer="rows.{{ $index }}.unit" readonly class="form-control inv-fields @error('unit') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.unit'])
                                        </td>
                                        <td style="width: 70px">
                                            <input type="text" wire:model.defer="rows.{{ $index }}.latest_purchase_price" readonly class="form-control inv-fields @error('latest_purchase_price') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.latest_purchase_price'])
                                        </td>
                                        <td style="width: 70px">
                                            <input type="number" min="0"  step="any"  wire:model="rows.{{ $index }}.actual_qty" wire:input.blur="selectState({{ $index }})"  class="form-control inv-fields @error('actual_qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.actual_qty'])
                                        </td>
                                        <td style="width: 70px">
                                            <input type="number" min="0"  step="any" readonly wire:model="rows.{{ $index }}.system_qty" class="form-control inv-fields @error('system_qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.system_qty'])
                                        </td>
                                        <td style="width: 70px">
                                            <input type="text" wire:model="rows.{{ $index }}.state" readonly class="form-control inv-fields @error('state') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.state'])
                                        </td>

                                        <td style="width: 70px">
                                            <input type="number" step="any" wire:model="rows.{{ $index }}.state_qty" readonly wire:keydown.tab.prevent="focusNextRowInput($event, {{ $index }})" id="state_qty{{ $index }}" class="form-control inv-fields @error('state_qty') is-invalid @enderror">
                                            @include('inc.livewire_errors', ['property' => 'rows.'.$index.'.state_qty'])
                                        </td>


                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <button type="submit"  class="btn btn-success mx-2">{{trans('admin.save')}}</button>
                        </div>
                    </form>
                </div>


                    </div>
                </div>


            </div>



</div>




