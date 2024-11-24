
<div>
    <div class="modal" id="create_modal_first" wire:ignore.self>
        <form wire:submit.prevent="create">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة ضرائب الربع المالي {!! "&nbsp;" !!}</h4>
                        {{-- <h5 class="text-danger mt-1"> من 01/01  إلي  31/03   </h5> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
                        @endphp
                        <div class="row">
                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'> الفرع</label>
                                    <select wire:model="branch_id" class="form-control">
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch )
                                            <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for="quarter"> إختر الربع المالي لحساب الضرائب</label><span class="text-danger">*</span>
                                    <select wire:model="quarter" wire:change.live ="quarterChanged" class="form-control @error('quarter') is-invalid @enderror">
                                        <option>إختر الربع</option>
                                        <option value="1">الربع الأول</option>
                                        <option value="2">الربع الثاني</option>
                                        <option value="3">الربع الثالث</option>
                                        <option value="4">الربع الرابع</option>
                                    </select>
                                    @include('inc.livewire_errors', ['property' => 'quarter'])
                                    {{-- <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_unit')}}">
                                        <span style="font-weight: bolder; font-size:">{{trans('admin.create_unit')}}</span>
                                    </button> --}}
                                </div>
                            </div>

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='start_date' readonly class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'start_date'])
                            </div>

                            <div class="col-3 mb-2">
                                <div class="form-group">
                                    <label for='end_date'>إلي تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='end_date' readonly class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'end_date'])
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- <div class="modal" id="create_modal_sec" wire:ignore.self>
        <form wire:submit.prevent="create">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة ضرائب الربع الثاني {!! "&nbsp;" !!}</h4>
                        <h5 class="text-danger mt-1"> من 01/04  إلي  31/06   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
                        @endphp
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'> الفرع</label>
                                    <select wire:model="branch_id" class="form-control">
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch )
                                            <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='start_date_sec' readonly class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'start_date'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='end_date'>إلي تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='end_date_sec' readonly class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'end_date'])
                            </div>
                            <input type="hidden" wire:model="first_quarter">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="modal" id="create_modal_third" wire:ignore.self>
        <form wire:submit.prevent="create">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة ضرائب الربع الثالث  {!! "&nbsp;" !!}</h4>
                        <h5 class="text-danger mt-1"> من 01/07  إلي  30/09   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
                        @endphp
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'> الفرع</label>
                                    <select wire:model="branch_id" class="form-control">
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch )
                                            <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='start_date_third' readonly class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'start_date'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='end_date'>إلي تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='end_date_third' readonly class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'end_date'])
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="modal" id="create_modal_forth" wire:ignore.self>
        <form wire:submit.prevent="create">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة ضرائب الربع الرابع {!! "&nbsp;" !!}</h4>
                        <h5 class="text-danger mt-1"> من 01/10  إلي  31/12   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $branches = App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
                        @endphp
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'> الفرع</label>
                                    <select wire:model="branch_id" class="form-control">
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch )
                                            <option value="{{$branch->id}}" wire:key="branch-{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='start_date'>من تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='start_date_forth' readonly class= 'form-control mt-1 mb-3 @error('start_date') is-invalid @enderror' placeholder = "{{trans('admin.start_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'start_date'])
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='end_date'>إلي تاريخ</label><span class="text-danger"> *</span>
                                    <input type="date" wire:model='end_date_forth' readonly class= 'form-control mt-1 mb-3 @error('end_date') is-invalid @enderror' placeholder = "{{trans('admin.end_date')}}">
                                </div>
                                @include('inc.livewire_errors',['property'=>'end_date'])
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-info">{{trans('admin.save')}}</button>
                    </div>
                </div>

            </div>
        </form>
    </div> --}}
</div>
