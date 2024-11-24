<x-update-modal-component title="{{trans('admin.edit_shift_type')}}">
        <div>
            <h5 class="text-danger my-3 d-block">{{ trans('admin.delivered_shift_info') }}</h5>

            <div class="row">

                <div class="col-3 mb-2">
                    <div class="form-group">
                        <label for="type">{{ trans('admin.select_shift_type') }}</label><span class="text-danger">*</span>
                        <select wire:model="delivered_shift_id" class="form-control mt-1 mb-3 @error('delivered_shift_id') is-invalid @enderror">
                            <option>{{trans('admin.select_shift_type')}}</option>
                            @foreach($shiftTypes as $deliveredShiftType)
                                <option value="{{$deliveredShiftType->id  }}">{{ $deliveredShiftType->label() }}</option>
                            @endforeach
                        </select>
                        @include('inc.livewire_errors', ['property' => 'delivered_shift_id'])
                    </div>
                </div>


                    {{--
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <label for='total_hours'>{{trans('admin.total_hours')}}</label>
                        <input type="number" min="0" step="any" wire:model='total_hours' class= 'form-control mt-1 mb-3 @error('total_hours') is-invalid @enderror' placeholder = "{{trans('admin.total_hours')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'total_hours'])
                </div> --}}
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='start_shift_cash_balance'>{{trans('admin.start_shift_cash_balance')}}</label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model='start_shift_cash_balance' class= 'form-control mt-1 mb-3 @error('start_shift_cash_balance') is-invalid @enderror' placeholder = "{{trans('admin.start_shift_cash_balance')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'start_shift_cash_balance'])
                </div>
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='end_shift_cash_balance'>{{trans('admin.end_shift_cash_balance')}}</label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model.live='end_shift_cash_balance' class= 'form-control mt-1 mb-3 @error('end_shift_cash_balance') is-invalid @enderror' placeholder = "{{trans('admin.end_shift_cash_balance')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'end_shift_cash_balance'])
                </div>
                <div class="col-2 mb-2">
                    <div class="form-group">
                        <label for='end_shift_cash_balance'>{{trans('admin.end_shift_bank_balance')}}</label><span class="text-danger">*</span>
                        <input type="number" min="0" step="any" wire:model.live='end_shift_bank_balance' class= 'form-control mt-1 mb-3 @error('end_shift_bank_balance') is-invalid @enderror' placeholder = "{{trans('admin.end_shift_bank_balance')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'end_shift_bank_balance'])
                </div>
               <div class="col-3 mb-2">
                         <div class="form-group">
                                <label for="payment_type">البنك المحول اليه</label><span class="text-danger">*</span>
                                <select wire:model="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                    <option value="">إختر البنك</option>
                                    @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $bank)
                                        <option value="{{$bank->id}}" {{$bank->id == $bank_id ? 'selected' : ''}}>{{$bank->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                    @include('inc.livewire_errors',['property'=>'bank_id'])
                </div>

                 {{-- <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for="start_shift_date_time">{{ trans('admin.start_shift_date_time') }}</label><span class="text-danger">*</span>
                        <input type="datetime-local" wire:model="start_shift_date_time" class="form-control mt-1 mb-3 @error('start_shift_date_time') is-invalid @enderror" placeholder="{{ trans('admin.start_shift_date_time') }}">
                        @include('inc.livewire_errors', ['property' => 'start_shift_date_time'])
                    </div>
                </div>


                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for="end_shift_date_time">{{ trans('admin.end_shift_date_time') }}</label><span class="text-danger">*</span>
                        <input type="datetime-local" wire:model="end_shift_date_time" class="form-control mt-1 mb-3 @error('end_shift_date_time') is-invalid @enderror" placeholder="{{ trans('admin.end_shift_date_time') }}">
                        @include('inc.livewire_errors', ['property' => 'end_shift_date_time'])
                    </div>
                </div> --}}
                {{-- <div class="col-3 mb-2">
                    <div class="form-group">
                        <label for='amount_delivered'>{{trans('admin.amount_delivered')}}</label>
                        <input type="number" min="0" step="any" wire:model.live='amount_delivered' class= 'form-control mt-1 mb-3 @error('amount_delivered') is-invalid @enderror' placeholder = "{{trans('admin.amount_delivered')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'amount_delivered'])
                </div> --}}
                {{-- <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for="type">{{ trans('admin.amount_status') }}</label><span class="text-danger">*</span>
                        <select wire:model="amount_status" disabled class="form-control mt-1 mb-3 @error('amount_status') is-invalid @enderror">
                            <option>{{trans('admin.amount_status')}}</option>
                            <option value="1">{{trans('admin.balanced')}}</option>
                            <option value="2">{{trans('admin.shortage')}}</option>
                            <option value="3">{{trans('admin.surplus')}}</option>
                        </select>
                        @include('inc.livewire_errors', ['property' => 'amount_status'])
                    </div>
                </div>
                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for='amount_status_value'>{{trans('admin.amount_status_value')}}</label>
                        <input type="number" rea min="0" step="any"donly wire:model='amount_status_value' class= 'form-control mt-1 mb-3 @error('amount_status_value') is-invalid @enderror' placeholder = "{{trans('admin.amount_status_value')}}">
                    </div>
                    @include('inc.livewire_errors',['property'=>'amount_status_value'])
                </div> --}}

            </div>


            <h5 class="text-success my-3 d-block">{{ trans('admin.delivered_to_shift_info') }}</h5>

            <div class="row">

                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for='delivered_to_user_id'>{{trans('admin.delivered_to_user')}}</label><span class="text-danger">*</span>
                        <select wire:model="delivered_to_user_id" class="form-control mt-1 mb-3 @error('delivered_to_user_id') is-invalid @enderror">
                            <option>إختر مستلم الوردية</option>
                            @foreach (App\Models\User::where('branch_id',Auth::user()->branch_id)->get() as $user )
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @include('inc.livewire_errors', ['property' => 'delivered_to_user_id'])
                    </div>
                </div>


                <div class="col-6 mb-2">
                    <div class="form-group">
                        <label for="type">{{ trans('admin.select_shift_type') }}</label><span class="text-danger">*</span>
                        <select wire:model="delivered_to_shift_id" class="form-control mt-1 mb-3 @error('type') is-invalid @enderror">
                            <option>{{trans('admin.select_shift_type')}}</option>
                            @foreach($shiftTypes as $recievedShiftType)
                                <option value="{{$recievedShiftType->id  }}">{{ $recievedShiftType->label() }}</option>
                            @endforeach
                        </select>
                        @include('inc.livewire_errors', ['property' => 'delivered_to_shift_id'])
                    </div>
                </div>

            </div>

        </div>
</x-update-modal-component>
