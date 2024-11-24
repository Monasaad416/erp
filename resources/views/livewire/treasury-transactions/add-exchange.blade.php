<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title text-danger"> إضافة ايصال صرف نقدية {{$reason }} </h4>

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
                                    $ids= [1,2,12,13];

                                    $previousUrl = url()->previous();
                                    $path = parse_url($previousUrl, PHP_URL_PATH);
                                    $segments = explode('/', $path);
                                    $account = false;
                                    $desiredSegment = implode('/', array_slice($segments, 2,2));
                                    //dd($desiredSegment);
                                    // dd($desiredSegment);
                                    $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    if($desiredSegment == "suppliers/invoices") {
                                        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    
                                        $account= true;
                                    } else {
                                        // $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                        // ->whereIn('id',$ids)->get();
                                    }
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
                                            <select wire:model.live="account_type_id" disabled class="form-control @error('account_type_id') is-invalid @enderror">
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
                                            <label for="supplier_id"> {{$type}}</label><span class="text-danger">*</span>
                                            <select wire:model.live="supplier_id" disabled class="form-control @error('supplier_id') is-invalid @enderror">
                                                <option>{{trans('admin.select_supplier')}}</option>
                                                @foreach($suppliers as $supp)
                                                    <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'supplier_id'])

                                        </div>
                                    </div>
                                @endif
                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                            <select wire:model.live="transaction_type_id" {{ $account ? 'disabled' : '' }} class="form-control @error('transaction_type_id') is-invalid @enderror">
                                                <option>نوع الحركة المالية</option>
                                                @foreach($transactionTypes as $trans_type)
                                                    <option value="{{$trans_type->id}}" {{$transaction_type_id == $trans_type->id ? 'selected' : ''}}>{{$trans_type->name}}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'transaction_type_id'])
                                            {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                                <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                            </button> --}}
                                        </div>
                                    </div>

                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="treasury_balance">رصيد الخزينة المتاح</label>
                                            <input type="number" min="0" step="any" wire:model="treasury_balance" class="form-control @error('treasury_balance') is-invalid @enderror" readonly>
                                            @include('inc.livewire_errors', ['property' => 'treasury_balance'])
                                        </div>
                                    </div>

                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="deserved_account_amount">المبلغ المستحق للحساب</label>
                                            <input type="number" min="0" step="any" wire:model="deserved_account_amount" class="form-control @error('deserved_account_amount') is-invalid @enderror" readonly>
                                            @include('inc.livewire_errors', ['property' => 'deserved_account_amount'])
                                        </div>
                                    </div>

                                    <div class="col-3 mb-2">
                                        <div class="form-group">
                                            <label for="remaining_amount">المبلغ المستحق للفاتورة</label>
                                            <input type="number" min="0" step="any" wire:model="remaining_amount" class="form-control @error('remaining_amount') is-invalid @enderror" readonly>
                                            @include('inc.livewire_errors', ['property' => 'remaining_amount'])
                                        </div>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label for="receipt_amount">المبلغ {{$receipt_amount_type}}</label>
                                            <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control @error('receipt_amount') is-invalid @enderror" placeholder="المبلغ {{ $receipt_amount_type }}">
                                            @include('inc.livewire_errors', ['property' => 'receipt_amount'])
                                        </div>
                                    </div>

                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label>{{ trans('admin.description') }}</label>
                                            <input type="text" wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ trans('admin.description') }}">
                                            @include('inc.livewire_errors', ['property' => 'description'])
                                        </div>
                                    </div>
                                @if(!$account)
                                    <table class="table table-bordered">
                                        @php
                                            if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                                $accounts = App\Models\Account::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                                ->where('is_active',1)->where('is_parent',0)->get();
                                            } else {
                                                $accounts = App\Models\Account::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')
                                                ->where('is_active',1)->where('is_parent',0)->where('branch_id',Auth::user()->branch_id)->get();
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
                                                    <select wire:model="debit" style="width: 100%"  class="form-control select2bs4 @error('debit') is-invalid @enderror">
                                                        <option value="">إختر الحساب المدين</option>
                                                        @foreach($accounts as $account)
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
                                                    <select wire:model="credit"  style="width: 100%" data-live-search="true" class="form-control inv-fields  @error('credit') is-invalid @enderror">
                                                        <option value="">إختر الحساب الدائن</option>
                                                        @php
                                                            $ids = [16,17,18,19,20,21,22]
                                                        @endphp
                                                        @foreach(App\Models\Account::whereIn('id',$ids)->select('id',
                                                        'name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $account)
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

                            </div>

                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                        </div>

                </form>

            </div>
            <script>
                window.addEventListener('newDebitCredit', event => {
                    $('.select2bs4').select2();
                    $(document).ready(function () {
                            $('.select2bs4').select2();

                            $(document).on('change', '.select2bs4', function (e) {

                                console.log(e.target.value);
                                @this.set('debit', e.target.value);
                                //@this.set('credit', e.target.value);

                            });
                    });
                });
            </script>
        </div>
    </div>
</div>
