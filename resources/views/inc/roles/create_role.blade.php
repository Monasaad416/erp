
<div class="modal" id="create_modal">
    {{-- @include('inc.errors') --}}
    <form method="post" action="{{ route('roles.store') }}">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('admin.create_role')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for='name'>{{trans('admin.name')}}</label><span class="text-danger"> *</span>
                            <input type="text" name='name' class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = "إسم المهمة">
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <strong class="d-block my-2 ">{{trans('admin.select_permissions')}}</strong>
                            <br/>
                            <input class="mb-4" type="checkbox" name="select_all" id="select_all" />
                             <h5 class="d-inline my-4 text-muted mb-4">{{trans('admin.select_all')}}</h5> 
                            <br>
                            @foreach(Spatie\Permission\Models\Permission::all() as $permission)
                                <label>
                                    <input type='checkbox' name='permissions[]' value='{{$permission->name}}' >
                                    {{ $permission->name }}
                                </label>
                            <br/>
                            @endforeach
                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="submit" class="btn btn-info">{{ trans('admin.save') }} </button>
                </div>
            </div>

        </div>
    </form>
    @push('scripts')
    <script>
        console.log('out');
        $('#select_all').click(function(event) {
              console.log(event.target);
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@endpush
</div>



