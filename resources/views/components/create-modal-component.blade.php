<div class="modal" id="create_modal" wire:ignore.self>
    <form wire:submit.prevent="create">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{ $slot }}

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                    <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                </div>
            </div>

        </div>
    </form>
</div>