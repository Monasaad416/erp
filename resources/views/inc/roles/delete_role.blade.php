<div class="modal" id="delete_modal_{{ $role->id }}" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <form method="post" action="{{ route('roles.delete',$role->id) }}">
                @csrf
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <div class="modal-header">
                        <h5 class="tx-danger mg-b-20 mx-3 my-3">حذف مهمة من قائمة المهمات</h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        <p>هل انت متاكد من حذف {!! "&nbsp;" !!}{!! "&nbsp;" !!} {{$role->name}} </p>

                        <div class="form-row">
                            <div class="col">
                                <input type="hidden" wire:model="roleId">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-danger">
                                <span wire:loading.remove>
                                    حذف
                                </span>

                                <div class="text-center" wire:loading wire:target="delete">
                                    <div class="spinner-border text-warning" role="status">
                                        <span class="sr-only">جاري التنفيذ...</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





