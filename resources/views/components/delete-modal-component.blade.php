<div class="modal" id="delete_modal" wire:ignore.self>
    <div class="modal-dialog " role="document">
        <div class="modal-content tx-size-sm">
           
                <form wire:submit.prevent="delete">
                    @csrf
                     
                     {{$slot}}
                </form>
            
        </div>
    </div>
</div>