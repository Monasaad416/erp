<div class="row">
    <div class="col">
        <div class="card">


                                <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">


                                            @if(Auth::user()->roles_name == 'سوبر-ادمن')
                                                    @foreach(App\Models\Branch::select('id',
                                                        'name_'.LaravelLocalization::getCurrentLocale().' as name')->whereNot('id',1)->get() as $branch)


                                                            <p>
                                                                <a class="btn btn-block btn-info" data-toggle="collapseBranch" href="#{{ $branch->name }}" role="button" aria-expanded="false" aria-controls="{{ $branch->name }}">
                                                                    {{ $branch->name }}
                                                                </a>
                                                            </p>

                                                            <div class="collapseBranch" id="{{ $branch->name }}">
                                                                <div class="card card-body">
                                                                    @include('inc.users.prev_year_salaries')
                                                                </div>
                                                            </div>

                                                    @endforeach
                                            @else
                                                @php
                                                    $branch = App\Models\Branch::select('id',
                                                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',Auth::user()->branch_id)->first();
                                                @endphp

                                                <p>
                                                    <a class="btn btn-block btn-info" data-toggle="collapse" href="#{{ $branch->name }}" role="button" aria-expanded="false" aria-controls="{{ $branch->name }}">
                                                        {{ $branch->name }}
                                                    </a>
                                                </p>

                                                <div class="collapse" id="{{ $branch->name }}">
                                                    <div class="card card-body">
                                                        @include('inc.users.prev_year_salaries')
                                                    </div>
                                                </div>


                                            @endif
                                    </div>

                                </div>

                                </div>

                        </div>
        </div>
    </div>








