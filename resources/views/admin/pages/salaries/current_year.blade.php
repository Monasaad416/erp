@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> رواتب السنة المالية الحالية</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">رواتب السنة المالية الحالية</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:salaries.display-current-year-salaries />
            </div>
        </section>

        {{-- <livewire:salaries.add-salary/>
        <livewire:salaries.update-salary/>
        <livewire:salaries.delete-salary/> --}}
    </div>
@endsection
