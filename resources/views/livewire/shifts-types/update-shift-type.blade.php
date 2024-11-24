<x-update-modal-component title="{{trans('admin.edit_shift_type')}}">


    <div class="row">
        <div class="col-12 mb-2">
            <div class="form-group">
                <label for="type">{{ trans('admin.select_shift_type') }}</label><span class="text-danger">*</span>
                <select wire:model="type" class="form-control mt-1 mb-3 @error('type') is-invalid @enderror" disabled>
                    <option>{{trans('admin.select_shift_type')}}</option>
                    <option value="1">{{trans('admin.morning_shift_8')}}</option>
                    <option value="2">{{trans('admin.evening_shift_8')}}</option>
                    <option value="3">{{trans('admin.night_shift_8')}}</option>
                    <option value="4">{{trans('admin.morning_shift_12')}}</option>
                    <option value="5">{{trans('admin.night_shift_12')}}</option>
                </select>
                @include('inc.livewire_errors', ['property' => 'type'])
            </div>
        </div>
    </div>
    <div class="row">    
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='shift_start'>{{trans('admin.shift_start')}}</label>
                <input type="time" wire:model='start' class= 'form-control mt-1 mb-3 @error('shift_start') is-invalid @enderror' placeholder = "{{trans('admin.shift_start')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'start'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='shift_end'>{{trans('admin.shift_end')}}</label>
                <input type="time" wire:model='end' class= 'form-control mt-1 mb-3 @error('shift_end') is-invalid @enderror' placeholder = "{{trans('admin.shift_end')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'end'])
        </div>
        <div class="col-4 mb-2">
            <div class="form-group">
                <label for='total_hours'>{{trans('admin.total_hours')}}</label>
                <input type="number" wire:model='total_hours' readonly class= 'form-control mt-1 mb-3 @error('total_hours') is-invalid @enderror' placeholder = "{{trans('admin.total_hours')}}">
            </div>
            @include('inc.livewire_errors',['property'=>'total_hours'])
        </div>
    </div>

</x-update-modal-component>
