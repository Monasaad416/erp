<x-create-modal-component title="إضافة قيد يومية">
        @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        </style>

    @endpush
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
                <thead>
                    <tr>
                        <th scope="col">مدين</th>
                        <th scope="col">مبلغ المدين</th>
                        <th scope="col"> الدائن</th>
                        <th scope="col">مبلغ الدائن</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select wire:model="debit" style="width: 100%" data-live-search="true" class="form-control inv-fields select2bs4 @error('debit') is-invalid @enderror">
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


</x-create-modal-component>

