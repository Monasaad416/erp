<div class="row" >
         <style>
        .calc table {
            border: none;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .calc input[type="button"] {
            width: 100%;
            padding: 10px 5px;
            background-color: #9a9ca0;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
        }

        /* .calc input[type="text"] {
            padding: 20px 30px;
            font-size: 24px;
            font-weight: bold;
            border: none;
            border-radius: 5px;

        }  */
            .table thead th  {
            text-align: center;
        }
    </style>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title text-danger"> إضافة ايصال تحصيل نقدية </h4>

                </div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="create">
                    @csrf
                    <div class="card-body">
                        <style>
                            tr , .table thead th  {
                                text-align: center;
                            }
                        </style>

                        <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                            @php

                                $ids= [3,11];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);
                                $account = false;
                                if ($desiredSegment == "customers/invoices") {
                                    $account = true;
                                    $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                }
                                $minExchangePoints = App\Models\Setting::find(1)->min_exchange_pos;

                                //  dd($posNum);
                            @endphp

                            {{-- <div class="col-12 mb-2">
                                <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                            </div> --}}
                            @if($account)
                                <div class="col-4 mb-2">
                                    <div class="form-group">
                                        <label for="account_num">{{ trans('admin.account_num') }}</label><span class="text-danger">*</span>
                                        <input type="text" readonly wire:model="account_num" class="form-control @error('account_num') is-invalid @enderror" placeholder="{{ trans('admin.account_num') }}">
                                        @include('inc.livewire_errors', ['property' => 'account_num'])
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <div class="form-group">
                                        <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                                        <select wire:model.live="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
                                            <option>إختر نوع الحساب المالي  </option>
                                            @foreach($accountTypes as $account_type)
                                                <option value="{{$account_type->id}}" {{$account_type->id == $account_type_id ? 'selected' : ''}}>{{$account_type->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('inc.livewire_errors', ['property' => 'account_type_id'])
                                        {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                            <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                        </button> --}}
                                    </div>
                                </div>
                                <div class="col-4 mb-2">
                                    <div class="form-group">
                                        <label for="customer_id"> {{$type}}</label><span class="text-danger">*</span>
                                        <select wire:model.live="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                                            <option>{{trans('admin.select_customer')}}</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}" {{$customer->id == $customer->id ? 'selected' : ''}}>{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('inc.livewire_errors', ['property' => 'customer_id'])

                                    </div>
                                </div>

                            @endif



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="date">تاريخ الحركة</label><span class="text-danger">*</span>
                                    <input type="date" wire:model="date" class="form-control @error('date') is-invalid @enderror" placeholder="{{ trans('admin.inv_date_time') }}">
                                    @include('inc.livewire_errors', ['property' => 'date'])
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                    <select wire:model="transaction_type_id" class="form-control @error('transaction_type_id') is-invalid @enderror">
                                        <option>نوع الحركة المالية</option>
                                        @foreach(App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $trans_type)
                                            <option value="{{$trans_type->id}}" {{$transaction_type_id == $trans_type->id ? 'selected' : ''}}>{{$trans_type->name}}</option>
                                        @endforeach
                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'transaction_type_id'])
                                    {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                    </button> --}}
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ {{$receipt_amount_type}}</label>
                                    <input type="number" disabled min="0" step="any" wire:model.live="receipt_amount" class="form-control @error('receipt_amount') is-invalid @enderror" placeholder="المبلغ {{ $receipt_amount_type }}">
                                    @include('inc.livewire_errors', ['property' => 'receipt_amount'])
                                </div>
                            </div>
                            @if($account)
                                <div class="col-6 mb-2">
                                    <div class="col-12 mb-2 calc">
                                        <div class="form-group">
                                            <label for='unit'>المبلغ المدفوع</label><span class="text-danger"> *</span>
                                            <table id="calcu" >
                                                <tr>
                                                    <td colspan="9">
                                                        <input type="text"  wire:model.live="paid"  class="form-control" readonly id="result">
                                                        @include('inc.livewire_errors',['property'=>'paid'])
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="1" wire:click.live="addDigit('1')"> </td>
                                                    <td><input type="button" value="2" wire:click.live="addDigit('2')"> </td>
                                                    <td><input type="button" value="3" wire:click.live="addDigit('3')"> </td>
                                                    <td><input type="button" value="." wire:click.live="addDigit('.')"> </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="4" wire:click.live="addDigit('4')"> </td>
                                                    <td><input type="button" value="5" wire:click.live="addDigit('5')"> </td>
                                                    <td><input type="button" value="6" wire:click.live="addDigit('6')"> </td>
                                                    <td><input type="button" value="c" wire:click.live="clearQty()" /> </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="button" value="7" wire:click.live="addDigit('7')"> </td>
                                                    <td><input type="button" value="8" wire:click.live="addDigit('8')"> </td>
                                                    <td><input type="button" value="9" wire:click.live="addDigit('9')"> </td>
                                                    <td><input type="button" value="0" wire:click.live="addDigit('0')"> </td>
                                                </tr>
                                            </table>
                                        </div>
                                        @include('inc.livewire_errors',['property'=>'unit'])
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label for="remaining">المتبقي</label>
                                        <input type="number" disabled min="0" step="any" wire:model.live="remaining" class="form-control @error('remaining') is-invalid @enderror" placeholder="المبلغ المتبقي">
                                        @include('inc.livewire_errors', ['property' => 'remaining'])
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                        <label>{{ trans('admin.description') }}</label>
                                        <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ trans('admin.description') }}"></textarea>
                                        @include('inc.livewire_errors', ['property' => 'description'])
                                    </div>
                            </div>


                         @if($account)
                                <div class="col-2 mb-2">
                                    <div class="form-group">
                                        <label for="posNum">عدد نقاط الفاتورة</label>
                                        <input type="number" min="0" readonly wire:model="posNum"  class="form-control @error('posNum') is-invalid @enderror" placeholder="عدد النقاط الفاتورة">
                                        @include('inc.livewire_errors', ['property' => 'posNum'])
                                    </div>
                                </div>
                                <div class="col-2 mb-2">
                                    <div class="form-group">
                                        <label for="points_price">تكلفة النقاط</label>
                                        <input type="text" readonly wire:model="points_price" class="form-control @error('points_price') is-invalid @enderror" placeholder="تكلفة النقاط">
                                        @include('inc.livewire_errors', ['property' => 'points_price'])
                                    </div>
                                </div>
                                <div class="col-{{ $is_exchange==1?3:4 }}" >
                                    <label for="is_available" class="text-{{ $this->is_available == 1 ? 'green' :'danger' }}"> {{ $this->is_available == 1 ? 'متاحة للاستبدال' :'غير متاحة للاستبدال' }} </label>
                                    <div class="input-group mb-3">

                                    <div class="input-group-prepend " >
                                        <div class="input-group-text" >
                                        <input type="checkbox" wire:model="is_available" disabled style="opacity:1;" {{ $this->is_available == 1 ? 'checked' :'' }}>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox"  value="متاحة للاستبدال" readonly>
                                    </div>
                                    @include('inc.livewire_errors',['property'=>'taxes'])
                                </div>
                               
                                    <div class="col-{{ $is_exchange==1?3:4 }}"">
                                        <label for="is_exchange">إستبدال النقاط</label>
                                        <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox"  wire:model.live="is_exchange" {{ $is_available == 0 ? 'disabled':'' }} wire:click.live="recalculateReceiptAmount">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox"  value="إستبدال النقاط" readonly>
                                        </div>
                                        @include('inc.livewire_errors',['property'=>'is_exchange'])
                                    </div>
                                    @if($is_exchange == 1)
                                    <div class="col-2 mb-2">
                                        <div class="form-group">
                                            <label for="points_to_exchange">عدد النقاط للاستبدال</label>
                                            <input type="number" max="posNum" min="0" wire:model.live="points_to_exchange" class="form-control @error('points_to_exchange') is-invalid @enderror" placeholder="عدد النقاط لاستبدال">
                                            @include('inc.livewire_errors', ['property' => 'points_to_exchange'])
                                        </div>
                                    </div>
                                    @endif

                                @endif

                        </div>

                    </div>


                    @if(!$account)
                        <table class="table table-bordered">
                            @php
                                if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                    $accounts = App\Models\Account::select('id',
                                    'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                } else {
                                    $accounts = App\Models\Account::select('id',
                                    'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->where('branch_id',Auth::user()->branch_id)->get();
                                }
                            @endphp
                            <h4 class="card-title text-danger my-3"> إضافة قيد اليومية   </h4>
                            <thead>
                                <tr>
                                    <th scope="col">مدين</th>
                                    <th scope="col">مبلغ المدين</th>
                                    <th scope="col"> الدائن</th>
                                    <th scope="col">مبلغ الدائن</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr wire:ignore>
                                    <td>
                                        <select wire:model="debit" style="width: 100%"  class="form-control @error('debit') is-invalid @enderror">
                                            <option value="">إختر الحساب المدين</option>
                                            @php
                                                $ids = [16,17,18,19,20,21,22]
                                            @endphp
                                            @foreach(App\Models\Account::whereIn('id',$ids)->select('id',
                                            'name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $account)
                                                <option value="{{$account->id}}" > {{$account->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('inc.livewire_errors', ['property' => 'debit'])
                                    </td>
                                    <td>
                                        <input type="number" min="0"  step="any" wire:model="debit_amount" class="form-control inv-fields @error('debit_amount') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'debit_amount'])
                                    </td>
                                    <td>
                                        <input type="number" step="any" readonly  class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" step="any" readonly  class="form-control">
                                    </td>
                                    {{-- <td>
                                        <input type="text" wire:model="description.0" class="form-control inv-fields @error('description.0') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'description.0'])
                                    </td> --}}

                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" readonly  class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" readonly  class="form-control">
                                    </td>
                                    <td>
                                        <select wire:model="credit"  style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 @error('credit') is-invalid @enderror">
                                            <option value="">إختر الحساب الدائن</option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}" > {{$account->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('inc.livewire_errors', ['property' => 'credit'])
                                    </td>
                                    <td>
                                        <input type="number" min="0"  step="any" wire:model="credit_amount" class="form-control inv-fields @error('credit_amount') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'credit_amount'])
                                    </td>
                                    {{--
                                    <td>
                                        <input type="text" wire:model="description.1" class="form-control inv-fields @error('description.1') is-invalid @enderror">
                                        @include('inc.livewire_errors', ['property' => 'description.1'])
                                    </td> --}}

                                </tr>
                            </tbody>
                        </table>
                    @endif


                    <div class="d-flex justify-content-center">
                        <button id="saveWithoutPrint" wire:click="saveWithoutPrint" type="button" class="btn btn-success mx-2">حفظ الإيصال</button>
                        {{-- <div wire:keydown.F10.prevent="saveWithoutPrint"></div> --}}
                        @if($is_account)
                        <button wire:click="saveAndPrintReceipt" type="button" class="btn btn-secondary mx-2">حفظ و طباعة</button>
                        @endif
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>

        window.addEventListener('newDebitCredit', event => {
            $('.select2bs4').select2();
            $(document).ready(function () {
                    $('.select2bs4').select2();

                    $(document).on('change', '.select2bs4', function (e) {

                        console.log(e.target.value);
                        // @this.set('debit', e.target.value);
                        @this.set('credit', e.target.value);
                    });
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'F10') {
            event.preventDefault();
            document.getElementById('saveWithoutPrint').click();

            }
        });


    </script>
</div>
