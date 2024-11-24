<x-create-modal-component title="إضافة رأس مال">
    @push('css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
        <script>
        $( function() {
    
             
            $( "#date" ).datepicker({
                // dateFormat: "dd/mm/yy" 
            });
  
        } );
        </script>
    @endpush
    <div class="row">
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='amount'>المبلغ</label><span class="text-danger"> *</span>
                <input type="number" min="0" step="any" wire:model='amount' class= 'form-control mt-1 mb-3 @error('amount') is-invalid @enderror' placeholder = "المبلغ">
            </div>
            @include('inc.livewire_errors',['property'=>'amount'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='start_date'>تاريخ الاإضافة</label>
                <input type="text" id="date" wire:model='start_date' class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "تاريخ الإضافة">
            </div>
            @include('inc.livewire_errors',['property'=>'start_date'])
        </div>



        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='partner_id'>الشريك</label><span class="text-danger"> *</span>
                <select wire:model='partner_id' class= 'form-control mt-1 mb-3 @error('partner_id') is-invalid @enderror'>
                    <option value="">إختر الشريك</option>
                    @foreach (App\Models\Partner::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $partner )
                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'partner_id'])
        </div>
        <div class="col-{{ $type == null ? 12 : 6 }} mb-2">
            <div class="form-group">
                <label for='type'>تمت الإضافة إلي</label><span class="text-danger"> *</span>
                <select wire:model.live='type' class= 'form-control mt-1 mb-3 @error('type') is-invalid @enderror'>
                    <option value="">إختر </option>
                    <option value="bank">بنك</option>
                    <option value="treasury">خزينة </option>

                </select>
            </div>
            @include('inc.livewire_errors',['property'=>'type'])
        </div>
        @if($type == 'bank')
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for='bank_id'>البنك</label><span class="text-danger"> *</span>
                    <select wire:model='bank_id' class= 'form-control mt-1 mb-3 @error('bank_id') is-invalid @enderror'>
                        <option value="">إختر البنك</option>
                        @foreach (App\Models\Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $partner )
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'bank_id'])
            </div>
            <div class="col-3 mb-2">
                <div class="form-group">
                    <label for='check_num'>رقم الشيك</label>
                    <input type="text" wire:model='check_num' class= 'form-control mt-1 mb-3 @error('check_num') is-invalid @enderror' placeholder = "رقم الشيك">
                </div>
                @include('inc.livewire_errors',['property'=>'check_num'])
            </div>

        @elseif($type == 'treasury')
            <div class="col-6 mb-2">
                <div class="form-group">
                    <label for='treasury_id'>الخزينة</label><span class="text-danger"> *</span>
                    <select wire:model='treasury_id' class= 'form-control mt-1 mb-3 @error('treasury_id') is-invalid @enderror'>
                        <option value="">إختر الخزينة</option>
                        @foreach (App\Models\treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $partner )
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                @include('inc.livewire_errors',['property'=>'treasury_id'])
            </div>
        @endif
    </div>

</x-create-modal-component>
