@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> إضافة تسوية جردية لخزينة</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">إضافة تسوية جردية لخزينة</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:treasury-adjustments.add-treasury-adjustment/>
                <livewire:treasury-adjustments.update-treasury-adjustment/>
                <livewire:treasury-adjustments.delete-treasury-adjustment/>
            </div>
        </section>



    </div>
@endsection
