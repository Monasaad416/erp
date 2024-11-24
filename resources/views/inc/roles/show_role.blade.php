
<div class="modal" id="show_modal_{{ $role->id }}">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">صلاحيات المهمة {!! "&nbsp;" !!}{{ $role->name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <ul>
                                @foreach($role->permissions as $permission)
                               <li>{{$permission->name}}</li>
                                <br/>
                                @endforeach
                            </ul>
     
                        </div>
                        
                    </div>

                </div>
            </div>

        </div>

</div>