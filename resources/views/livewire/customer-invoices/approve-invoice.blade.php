<div class="modal" id="change_state_modal" wire:ignore.self>
    <form wire:submit.prevent="changeApprovalState">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('admin.change_approval_state') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                {{-- {{ dd($category) }}  --}}
                <div class="modal-body">
                    <p>{{ trans('admin.sure_change_approval_state') }} <span class="text-danger">{{ $suppInvNum }}</span></p>
                    <p class="text-{{ $is_approved == 1 ? 'success' : 'danger'}} "> {{ trans('admin.current_state')}} {{  $is_approved == 1 ? trans('admin.is_approved') : trans('admin.not_approved_yet') }}</p>
                    @csrf
                  {{-- <input type="hidden" value="{{$category->id}}" wire:model="id"> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
                        <button type="submit" name="submit" class="btn btn-info">{{ trans('admin.edit') }}</button>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
