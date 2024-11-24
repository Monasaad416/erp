<x-update-modal-component title="تعديل بيانات حركة الخزينة">
@if($state == 'صرف')
    @php
        $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    @endphp
    @if($is_account == 1)
        <div class="row">
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="account_num">{{ trans('admin.account_num') }}</label><span class="text-danger">*</span>
                    <input type="text" readonly wire:model="account_num" class="form-control @error('account_num') is-invalid @enderror" placeholder="{{ trans('admin.account_num') }}">
                    @include('inc.livewire_errors', ['property' => 'account_num'])
                </div>
            </div>
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="account_type_id">نوع الحساب المالي </label><span class="text-danger">*</span>
                    <select wire:model="account_type_id" disabled class="form-control @error('account_type_id') is-invalid @enderror">
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
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for="supplier_id"> {{$type}}</label><span class="text-danger">*</span>
                    <select wire:model="supplier_id" disabled class="form-control @error('supplier_id') is-invalid @enderror">
                        <option>{{trans('admin.select_supplier')}}</option>
                        @foreach($suppliers as $supp)
                            <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                        @endforeach
                    </select>
                    @include('inc.livewire_errors', ['property' => 'supplier_id'])

                </div>
            </div>
            <div class="col-3 mb-2">
                        <div class="form-group">
                            <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                            <select wire:model="transaction_type_id" disabled class="form-control @error('transaction_type_id') is-invalid @enderror">
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
        </div>

        <div class="row">
       
                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="treasury_balance">رصيد الخزينة المتاح</label>
                            <input type="number" min="0" step="any"  wire:model="treasury_balance" class="form-control @error('treasury_balance') is-invalid @enderror" readonly>
                            @include('inc.livewire_errors', ['property' => 'treasury_balance'])
                        </div>
                    </div>
                                 <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="deserved_account_amount">المبلغ المستحق للحساب</label>
                                <input type="number" min="0" step="any" wire:model="deserved_account_amount" class="form-control @error('deserved_account_amount') is-invalid @enderror" readonly>
                                @include('inc.livewire_errors', ['property' => 'deserved_account_amount'])
                            </div>
                        </div>




                    <div class="col-4 mb-2">
                        <div class="form-group">
                            <label for="receipt_amount">المبلغ {{$receipt_amount_type}}</label>
                            <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control @error('receipt_amount') is-invalid @enderror" placeholder="المبلغ {{ $receipt_amount_type }}">
                            @include('inc.livewire_errors', ['property' => 'receipt_amount'])
                        </div>
                    </div>
        </div>
    @else
        <div class="row">
            <div class="col">
                <div class="card">


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
                                $ids = [1,2,12,13];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $account = false;
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);

                                if($desiredSegment == "suppliers/invoices/") {
                                    $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();

                                    $account= true;
                                }
                            @endphp

                        {{-- <div class="col-12 mb-2">
                                <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                        </div> --}}
                            @if($account)
                                <div class="row">
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
                                                <select wire:model="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
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
                                                <select wire:model="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                                    <option>{{trans('admin.select_supplier')}}</option>
                                                    @foreach($suppliers as $supp)
                                                        <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                                                    @endforeach
                                                </select>
                                                @include('inc.livewire_errors', ['property' => 'supplier_id'])
                            
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
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
                                            <select wire:model="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
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
                                            <select wire:model="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                                <option>{{trans('admin.select_supplier')}}</option>
                                                @foreach($suppliers as $supp)
                                                    <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'supplier_id'])
                        
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                    <select wire:model="transaction_type_id" class="form-control @error('transaction_type_id') is-invalid @enderror">
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
        
                


                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="treasury_balance">رصيد الخزينة المتاح</label>
                                    <input type="number" min="0" step="any" wire:model="treasury_balance" class="form-control @error('treasury_balance') is-invalid @enderror" readonly>
                                    @include('inc.livewire_errors', ['property' => 'treasury_balance'])
                                </div>
                            </div>



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ {{$receipt_amount_type}}</label>
                                    <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control @error('receipt_amount') is-invalid @enderror" placeholder="المبلغ {{ $receipt_amount_type }}">
                                    @include('inc.livewire_errors', ['property' => 'receipt_amount'])
                                </div>
                            </div>
                            {{-- 
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                                    <select wire:model="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                        <option>{{trans('admin.select_payment_type')}}</option>
                                        <option value="كاش">كاش</option>
                                        <option value="شبكة">{{trans('admin.by_installments')}}</option>
                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'payment_type'])
                                </div>
                            </div> --}}

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                        <label>{{ trans('admin.description') }}</label>
                                        <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ trans('admin.description') }}"></textarea>
                                        @include('inc.livewire_errors', ['property' => 'description'])
                                    </div>
                            </div>

                        </div>

                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif    

@elseif($state == 'تحصيل')
    @php
        $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    @endphp
    @if($is_account == 1)

        
    @else
        <div class="row">
            <div class="col">
                <div class="card">


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
                                $ids = [1,2,12,13];
                                $transactionTypes = App\Models\TransactionType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->whereIn('id',$ids)->get();
                                $previousUrl = url()->previous();
                                $path = parse_url($previousUrl, PHP_URL_PATH);
                                $segments = explode('/', $path);
                                $account = false;
                                $desiredSegment = implode('/', array_slice($segments, 2,2));
                                //dd($desiredSegment);
                                // dd($desiredSegment);

                                if($desiredSegment == "suppliers/invoices/") {
                                    $suppliers = App\Models\Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $accountTypes = App\Models\AccountType::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();

                                    $account= true;
                                }
                            @endphp

                        {{-- <div class="col-12 mb-2">
                                <h3 class="text-muted">{{trans('admin.invoice_info')}}</h3>
                        </div> --}}
                            @if($account)
                                <div class="row">
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
                                                <select wire:model="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
                                                    <option>إختر نوع الحساب المالي  </option>
                                                    @foreach($accountTypes as $account_type)
                                                        <option value="{{$account_type->id}}" {{$account_type->id === $account_type_id ? 'selected' : ''}}>{{$account_type->name}}</option>
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
                                                <select wire:model="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                                    <option>{{trans('admin.select_supplier')}}</option>
                                                    @foreach($suppliers as $supp)
                                                        <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                                                    @endforeach
                                                </select>
                                                @include('inc.livewire_errors', ['property' => 'supplier_id'])
                            
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
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
                                            <select wire:model="account_type_id" class="form-control @error('account_type_id') is-invalid @enderror">
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
                                            <select wire:model="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                                <option>{{trans('admin.select_supplier')}}</option>
                                                @foreach($suppliers as $supp)
                                                    <option value="{{$supp->id}}" {{$supp->id == $supplier->id ? 'selected' : ''}}>{{$supp->name}}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'supplier_id'])
                        
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="transaction_type_id"> نوع الحركة المالية</label><span class="text-danger">*</span>
                                    <select wire:model="transaction_type_id" class="form-control @error('transaction_type_id') is-invalid @enderror">
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
        
                


                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="treasury_balance">رصيد الخزينة المتاح</label>
                                    <input type="number" min="0" step="any" wire:model="treasury_balance" class="form-control @error('treasury_balance') is-invalid @enderror" readonly>
                                    @include('inc.livewire_errors', ['property' => 'treasury_balance'])
                                </div>
                            </div>



                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="receipt_amount">المبلغ {{$receipt_amount_type}}</label>
                                    <input type="number" min="0" step="any" wire:model="receipt_amount" class="form-control @error('receipt_amount') is-invalid @enderror" placeholder="المبلغ {{ $receipt_amount_type }}">
                                    @include('inc.livewire_errors', ['property' => 'receipt_amount'])
                                </div>
                            </div>
                            {{-- 
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for="payment_type">{{ trans('admin.select_payment_type') }}</label><span class="text-danger">*</span>
                                    <select wire:model="payment_type" class="form-control @error('payment_type') is-invalid @enderror">
                                        <option>{{trans('admin.select_payment_type')}}</option>
                                        <option value="كاش">كاش</option>
                                        <option value="شبكة">{{trans('admin.by_installments')}}</option>
                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'payment_type'])
                                </div>
                            </div> --}}

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                        <label>{{ trans('admin.description') }}</label>
                                        <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ trans('admin.description') }}"></textarea>
                                        @include('inc.livewire_errors', ['property' => 'description'])
                                    </div>
                            </div>

                        </div>

                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit"  class="btn btn-success mx-2">حفظ الإيصال</button>
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
</x-update-modal-component>
