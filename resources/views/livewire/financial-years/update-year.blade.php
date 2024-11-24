<x-update-modal-component title="تعديل سنة مالية">
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='year'> السنة مالية</label><span class="text-danger"> *</span>

            <select id="yearSelect" class="form-control mt-1 mb-3 @error('year') is-invalid @enderror" wire:model="year">
                <option value="">--إختر السنة المالية --</option>
                @php
                    $currentYear = date('Y');
                @endphp
                @for ($year = 1990; $year <= $currentYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        @include('inc.livewire_errors',['property'=>'year'])
    </div>
    {{-- <div class="col-12 mb-2">
        <div class="form-group">
            <label for='year_desc'>وصف السنة مالية</label><span class="text-danger"> *</span>
            <input type="text" min="1" wire:model='year_desc' class= 'form-control mt-1 mb-3 @error('year_desc') is-invalid @enderror' placeholder = " وصف السنة مالية">
        </div>
        @include('inc.livewire_errors',['property'=>'year_desc'])
    </div> --}}
    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='start_date'>بداية السنة</label><span class="text-danger"> *</span>
            <input type="date" wire:model='start_date' class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "بداية السنة">
        </div>
        @include('inc.livewire_errors',['property'=>'start_date'])
    </div>


      <div class="col-12 mb-2">
        <div class="form-group">
            <label for='end_date'>نهاية السنة</label><span class="text-danger"> *</span>
            <input type="date" wire:model='end_date' class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "نهاية السنة">
        </div>
        @include('inc.livewire_errors',['property'=>'end_date'])
    </div>

    <div class="col-12 mb-2">
        <div class="form-group">
            <label for='is_opened'>حالة السنة مالية</label><span class="text-danger"> *</span>
            <select wire:model='is_opened' class= 'form-control mt-1 mb-3 @error('type') is-invalid @enderror'>
                <option value="">--إختر حالة السنة مالية --</option>
                <option value="0">غير نشط</option>
                <option value="1">نشط</option>
            </select>
        </div>
        @include('inc.livewire_errors',['property'=>'is_opened'])
    </div>
</x-update-modal-component>
