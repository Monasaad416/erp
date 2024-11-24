<x-show-modal-component title=" إهلاكات الأصل الثابت">

            <div class="card-body">

                @if($depreciations)


                    <style>
                        tr , .table thead th  {
                            text-align: center;
                        }
                    </style>
                    <h5 class="text-success">{{ $assetName }}</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">تاريخ الإهلاك</th>
                                <th scope="col">قيمة الإهلاك</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depreciations as $dep)

                                <tr wire:key="entry-{{$dep->id}}">
                                    <td>{{ $loop->iteration}}</td>
                                    
                                    <td><span class="text-dark">{{ $dep->date }}</span> </td>
                                    <td><span class="text-dark">{{ $dep->amount }}</span> </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="h4 text-muted text-center">{{trans('admin.data_not_found')}}</p>
                @endif


                {{-- <div class="d-flex justify-content-center my-4">
                    {{$depreciations->links()}}
                </div> --}}

            </div>
</x-show-modal-component>