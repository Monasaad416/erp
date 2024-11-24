<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title h4">قائمة إهلاكات الاصول الثابتة</h4>

                </div>

            </div>

            <div class="card-body">
                
                    <div class="my-3 d-flex">
                        <input type="text" class="form-control w-25 search_term mx-2" placeholder="بحث بإسم الأصل " wire:model.live="asset_name">
                        @if(Auth::user()->roles_name == 'سوبر-ادمن')
                            <div class="col-4 mb-2">
                                <div class="form-group">
                

                                    <select wire:model='branch_id' style="height: 45px;" class='form-control pb-3 @error('branch_id') is-invalid @enderror'>
                                        <option value=""> البحث بالفرع</option>
                                        @foreach (App\Models\Branch::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get() as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>
                        @endif
                    </div>

                @if($depreciations->count() > 0)

                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاصل</th>
                                <th scope="col">مبلغ الاهلاك</th>
                                <th scope="col">التاريخ</th>
        
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depreciations as $dep)
                                <tr wire:key="category-{{$dep->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="text-dark">{{ $dep->asset->name }}</span> </td>
                               <td><span class="text-dark">{{ $dep->amount }}</span> </td>
                               <td><span class="text-dark">{{ $dep->date }}</span> </td>
    
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                <div class="d-flex justify-content-center my-4">
                    {{$depreciations->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
