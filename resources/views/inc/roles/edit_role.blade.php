<div class="modal" id="edit_modal_{{ $role->id}}">
    <form method="post" action="{{ route('roles.update', $role->id) }}" >

        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل المهمة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" value="{{ $role->id }}">

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for='name'>الإسم</label><span class="text-danger"> *</span>
                            <input type="text" name='name' readonly value="{{$role->name}}" class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = "إسم المهمة">
                        </div>
                        @include('inc.livewire_errors',['property'=>'name'])
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <strong class="d-block my-2 "> إختر الصلاحيات :</strong>
                            <br/>
                            <input class="mb-4" type="checkbox" name="select-all" id="select-all" />
                            <h5 class="d-inline my-4 text-muted mb-4">إختر الكل</h5>
                            <br>

                            @php
                                $role_permissions = Illuminate\Support\Facades\DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();
                            @endphp
                            
                            @foreach(Spatie\Permission\Models\Permission::all() as $permission)
                                <label>
                                    <label><input  type="checkbox" name="permissions[]" value="{{$permission->name}}" {{ in_array($permission->id, $role_permissions) ? 'checked' : '' }}> {{ $permission->name }}</label>
                                    {{-- <input type="checkbox" wire:model="role_permissions.{{ $permission->id }}" {{ in_array($permission->id ,$role_permissions) ? 'checked':'' }}> --}}
                                </label>
                                <br/>
                            @endforeach

                        </div>

                    </div>



                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-secondary">تعديل </button>
                </div>
            </div>
        </div>
    </form>
</div>
