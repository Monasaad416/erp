<div class="row">
    <div class="col">
        <div class="card">
           <div class="card-header p-0 border-bottom-0">
                        @php
                            $currentYear = Carbon\Carbon::now()->format('Y');
                            $currentMonthNo = Carbon\Carbon::now()->format('m');
                            $currentFinancialYear = App\Models\FinancialYear::where('year',$currentYear)->first();
                            $currentFinancialMonth = App\Models\FinancialMonth::where('month_id',$currentMonthNo)->first();
                            //dd($currentFinancialYear->months);
                        @endphp
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            @foreach ($currentFinancialYear->months as $month)
                                <li class="nav-item">
                                    <a class="nav-link {{ $month->month_id == $currentMonthNo ? 'active' : '' }} text-{{ $month->month_id == $currentMonthNo ? 'suceess' : 'cyan' }}"  id="custom-tabs-four-{{ $month->month_name }}-tab" data-toggle="pill" href="#custom-tabs-four-{{ $month->month_name }}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">{{ $month->month_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        </div>
             
                            <form wire:submit.prevent="update">
                                <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    @foreach ($currentFinancialYear->months as $currentMonth)
                                    <div class="tab-pane fade {{ $currentMonth->month_id == $currentMonthNo ? 'active show' : '' }}" id="custom-tabs-four-{{ $currentMonth->month_name }}" role="tabpanel" aria-labelledby="custom-tabs-four-{{ $currentMonth->month_name }}-tab">

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
                                                                    @include('inc.users.current_year_salaries')
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
                                                        @include('inc.users.current_year_salaries')
                                                    </div>
                                                </div>


                                            @endif
                                    </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                    <button type="submit" name="submit" class="btn btn-info">{{ trans('admin.edit') }}</button>
                                </div>
                                </div>
                            </form>
                        </div>
        </div>
    </div>








