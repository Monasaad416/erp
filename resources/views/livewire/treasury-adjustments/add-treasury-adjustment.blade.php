<div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <style>
     

                    .inv-fields {
            font-size:12px !important;
            font-weight:bolder !important;
        }
        input {
        display: inline-block;
        min-width: fit-content;
        white-space: nowrap;
        overflow-x: hidden;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color:red !important;
        }
        </style>
  

    @endpush
    <div class="row">
        <div class="col">
            <div class="card">
                <form wire:submit.prevent="create">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">
                                @php
                                    $customers = App\Models\Customer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                    $units = App\Models\Unit::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
                                @endphp

                                @php
                                    $treasuries = App\Models\Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                    $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')
                                    ->where('is_active',1)->get();
                                @endphp
                                
                                <fieldset>
                                    <legend>تسجيل العجز / الزيادة</legend>
                                    <div class="row">
                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label for="type">نوع التسوية </label><span class="text-danger">*</span>
                                            <select wire:model.live="type"  class="form-control @error('type') is-invalid @enderror">
                                                <option value="عجز" selected >عجز</option>
                                                <option value="زيادة">زيادة</option>
                                            </select>
                                            @include('inc.livewire_errors', ['property' => 'type'])
                                            {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                                <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                            </button> --}}
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <div class="form-group">
                                            <label for='branch_id'> الفرع</label>
                                            <select wire:model.live="branch_id" class="form-control">
                                                <option value="">إختر الفرع</option>
                                                @foreach ($branches as $branch )
                                                    <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}" {{ $branch->id == Auth::user()->branch_id ? 'selected' :''}} >{{$branch->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        @include('inc.livewire_errors',['property'=>'branch_id'])
                                    </div>
                                    
                                        <table class="table table-bordered">
                                            @php
                                                $parentUpnormalShortageAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('is_active',1)->where('account_num',1237)->first();// عجز غير طبيعي
                                                $parentNormalShortageAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('is_active',1)->where('account_num',515)->first();// عجز طبيعي

                                                    //dd($parentNormalShortageAccount);
                                                if(Auth::user()->roles_name == 'سوبر-ادمن') {
                                    
                                                    $shortageUpnormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentUpnormalShortageAccount->account_num)
                                                    ->where('branch_id',$this->branch_id)->first();//عجز غير طبيعي للفرع

                                    
                                                    $shortageNormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentNormalShortageAccount->account_num)
                                                    ->where('branch_id',$this->branch_id)->first();//عجز طبيعي للفرع
                                                } else {
                                                    $shortageUpnormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentUpnormalShortageAccount->account_num)
                                                    ->where('branch_id',Auth::user()->branch_id)->first();//عجز غير طبيعي للفرع

                                                    $shortageNormalAccount = App\Models\Account::select('id',
                                                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                                                    ->where('parent_account_num', $parentNormalShortageAccount->account_num)
                                                    ->where('branch_id',Auth::user()->branch_id)->first();//عجز طبيعي للفرع
                                                }
                                            @endphp
                                            <h4 class="card-title text-danger my-3"> إضافة قيد العجز / الزيادة   </h4>
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
                                                    @if($type = "عجز" && $branch_id != null)
                                                        <td>
                                                            <select wire:model="credit1"  style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 @error('credit1') is-invalid @enderror">
                                                                <option value="">إختر الحساب المدين</option>
                                                                
                                                                <option value="{{$shortageUpnormalAccount->id}}" > {{$shortageUpnormalAccount->name}}</option>
                                                                <option value="{{$shortageNormalAccount->id}}" > {{$shortageNormalAccount->name}}</option>
                                                                
                                                            </select>
                                                            @include('inc.livewire_errors', ['property' => 'credit1'])
                                                        </td>
                                                    @elseif($type = "زيادة")
                                                        <td>
                                                            <select wire:model="debit1" style="width: 100%"  class="form-control @error('debit1') is-invalid @enderror">
                                                                <option value="">إختر الحساب المدين</option>
                                                                @php
                                                                    $ids = [16,17,18,19,20,21,22]
                                                                @endphp
                                                                @foreach(App\Models\Account::whereIn('id',$ids)->select('id',
                                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $account)
                                                                    <option value="{{$account->id}}" > {{$account->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @include('inc.livewire_errors', ['property' => 'debit1'])
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <input type="number" min="0"  step="any" wire:model="debit_amount1" class="form-control inv-fields @error('debit_amount1') is-invalid @enderror">
                                                        @include('inc.livewire_errors', ['property' => 'debit_amount1'])
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" readonly  class="form-control">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly  class="form-control">
                                                    </td>
                                                    <td>
                                                        {{-- <select wire:model="credit1"  style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 @error('credit1') is-invalid @enderror">
                                                            <option value="">إختر الحساب الدائن</option>
                                                            @foreach($accounts as $account)
                                                                <option value="{{$account->id}}" > {{$account->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @include('inc.livewire_errors', ['property' => 'credit1']) --}}
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0"  step="any" wire:model="credit_amount1" class="form-control inv-fields @error('credit_amount1') is-invalid @enderror">
                                                        @include('inc.livewire_errors', ['property' => 'credit_amount1'])
                                                    </td>
                                                    {{--
                                                    <td>
                                                        <input type="text" wire:model="description.1" class="form-control inv-fields @error('description.1') is-invalid @enderror">
                                                        @include('inc.livewire_errors', ['property' => 'description.1'])
                                                    </td> --}}

                                                </tr>
                                            </tbody>
                                        </table>


                                                <hr>
                            


                                    </div>
                                </fieldset>    
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" wire:submit="submit" class="btn btn-danger mx-2 px-3">إضافة تسوية الخزينة</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>                     


   

</div>
