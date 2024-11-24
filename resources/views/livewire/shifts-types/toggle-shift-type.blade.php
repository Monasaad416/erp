<div class="modal" id="change_state_modal" wire:ignore.self>
    <form wire:submit.prevent="toggle">
        @csrf
        {{-- <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('admin.toggle_state') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
      
                <div class="modal-body">
                    <p>{{ trans('admin.sure_change_state') }} <span class="text-danger">{{ $categoryName }}</span></p>
                    <p class="text-{{ $is_active == 1 ? 'success' : 'danger'}} "> {{ trans('admin.current_state')}} {{  $is_active == 1 ? trans('admin.active') : trans('admin.inactive') }}</p>
                    @csrf
              
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
                        <button type="submit" name="submit" class="btn btn-info">{{ trans('admin.edit') }}</button>
                    </div>
                </div>

            </div> --}}

        </div>
    </form>
</div>
